<?php

namespace App\Providers;

use App\Models\ProfilSekolah;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Data profil sekolah (nama, logo, kontak, medsos) tersedia sebagai $profil
        // di semua halaman publik, misalnya untuk header dan footer.
        View::composer('situs.*', function ($view) {
            static $profil = null;
            $profil ??= Schema::hasTable('profil_sekolah') ? ProfilSekolah::data() : new ProfilSekolah;

            $view->with('profil', $profil);
        });
    }
}
