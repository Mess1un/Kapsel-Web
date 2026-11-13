<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'foto' => 'array',
            'tanggal_kegiatan' => 'date',
            'diterbitkan' => 'boolean',
        ];
    }

    public function scopeTerbit(Builder $query): Builder
    {
        return $query->where('diterbitkan', true)
            ->orderByDesc('tanggal_kegiatan')
            ->orderByDesc('id');
    }

    /** Foto pertama dipakai sebagai sampul album. */
    public function getSampulAttribute(): ?string
    {
        return $this->foto[0] ?? null;
    }
}
