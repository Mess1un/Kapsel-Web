@extends('situs.layout')

@section('judul', 'Berita dan Kegiatan')

@section('isi')
    <x-judul-halaman
        judul="Cerita dari sekolah"
        :sub="'Kabar kegiatan, pengalaman belajar, dan kebersamaan warga ' . $profil->nama_sekolah . '.'"
        :remah="['Berita' => null]" />

    <section class="bagian">
        <div class="wadah">
            <form method="GET" class="alat" role="search">
                <label class="cari">
                    <span class="sr-only">Cari berita</span>
                    <x-ikon nama="cari" />
                    <input class="input" type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari berita dan kegiatan...">
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

            <p class="ringkasan-hasil">{{ $berita->total() }} berita • Urutan terbaru</p>

            @if ($berita->isEmpty())
                <p class="kosong">Tidak ada berita yang cocok.</p>
            @else
                <div class="kisi kisi-3">
                    @foreach ($berita as $item)
                        <x-kartu-berita :item="$item" />
                    @endforeach
                </div>
                <x-penomoran :data="$berita" />
            @endif
        </div>
    </section>
@endsection
