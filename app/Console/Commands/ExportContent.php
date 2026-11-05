<?php

namespace App\Console\Commands;

use App\Support\ContentSnapshot;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('content:export')]
#[Description('Simpan isi website (database + gambar unggahan) ke database/seeders/data agar ikut ter-commit')]
class ExportContent extends Command
{
    public function handle(): int
    {
        $result = ContentSnapshot::export();

        $this->table(['Tabel', 'Baris'], collect($result['rows'])->map(fn (int $count, string $table) => [$table, $count])->values());
        $this->components->info("Snapshot tersimpan, {$result['media']} gambar disalin. Commit folder database/seeders/data lalu push.");

        return self::SUCCESS;
    }
}
