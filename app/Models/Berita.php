<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Berita extends Model
{
    use HasUniqueSlug;

    protected $table = 'berita';

    protected $guarded = ['id'];

    public const KATEGORI = [
        'Kegiatan' => 'Kegiatan',
        'Prestasi' => 'Prestasi',
        'Akademik' => 'Akademik',
        'Lingkungan' => 'Lingkungan',
        'Ekstrakurikuler' => 'Ekstrakurikuler',
        'Sekolah' => 'Sekolah',
    ];

    /** Perkiraan waktu baca (±200 kata per menit). */
    public function getMenitBacaAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags((string) $this->isi)) / 200));
    }

    /** Ringkasan untuk kartu: kolom ringkasan, atau awal isi berita. */
    public function getCuplikanAttribute(): string
    {
        return $this->ringkasan ?: (string) str(strip_tags((string) $this->isi))->squish()->limit(130);
    }

    protected function casts(): array
    {
        return [
            'diterbitkan' => 'boolean',
            'tanggal_terbit' => 'datetime',
            'dilihat' => 'integer',
        ];
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
