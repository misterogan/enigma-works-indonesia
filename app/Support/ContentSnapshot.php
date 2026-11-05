<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Salinan isi website (tabel konten + gambar unggahan) di dalam repositori,
 * agar database production bisa diisi sama persis dengan database lokal.
 *
 * File: database/seeders/data/content.json dan database/seeders/data/media/
 */
class ContentSnapshot
{
    /**
     * Tabel konten beserta kolom kunci alaminya (dipakai untuk mencocokkan baris).
     *
     * @var array<string, string>
     */
    public const TABLES = [
        'settings' => 'key',
        'services' => 'slug',
        'cities' => 'slug',
        'case_studies' => 'slug',
        'portfolio_items' => 'name',
        'faqs' => 'question',
        'posts' => 'slug',
    ];

    /** Folder unggahan di disk public yang ikut disalin. */
    public const MEDIA_DIR = 'uploads';

    public static function path(string $file = ''): string
    {
        return database_path('seeders/data'.($file !== '' ? '/'.$file : ''));
    }

    public static function exists(): bool
    {
        return File::exists(static::path('content.json'));
    }

    /**
     * Tulis isi database saat ini ke file snapshot.
     *
     * @return array{rows: array<string, int>, media: int}
     */
    public static function export(): array
    {
        $data = [];
        $rows = [];

        foreach (array_keys(static::TABLES) as $table) {
            $data[$table] = DB::table($table)->orderBy('id')->get()
                ->map(fn (object $row) => collect((array) $row)->except(['id'])->all())
                ->all();
            $rows[$table] = count($data[$table]);
        }

        File::ensureDirectoryExists(static::path());
        File::put(
            static::path('content.json'),
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n"
        );

        $mediaTarget = static::path('media/'.static::MEDIA_DIR);
        File::deleteDirectory($mediaTarget);
        File::ensureDirectoryExists($mediaTarget);

        // Hanya gambar yang masih dipakai konten, agar unggahan lama yang sudah dihapus dari konten tidak ikut tersebar
        preg_match_all('#'.static::MEDIA_DIR.'/[A-Za-z0-9._/-]+\.[A-Za-z0-9]+#', json_encode($data, JSON_UNESCAPED_SLASHES), $matches);
        $used = array_unique($matches[0]);

        $media = 0;
        foreach (Storage::disk('public')->allFiles(static::MEDIA_DIR) as $file) {
            if (! in_array($file, $used, true)) {
                continue;
            }
            File::ensureDirectoryExists(dirname(static::path('media/'.$file)));
            File::copy(Storage::disk('public')->path($file), static::path('media/'.$file));
            $media++;
        }

        return ['rows' => $rows, 'media' => $media];
    }

    /**
     * Isi database dari file snapshot.
     *
     * Tanpa $overwrite, baris yang sudah ada (berdasarkan kunci alami) tidak diubah,
     * sehingga perubahan yang dibuat lewat backoffice production tetap aman.
     *
     * @return array{rows: array<string, int>, media: int}
     */
    public static function import(bool $overwrite = false): array
    {
        $data = json_decode(File::get(static::path('content.json')), true, flags: JSON_THROW_ON_ERROR);
        $rows = [];

        DB::transaction(function () use ($data, $overwrite, &$rows) {
            foreach (static::TABLES as $table => $key) {
                $rows[$table] = 0;

                foreach ($data[$table] ?? [] as $row) {
                    $match = [$key => $row[$key]];
                    $exists = DB::table($table)->where($match)->exists();

                    if ($exists && ! $overwrite) {
                        continue;
                    }

                    DB::table($table)->updateOrInsert($match, collect($row)->except([$key])->all());
                    $rows[$table]++;
                }
            }
        });

        $media = 0;
        $source = static::path('media');
        if (File::isDirectory($source)) {
            foreach (File::allFiles($source) as $file) {
                $target = str_replace('\\', '/', $file->getRelativePathname());
                if ($overwrite || ! Storage::disk('public')->exists($target)) {
                    Storage::disk('public')->put($target, $file->getContents());
                    $media++;
                }
            }
        }

        Cache::forget('site.settings');

        return ['rows' => $rows, 'media' => $media];
    }
}
