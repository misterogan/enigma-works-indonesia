<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
| Website publik
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/layanan', [PageController::class, 'services'])->name('services.index');
Route::get('/layanan/{slug}', [PageController::class, 'service'])->where('slug', '[a-z0-9-]+')->name('services.show');
Route::get('/it-rumah-sakit/{slug}', [PageController::class, 'city'])->where('slug', '[a-z0-9-]+')->name('cities.show');
Route::get('/studi-kasus', [PageController::class, 'caseStudies'])->name('cases.index');
Route::get('/studi-kasus/{slug}', [PageController::class, 'caseStudy'])->where('slug', '[a-z0-9-]+')->name('cases.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/kategori/{category}', [BlogController::class, 'index'])->where('category', '[a-z0-9-]+')->name('blog.category');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('blog.show');
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

/*
| Backoffice: /admin
*/
Route::get('/admin/login', [AuthController::class, 'show'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    $resources = implode('|', array_keys(config('admin.resources')));

    Route::get('/', DashboardController::class)->name('dashboard');
    Route::get('/pengaturan/{group?}', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('/pengaturan/{group}', [SettingController::class, 'update'])->name('settings.update');

    Route::where(['resource' => $resources])->group(function () {
        Route::get('/{resource}', [ResourceController::class, 'index'])->name('resource.index');
        Route::get('/{resource}/baru', [ResourceController::class, 'create'])->name('resource.create');
        Route::post('/{resource}', [ResourceController::class, 'store'])->name('resource.store');
        Route::get('/{resource}/{id}/ubah', [ResourceController::class, 'edit'])->whereNumber('id')->name('resource.edit');
        Route::put('/{resource}/{id}', [ResourceController::class, 'update'])->whereNumber('id')->name('resource.update');
        Route::delete('/{resource}/{id}', [ResourceController::class, 'destroy'])->whereNumber('id')->name('resource.destroy');
    });
});
