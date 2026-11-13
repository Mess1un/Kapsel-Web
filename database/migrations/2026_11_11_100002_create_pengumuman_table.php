<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->nullable();          // Akademik, Kalender, Kegiatan, PPDB, Layanan
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('lampiran')->nullable();          // file PDF/dokumen
            $table->boolean('penting')->default(false);      // ditandai "Penting"
            $table->boolean('diterbitkan')->default(true);
            $table->timestamp('tanggal_terbit')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengumuman');
    }
};
