<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Membuat slug unik otomatis dari kolom "judul" saat data disimpan.
 * Contoh: "Pekan Olahraga 2027" -> "pekan-olahraga-2027" (atau "-2", "-3" bila sudah ada).
 */
trait HasUniqueSlug
{
    protected static function bootHasUniqueSlug(): void
    {
        static::saving(function ($model) {
            if (blank($model->slug) || $model->isDirty('judul') && ! $model->isDirty('slug')) {
                $model->slug = static::buatSlugUnik($model->judul, $model->getKey());
            }
        });
    }

    public static function buatSlugUnik(string $judul, $abaikanId = null): string
    {
        $dasar = Str::slug($judul) ?: 'tanpa-judul';
        $slug = $dasar;
        $i = 2;

        while (static::where('slug', $slug)->when($abaikanId, fn ($q) => $q->whereKeyNot($abaikanId))->exists()) {
            $slug = "{$dasar}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
