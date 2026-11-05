<?php

namespace App\Console\Commands;

use App\Support\ContentSnapshot;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('content:import {--overwrite : Timpa baris dan gambar yang sudah ada dengan isi snapshot}')]
#[Description('Isi database dari snapshot di database/seeders/data (hasil content:export)')]
class ImportContent extends Command
{
    public function handle(): int
    {
        if (! ContentSnapshot::exists()) {
            $this->components->error('Snapshot belum ada. Jalankan php artisan content:export di komputer lokal.');

            return self::FAILURE;
        }

        if ($this->option('overwrite') && $this->laravel->isProduction()
            && ! $this->confirm('Isi yang diubah lewat backoffice production akan ditimpa. Lanjutkan?', true)) {
            return self::FAILURE;
        }

        $result = ContentSnapshot::import((bool) $this->option('overwrite'));

        $this->table(['Tabel', 'Baris diisi'], collect($result['rows'])->map(fn (int $count, string $table) => [$table, $count])->values());
        $this->components->info("{$result['media']} gambar disalin ke storage.");

        return self::SUCCESS;
    }
}
