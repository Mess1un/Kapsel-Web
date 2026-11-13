<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Profil sekolah hanya berisi satu baris data (identitas, sambutan, visi-misi, kontak).
     */
    public function up(): void
    {
        Schema::create('profil_sekolah', function (Blueprint $table) {
            $table->id();

            // Identitas
            $table->string('nama_sekolah');
            $table->string('slogan')->nullable();
            $table->string('jenjang')->nullable();           // Sekolah Dasar, SMP, dll.
            $table->string('npsn', 20)->nullable();
            $table->string('akreditasi', 20)->nullable();
            $table->string('logo')->nullable();
            $table->string('gambar_banner')->nullable();

            // Beranda
            $table->string('hero_judul')->nullable();
            $table->text('hero_deskripsi')->nullable();
            $table->string('pengenalan_judul')->nullable();  // "Pendidikan yang dekat dengan kehidupan."
            $table->text('pengenalan')->nullable();

            // Kepala sekolah & sambutan
            $table->string('nama_kepala_sekolah')->nullable();
            $table->string('foto_kepala_sekolah')->nullable();
            $table->string('kutipan_sambutan')->nullable();
            $table->text('sambutan')->nullable();

            // Profil
            $table->longText('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();                // daftar butir misi
            $table->json('fasilitas')->nullable();           // [{nama, deskripsi, foto}]
            $table->json('struktur_organisasi')->nullable(); // [{jabatan, nama}], butir pertama = pimpinan

            // Statistik (ditampilkan di beranda)
            $table->unsignedInteger('jumlah_siswa')->default(0);
            $table->unsignedInteger('jumlah_guru')->default(0);
            $table->unsignedInteger('jumlah_kelas')->default(0);
            $table->unsignedInteger('jumlah_ekstrakurikuler')->default(0);

            // Kontak & lokasi
            $table->text('alamat')->nullable();
            $table->string('telepon', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('jam_operasional')->nullable();     // boleh beberapa baris
            $table->text('google_maps_embed')->nullable();
            $table->string('google_maps_link')->nullable();

            // Media sosial
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('tiktok')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_sekolah');
    }
};
