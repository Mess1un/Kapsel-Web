<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Isi database awal: akun admin + contoh konten untuk pengujian.
     * Jalankan: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        // Email & password admin diambil dari file .env (ADMIN_EMAIL, ADMIN_PASSWORD).
        // Ganti password setelah login pertama, terutama sebelum website di-online-kan.
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@sekolah.test')],
            [
                'name' => env('ADMIN_NAME', 'Admin Sekolah'),
                'password' => env('ADMIN_PASSWORD', 'ganti-password-ini'),
            ],
        );

        $this->call(ContohDataSeeder::class);
    }
}
