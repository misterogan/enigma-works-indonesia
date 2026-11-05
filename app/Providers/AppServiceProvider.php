<?php

namespace App\Providers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tanggal tampil dalam bahasa Indonesia, misalnya "26 Oktober 2026"
        Carbon::setLocale('id');

        // Di semua view: $set('kunci', 'cadangan') untuk membaca pengaturan dari backoffice
        View::share('set', fn (string $key, $default = null) => Setting::get($key, $default));
    }
}
