<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasUniqueSlug;

    protected $table = 'pengumuman';

    protected $guarded = ['id'];

    public const KATEGORI = [
        'Akademik' => 'Akademik',
        'Kalender' => 'Kalender',
        'Kegiatan' => 'Kegiatan',
        'PPDB' => 'PPDB',
        'Layanan' => 'Layanan',
        'Umum' => 'Umum',
    ];

    protected function casts(): array
    {
        return [
            'penting' => 'boolean',
            'diterbitkan' => 'boolean',
            'tanggal_terbit' => 'datetime',
        ];
    }

    /** Ringkasan untuk kartu: kolom ringkasan, atau awal isi pengumuman. */
    public function getCuplikanAttribute(): string
    {
        return $this->ringkasan ?: (string) str(strip_tags((string) $this->isi))->squish()->limit(130);
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** Hanya yang sudah terbit, terbaru dulu. */
    public function scopeTerbit(Builder $query): Builder
    {
        return $query->where('diterbitkan', true)
            ->where(fn ($q) => $q->whereNull('tanggal_terbit')->orWhere('tanggal_terbit', '<=', now()))
            ->orderByDesc('tanggal_terbit')
            ->orderByDesc('id');
    }
}
