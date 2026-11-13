<?php

use App\Http\Controllers\KontakController;
use App\Http\Controllers\SitusController;
use Illuminate\Support\Facades\Route;

// Halaman publik (sesuai frame "Publik — ..." di desain Figma)
Route::controller(SitusController::class)->group(function () {
    Route::get('/', 'beranda')->name('beranda');
    Route::get('/profil', 'profil')->name('profil');
    Route::get('/guru', 'guru')->name('guru');
    Route::get('/pengumuman', 'pengumuman')->name('pengumuman.index');
    Route::get('/pengumuman/{pengumuman}', 'detailPengumuman')->name('pengumuman.show');
    Route::get('/berita', 'berita')->name('berita.index');
    Route::get('/berita/{berita}', 'detailBerita')->name('berita.show');
    Route::get('/galeri', 'galeri')->name('galeri');
    Route::get('/ppdb', 'ppdb')->name('ppdb');
    Route::get('/kontak', 'kontak')->name('kontak');
});

// Formulir kontak: maksimal 5 kiriman per menit per pengunjung (cegah spam)
Route::post('/kontak', [KontakController::class, 'kirim'])
    ->middleware('throttle:5,1')
    ->name('kontak.kirim');

// Halaman admin (/admin) diatur oleh Filament: app/Providers/Filament/AdminPanelProvider.php
