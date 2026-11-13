<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->nullable();          // Kegiatan, Prestasi, Akademik, dll.
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('gambar')->nullable();
            $table->string('keterangan_gambar')->nullable();
            $table->string('topik')->nullable();
            $table->string('penulis')->nullable();           // contoh: Tim Publikasi Sekolah
            $table->boolean('diterbitkan')->default(true);
            $table->timestamp('tanggal_terbit')->nullable();
            $table->unsignedInteger('dilihat')->default(0);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
