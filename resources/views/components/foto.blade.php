@props(['src' => null, 'alt' => '', 'ikon' => 'gambar'])
{{-- Menampilkan foto dari storage. Bila belum ada foto, tampil kotak pengganti. --}}
@if ($src)
    <img src="{{ Storage::url($src) }}" alt="{{ $alt }}" loading="lazy" {{ $attributes->merge(['class' => 'foto']) }}>
@else
    <div {{ $attributes->merge(['class' => 'foto-kosong']) }} role="img" aria-label="{{ $alt ?: 'Foto belum tersedia' }}">
        <x-ikon :nama="$ikon" />
    </div>
@endif
