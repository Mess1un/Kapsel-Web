@extends('situs.layout')

@section('judul', $pengumuman->judul)
@section('deskripsi', $pengumuman->cuplikan)

@section('isi')
    <section class="bagian-rapat" style="padding-bottom:60px">
        <div class="wadah detail-tata">
            <article>
                <nav class="remah" aria-label="Remah roti">
                    <a href="{{ route('beranda') }}">Beranda</a> /
                    <a href="{{ route('pengumuman.index') }}">Pengumuman</a> /
                    <span>{{ $pengumuman->judul }}</span>
                </nav>
                @if ($pengumuman->kategori) <span class="badge">{{ $pengumuman->kategori }}</span> @endif
                <h1 style="font-size:32px;margin:14px 0 10px">{{ $pengumuman->judul }}</h1>
                <p class="meta" style="margin-bottom:20px">
                    Dipublikasikan {{ $pengumuman->tanggal_terbit?->translatedFormat('j F Y') }}
                    @if ($pengumuman->penulis) • Oleh {{ $pengumuman->penulis->name }} @endif
                </p>

                <div class="konten">{!! str($pengumuman->isi)->sanitizeHtml() !!}</div>

                @if ($pengumuman->lampiran)
                    <p>
                        <a class="tombol tombol-garis" href="{{ Storage::url($pengumuman->lampiran) }}" target="_blank" rel="noopener">
                            <x-ikon nama="unduh" /> Unduh lampiran
                        </a>
                    </p>
                @endif

                <a class="tombol tombol-garis tombol-kecil" href="{{ route('pengumuman.index') }}" style="margin-top:12px">← Kembali ke Pengumuman</a>
            </article>

            @if ($lainnya->isNotEmpty())
                <aside class="sisi" style="padding-top:40px">
                    <h3>Informasi lainnya</h3>
                    @foreach ($lainnya as $item)
                        <x-kartu-pengumuman :item="$item" />
                    @endforeach
                </aside>
            @endif
        </div>
    </section>
@endsection
