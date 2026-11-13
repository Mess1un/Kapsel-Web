# Web Profil Sekolah — Panduan Backend

Dibuat dengan **Laravel 13** + **Filament 5** (panel admin). Dijalankan dengan **Laragon** (Apache + MySQL 8.4), database MySQL bernama `kapsel_web`.

## Menjalankan di komputer

Folder proyek: `C:\laragon\www\kapsel-web` (jangan simpan di OneDrive, karena Apache tidak bisa membacanya).

1. Buka Laragon, lalu klik **Start All** (jendela "License Key" boleh ditutup).
2. Buka http://kapsel-web.test

- Website: http://kapsel-web.test
- Admin: http://kapsel-web.test/admin

PHP yang dipakai adalah PHP 8.3 dari Laragon (PHP 8.1 bawaan XAMPP terlalu lama). Untuk perintah `php artisan ...`, pakai **Terminal** dari menu Laragon atau jalankan langsung `C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64\php.exe artisan ...`.

Data lama dari masa pengembangan masih tersimpan di `database/database.sqlite` sebagai cadangan (tidak dipakai lagi).
- Email & password admin awal ada di file `.env` (`ADMIN_EMAIL`, `ADMIN_PASSWORD`). Ganti password setelah login.

Menambah akun admin lain:

```bash
php artisan make:filament-user
```

Mengulang database dari awal (semua data terhapus, diisi contoh data lagi):

```bash
php artisan migrate:fresh --seed
```

## Struktur data

| Tabel | Isi | Menu admin |
|---|---|---|
| `profil_sekolah` | Identitas, sambutan, sejarah, visi-misi, statistik, kontak, medsos (1 baris) | Sekolah → Profil Sekolah |
| `guru` | Data guru & staf | Sekolah → Data Guru |
| `info_ppdb` | Status, persyaratan, alur, jadwal, biaya, brosur PPDB (1 baris) | Sekolah → Informasi PPDB |
| `pesan_kontak` | Pesan dari formulir Kontak | Sekolah → Pesan Masuk |
| `berita` | Berita & kegiatan | Konten → Berita & Kegiatan |
| `pengumuman` | Pengumuman (+ lampiran) | Konten → Pengumuman |
| `galeri` | Album foto kegiatan | Konten → Galeri Kegiatan |

## Halaman publik

| URL | Controller | View (diganti saat frontend) |
|---|---|---|
| `/` | `SitusController@beranda` | `resources/views/situs/beranda.blade.php` |
| `/profil` | `SitusController@profil` | `situs/profil.blade.php` |
| `/guru` | `SitusController@guru` | `situs/guru.blade.php` |
| `/pengumuman`, `/pengumuman/{slug}` | `SitusController@pengumuman`, `@detailPengumuman` | `situs/pengumuman/index`, `show` |
| `/berita`, `/berita/{slug}` | `SitusController@berita`, `@detailBerita` | `situs/berita/index`, `show` |
| `/galeri` | `SitusController@galeri` | `situs/galeri.blade.php` |
| `/ppdb` | `SitusController@ppdb` | `situs/ppdb.blade.php` |
| `/kontak` (GET & POST) | `SitusController@kontak`, `KontakController@kirim` | `situs/kontak.blade.php` |

Variabel `$profil` (data profil sekolah) otomatis tersedia di semua view `situs.*` untuk header dan footer.

## Frontend (tampilan publik)

Dibuat dengan **HTML (Blade) + CSS biasa**, tanpa proses build (tidak perlu `npm`), mengikuti desain Figma.

| File | Isi |
|---|---|
| `public/css/situs.css` | Semua gaya. Warna, font, dan lebar halaman diatur di bagian `:root` paling atas. |
| `resources/views/situs/layout.blade.php` | Pita atas, header + menu (termasuk menu HP), footer |
| `resources/views/situs/*.blade.php` | Isi tiap halaman |
| `resources/views/components/` | Potongan yang dipakai ulang: `ikon`, `foto`, `judul-halaman`, `kartu-berita`, `kartu-pengumuman`, `penomoran` |

Font: **Fraunces** (judul besar & kutipan) dan **Plus Jakarta Sans** (teks), dari Google Fonts.

Bila sebuah foto belum diunggah, tampil kotak abu-abu dengan ikon sebagai pengganti. Semua teks dan foto diubah dari panel admin, bukan dari kode.

Catatan: desain halaman Kontak tidak memuat formulir pesan, jadi formulir tidak ditampilkan. Route `POST /kontak` dan menu admin "Pesan Masuk" tetap ada bila nanti formulir ingin ditambahkan.

## Tes otomatis

```bash
php artisan test
```

Memeriksa bahwa semua halaman publik dan admin bisa dibuka (memakai database sementara, data asli tidak tersentuh).

## Sebelum online (hosting)

- Ganti `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-sekolah`.
- Pindah ke MySQL bila hosting menyediakannya (`DB_CONNECTION=mysql` + `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), lalu `php artisan migrate --seed`.
- Jalankan `php artisan storage:link` agar foto yang diunggah bisa tampil.
- Ganti password admin.
