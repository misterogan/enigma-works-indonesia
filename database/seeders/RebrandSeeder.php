<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\City;
use App\Models\Faq;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Menerapkan merek Enigma Health ke database yang sudah terisi.
 *
 * Jalankan: php artisan db:seed --class=RebrandSeeder
 *
 * Isian milik pemilik website (logo, gambar, email, media sosial) dan artikel
 * yang sudah disunting di backoffice tidak diubah.
 */
class RebrandSeeder extends Seeder
{
    /**
     * Pengaturan yang tidak ditimpa.
     *
     * @var list<string>
     */
    public const KEEP_SETTINGS = ['logo', 'og_image', 'logo_height', 'show_company_name', 'email', 'linkedin', 'instagram', 'youtube'];

    public function run(): void
    {
        DB::transaction(function () {
            $this->settings();
            $this->services();
            $this->cities();
            $this->caseStudy();
            $this->portfolio();
            $this->faqs();
        });

        $refreshed = $this->refreshUneditedPosts();
        $posts = ContentSeeder::seedPosts();
        Cache::forget('site.settings');

        $this->command?->info("Rebrand selesai. Artikel baru: {$posts}, artikel lama diperbarui: {$refreshed}.");
    }

    /**
     * Artikel lama yang belum pernah disunting di backoffice (updated_at sama dengan created_at)
     * diperbarui dari file Markdown. Artikel yang sudah disunting dibiarkan.
     */
    protected function refreshUneditedPosts(): int
    {
        $refreshed = 0;

        foreach (ContentSeeder::postFiles() as $slug => $attributes) {
            $post = Post::where('slug', $slug)->first();
            if (! $post || ! $post->updated_at?->equalTo($post->created_at)) {
                continue;
            }
            $post->fill(collect($attributes)->only(['title', 'description', 'body'])->all());
            if ($post->isDirty()) {
                $post->save();
                $refreshed++;
            }
        }

        return $refreshed;
    }

    protected function settings(): void
    {
        foreach (ContentSeeder::settingDefaults() as $key => $value) {
            if (in_array($key, self::KEEP_SETTINGS, true)) {
                Setting::firstOrCreate(['key' => $key], ['value' => $value]);

                continue;
            }
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    protected function services(): void
    {
        foreach (ContentSeeder::serviceItems() as $i => $item) {
            $service = Service::firstOrNew(['slug' => $item['slug']]);
            $service->fill($item);
            if (! $service->exists) {
                $service->fill(['sort' => $i + 1, 'is_active' => true]);
            }
            $service->save();
        }
    }

    protected function cities(): void
    {
        $sort = City::max('sort') ?? 0;

        foreach (ContentSeeder::cityItems() as $item) {
            $city = City::firstOrNew(['slug' => $item['slug']]);
            $city->fill($item);
            if (! $city->exists) {
                $city->sort = ++$sort;
            }
            $city->save();
        }

        foreach (ContentSeeder::otherCities() as $name) {
            City::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'has_page' => false, 'sort' => ++$sort]);
        }
    }

    /** Gambar yang sudah diunggah dipertahankan; testimoni tetap draf. */
    protected function caseStudy(): void
    {
        $item = ContentSeeder::caseStudyItem();
        $case = CaseStudy::firstOrNew(['slug' => $item['slug']]);
        $case->fill(collect($item)->except(['image', 'sort', 'is_active'])->all());
        $case->quote_approved = false;
        if (! $case->exists) {
            $case->fill(['sort' => $item['sort'], 'is_active' => $item['is_active']]);
        }
        $case->save();
    }

    protected function portfolio(): void
    {
        // Portofolio lama milik mitra teknologi: bukan proyek sendiri dan berlabel "Pengguna ..."
        PortfolioItem::where('is_own', false)->where('label', 'like', 'Pengguna %')->delete();

        foreach (ContentSeeder::portfolioItems() as $i => $item) {
            $portfolio = PortfolioItem::firstOrNew(['name' => $item['name']]);
            if ($portfolio->exists) {
                // Hanya perbarui teks; gambar, link, urutan, dan status tayang hasil suntingan tetap
                $portfolio->fill(collect($item)->only(['label', 'text', 'is_own'])->all());
            } else {
                $portfolio->fill($item + ['sort' => $i + 1]);
            }
            $portfolio->save();
        }
    }

    protected function faqs(): void
    {
        $current = ContentSeeder::faqItems();

        foreach ($current as $i => [$question, $answer]) {
            Faq::updateOrCreate(['question' => $question], ['answer' => $answer, 'sort' => $i + 1, 'is_active' => true]);
        }

        $retired = array_diff(ContentSeeder::retiredFaqs(), array_column($current, 0));
        Faq::whereIn('question', $retired)->update(['is_active' => false]);
    }
}
