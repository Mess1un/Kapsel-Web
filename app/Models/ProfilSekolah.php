<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSekolah extends Model
{
    protected $table = 'profil_sekolah';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'jumlah_siswa' => 'integer',
            'jumlah_guru' => 'integer',
            'jumlah_kelas' => 'integer',
            'jumlah_ekstrakurikuler' => 'integer',
            'misi' => 'array',
            'fasilitas' => 'array',
            'struktur_organisasi' => 'array',
        ];
    }

    /**
     * Ambil satu-satunya data profil sekolah (dibuat otomatis bila belum ada).
     */
    public static function data(): self
    {
        return static::query()->firstOrCreate([], ['nama_sekolah' => config('app.name')]);
    }
}
