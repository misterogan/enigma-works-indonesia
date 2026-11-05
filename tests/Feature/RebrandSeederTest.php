<?php

namespace Tests\Feature;

use App\Models\CaseStudy;
use App\Models\Faq;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\ContentSeeder;
use Database\Seeders\RebrandSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RebrandSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_rebrand_updates_content_but_keeps_owner_edits(): void
    {
        $this->seed(ContentSeeder::class);
        Setting::put(['logo' => 'uploads/logo-saya.png', 'email' => 'saya@contoh.id', 'seo_title' => 'Judul lama']);
        PortfolioItem::create(['name' => 'RS Contoh Mitra', 'label' => 'Pengguna platform mitra, Makassar', 'is_own' => false, 'sort' => 9, 'is_active' => true]);
        PortfolioItem::where('name', 'RSU Serenapita')->update(['image' => 'uploads/serenapita.jpg']);
        Faq::create(['question' => 'Apakah tersedia kontrak maintenance?', 'answer' => 'Lama', 'is_active' => true]);
        Service::where('slug', 'simrs')->update(['name' => 'Nama lama']);
        CaseStudy::where('slug', 'rsu-serenapita')->update(['image' => 'uploads/kasus.jpg', 'quote_approved' => true]);
        $this->travel(5)->minutes();
        $editedPost = Post::first();
        $editedPost->update(['title' => 'Judul disunting di backoffice']);

        $this->seed(RebrandSeeder::class);
        $this->seed(RebrandSeeder::class);

        $this->assertSame('uploads/logo-saya.png', Setting::get('logo'));
        $this->assertSame('saya@contoh.id', Setting::get('email'));
        $this->assertSame(config('admin.settings.seo.fields.0.default'), Setting::get('seo_title'));
        $this->assertSame('SIMRS Enigma Health', Service::where('slug', 'simrs')->value('name'));
        $this->assertDatabaseMissing('portfolio_items', ['name' => 'RS Contoh Mitra']);
        $this->assertSame('uploads/serenapita.jpg', PortfolioItem::where('name', 'RSU Serenapita')->value('image'));
        $this->assertFalse(Faq::where('question', 'Apakah tersedia kontrak maintenance?')->value('is_active'));
        $this->assertSame(6, Faq::where('is_active', true)->count());

        $case = CaseStudy::where('slug', 'rsu-serenapita')->first();
        $this->assertSame('uploads/kasus.jpg', $case->image);
        $this->assertFalse($case->quote_approved);

        $this->assertSame('Judul disunting di backoffice', $editedPost->fresh()->title);
    }

    public function test_public_and_admin_pages_render_after_seeding(): void
    {
        $this->seed();

        foreach (['/', '/layanan', '/layanan/simrs', '/layanan/bridging-bpjs', '/it-rumah-sakit/medan', '/studi-kasus', '/studi-kasus/rsu-serenapita', '/blog', '/tentang-kami', '/kontak', '/sitemap.xml'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('Pengguna ');
        }
        $this->get('/blog/'.Post::published()->value('slug'))->assertOk();
        $this->get('/layanan/simrs')->assertSee('"SoftwareApplication"', false);

        $this->actingAs(User::firstOrFail());
        foreach (['/admin', '/admin/pengaturan', '/admin/services', '/admin/portfolio', '/admin/posts'] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
