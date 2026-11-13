<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Pengumuman;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Memastikan semua halaman publik dan admin bisa dibuka tanpa error.
 * Jalankan: php artisan test
 */
class HalamanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_halaman_publik_bisa_dibuka(): void
    {
        $halaman = [
            '/', '/profil', '/guru', '/guru?bidang=Guru+Kelas+1',
            '/pengumuman', '/pengumuman?kategori=Akademik',
            '/pengumuman/' . Pengumuman::first()->slug,
            '/berita', '/berita?kategori=Sekolah&cari=baca',
            '/berita/' . Berita::first()->slug,
            '/galeri', '/ppdb', '/kontak',
        ];

        foreach ($halaman as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_berita_belum_terbit_tidak_bisa_dibuka(): void
    {
        $berita = Berita::first();
        $berita->update(['diterbitkan' => false]);

        $this->get('/berita/' . $berita->slug)->assertNotFound();
    }

    public function test_halaman_admin_butuh_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_halaman_admin_bisa_dibuka_oleh_admin(): void
    {
        $this->actingAs(User::first());

        $halaman = [
            '/admin', '/admin/profil', '/admin/ppdb',
            '/admin/guru', '/admin/guru/create',
            '/admin/berita', '/admin/berita/create', '/admin/berita/' . Berita::first()->slug . '/edit',
            '/admin/pengumuman', '/admin/pengumuman/create', '/admin/pengumuman/' . Pengumuman::first()->slug . '/edit',
            '/admin/galeri', '/admin/galeri/create',
            '/admin/pesan-masuk',
        ];

        foreach ($halaman as $url) {
            $this->get($url)->assertOk();
        }
    }
}
