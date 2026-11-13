@props(['item'])
<article class="kartu kartu-info">
    <div class="atas">
        <span class="meta">{{ $item->tanggal_terbit?->translatedFormat('j F Y') }}</span>
        @if ($item->kategori) <span class="badge">{{ $item->kategori }}</span> @endif
    </div>
    <h3><a href="{{ route('pengumuman.show', $item) }}">{{ $item->judul }}</a></h3>
    <p>{{ $item->cuplikan }}</p>
    <a class="tautan-panah" href="{{ route('pengumuman.show', $item) }}">Baca Selengkapnya →</a>
</article>
