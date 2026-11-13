<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Informasi PPDB hanya berisi satu baris data.
     */
    public function up(): void
    {
        Schema::create('info_ppdb', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran', 20)->nullable();  // contoh: 2027/2028
            $table->boolean('dibuka')->default(false);
            $table->date('tanggal_buka')->nullable();
            $table->date('tanggal_tutup')->nullable();
            $table->unsignedInteger('kuota')->nullable();

            // Bagian atas halaman
            $table->string('judul')->nullable();             // "Langkah awal untuk tumbuh bersama."
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();

            $table->text('ketentuan_pengantar')->nullable(); // "Siapa yang dapat mendaftar?"
            $table->json('ketentuan')->nullable();           // daftar butir
            $table->text('ketentuan_catatan')->nullable();
            $table->json('persyaratan')->nullable();         // daftar berkas
            $table->text('persyaratan_catatan')->nullable();
            $table->json('tahapan')->nullable();             // [{judul, tanggal, keterangan}]
            $table->longText('cara_pendaftaran')->nullable();
            $table->longText('biaya')->nullable();

            $table->string('brosur')->nullable();            // file PDF/gambar
            $table->string('link_pendaftaran')->nullable();
            $table->string('email_panitia')->nullable();
            $table->string('telepon_panitia', 30)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('info_ppdb');
    }
};
