@props(['item'])
<article class="kartu kartu-berita">
    <a href="{{ route('berita.show', $item) }}" class="foto-bingkai" tabindex="-1" aria-hidden="true">
        <x-foto :src="$item->gambar" :alt="$item->judul" />
    </a>
    <div class="kartu-isi">
        <span class="meta">{{ $item->kategori }}@if ($item->kategori) / @endif{{ $item->tanggal_terbit?->translatedFormat('j F Y') }}</span>
        <h3><a href="{{ route('berita.show', $item) }}">{{ $item->judul }}</a></h3>
        <p>{{ $item->cuplikan }}</p>
        <div class="bawah">
            <span class="meta">{{ $item->menit_baca }} menit baca</span>
            <a class="tautan-panah" href="{{ route('berita.show', $item) }}">Baca berita →</a>
        </div>
    </div>
</article>
