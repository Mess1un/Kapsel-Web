@extends('situs.layout')

@section('judul', 'Pengumuman')

@section('isi')
    <x-judul-halaman
        judul="Pengumuman sekolah"
        :sub="'Jadwal dan informasi penting untuk keluarga ' . $profil->nama_sekolah . '. Disusun dari yang terbaru.'"
        :remah="['Pengumuman' => null]" />

    <section class="bagian">
        <div class="wadah">
            <form method="GET" class="alat" role="search">
                <label class="cari">
                    <span class="sr-only">Cari pengumuman</span>
                    <x-ikon nama="cari" />
                    <input class="input" type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari pengumuman...">
                </label>
                <label>
                    <span class="sr-only">Kategori</span>
                    <select class="pilih" name="kategori" onchange="this.form.submit()">
                        <option value="">Semua kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k }}" @selected(request('kategori') === $k)>{{ $k }}</option>
                        @endforeach
                    </select>
                </label>
            </form>

            <p class="ringkasan-hasil">
                {{ $pengumuman->total() }} pengumuman
                @if ($terakhirDiperbarui) • Diperbarui {{ $terakhirDiperbarui->translatedFormat('j F Y') }} @endif
            </p>

            @if ($pengumuman->isEmpty())
                <p class="kosong">Tidak ada pengumuman yang cocok.</p>
            @else
                <div class="kisi kisi-3">
                    @foreach ($pengumuman as $item)
                        <x-kartu-pengumuman :item="$item" />
                    @endforeach
                </div>
                <x-penomoran :data="$pengumuman" />
            @endif
        </div>
    </section>
@endsection
