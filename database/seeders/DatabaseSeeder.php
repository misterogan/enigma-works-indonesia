<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun backoffice. Ubah lewat .env: ADMIN_EMAIL dan ADMIN_PASSWORD
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@enigmaworks.co.id')],
            ['name' => 'Admin', 'password' => Hash::make(env('ADMIN_PASSWORD', 'ganti-password-ini'))]
        );

        $this->call(ContentSeeder::class);
    }
}
