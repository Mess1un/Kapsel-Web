<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoPpdb extends Model
{
    protected $table = 'info_ppdb';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'dibuka' => 'boolean',
            'tanggal_buka' => 'date',
            'tanggal_tutup' => 'date',
            'kuota' => 'integer',
            'ketentuan' => 'array',
            'persyaratan' => 'array',
            'tahapan' => 'array',
        ];
    }

    /**
     * Ambil satu-satunya data informasi PPDB (dibuat otomatis bila belum ada).
     */
    public static function data(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
