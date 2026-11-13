<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesanKontak extends Model
{
    protected $table = 'pesan_kontak';

    // Hanya kolom ini yang boleh diisi dari formulir kontak publik.
    protected $fillable = ['nama', 'email', 'telepon', 'subjek', 'pesan'];

    protected function casts(): array
    {
        return [
            'sudah_dibaca' => 'boolean',
        ];
    }
}
