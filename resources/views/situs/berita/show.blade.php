@extends('situs.layout')

@section('judul', $berita->judul)
@section('deskripsi', $berita->cuplikan)

@section('isi')
    <section class="wadah"><div class="detail-kepala">
        <nav class="remah" aria-label="Remah roti">
            <a href="{{ route('beranda') }}">Beranda</a> /
            <a href="{{ route('berita.index') }}">Berita & Kegiatan</a> /
            <span>{{ str($berita->judul)->limit(40) }}</span>
        </nav>
        @if ($berita->kategori) <span class="badge">{{ $berita->kategori }}</span> @endif
        <h1>{{ $berita->judul }}</h1>
        @if ($berita->ringkasan) <p class="sub">{{ $berita->ringkasan }}</p> @endif
        <p class="meta">
            {{ $berita->tanggal_terbit?->translatedFormat('j F Y') }}
            @if ($berita->penulis) • {{ $berita->penulis }} @endif
            • {{ $berita->menit_baca }} menit baca
        </p>
    </div></section>

    @if ($berita->gambar)
        <div class="wadah">
            <div class="foto-utama"><x-foto :src="$berita->gambar" :alt="$berita->judul" /></div>
            @if ($berita->keterangan_gambar) <p class="keterangan-foto">{{ $berita->keterangan_gambar }}</p> @endif
        </div>
    @endif

    <section class="bagian-rapat" style="padding-top:{{ $berita->gambar ? '0' : '8px' }}">
        <div class="wadah detail-tata">
            <article>
                <div class="konten">{!! str($berita->isi)->sanitizeHtml() !!}</div>
                <a class="tombol tombol-garis tombol-kecil" href="{{ route('berita.index') }}" style="margin-top:12px">← Kembali ke Berita</a>
            </article>
            <aside class="sisi">
                <div class="kartu kartu-isi">
                    <h3>Tentang kegiatan</h3>
                    <dl class="daftar-info">
                        @if ($berita->kategori) <dt>Kategori</dt><dd>{{ $berita->kategori }}</dd> @endif
                        @if ($berita->penulis) <dt>Dokumentasi</dt><dd>{{ $berita->penulis }}</dd> @endif
                        @if ($berita->topik) <dt>Topik</dt><dd>{{ $berita->topik }}</dd> @endif
                        <dt>Dilihat</dt><dd>{{ number_format($berita->dilihat, 0, ',', '.') }} kali</dd>
                    </dl>
                </div>
            </aside>
        </div>
    </section>

    @if ($terkait->isNotEmpty())
        <section class="bagian" style="padding-top:8px">
            <div class="wadah">
                <h2 class="judul-bagian" style="margin-bottom:20px">Cerita lainnya</h2>
                <div class="kisi kisi-3">
                    @foreach ($terkait as $item)
                        <x-kartu-berita :item="$item" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
