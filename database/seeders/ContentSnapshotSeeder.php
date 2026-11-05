<?php

namespace Database\Seeders;

use App\Support\ContentSnapshot;
use Illuminate\Database\Seeder;

/**
 * Mengisi database dari snapshot hasil `php artisan content:export`.
 * Baris yang sudah ada tidak ditimpa, jadi aman dijalankan di setiap deploy.
 */
class ContentSnapshotSeeder extends Seeder
{
    public function run(): void
    {
        if (ContentSnapshot::exists()) {
            ContentSnapshot::import();
        }
    }
}
