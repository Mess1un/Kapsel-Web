@props(['judul', 'sub' => null, 'remah' => []])
{{-- Pita abu-abu di atas halaman dalam: remah roti, judul, dan subjudul. --}}
<section class="judul-halaman">
    <div class="wadah">
        <nav class="remah" aria-label="Remah roti">
            <a href="{{ route('beranda') }}">Beranda</a>
            @foreach ($remah as $teks => $url)
                / @if ($url) <a href="{{ $url }}">{{ $teks }}</a> @else <span>{{ $teks }}</span> @endif
            @endforeach
        </nav>
        <h1>{{ $judul }}</h1>
        @if ($sub) <p>{{ $sub }}</p> @endif
    </div>
</section>
