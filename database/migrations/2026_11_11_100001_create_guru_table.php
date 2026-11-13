<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip', 30)->nullable();
            $table->string('jabatan')->nullable();          // contoh: Guru, Wakasek Kurikulum
            $table->string('mata_pelajaran')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedInteger('urutan')->default(0);   // urutan tampil di website
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};
