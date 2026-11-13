@extends('situs.layout')

@section('judul', 'Informasi Guru')

@section('isi')
    <x-judul-halaman
        judul="Berkenalan dengan para pendidik"
        sub="Mendampingi proses belajar dengan pengetahuan, keteladanan, dan kepedulian."
        :remah="['Guru' => null]" />

    <section class="bagian">
        <div class="wadah">
            <form method="GET" class="alat" role="search">
                <label class="cari">
                    <span class="sr-only">Cari guru</span>
                    <x-ikon nama="cari" />
                    <input class="input" type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama guru atau bidang pengajaran...">
                </label>
                <label>
                    <span class="sr-only">Bidang</span>
                    <select class="pilih" name="bidang" onchange="this.form.submit()">
                        <option value="">Semua bidang</option>
                        @foreach ($bidang as $b)
                            <option value="{{ $b }}" @selected(request('bidang') === $b)>{{ $b }}</option>
                        @endforeach
                    </select>
                </label>
            </form>

            <p class="ringkasan-hasil">{{ $guru->count() }} pendidik • Tidak menampilkan data pribadi atau identitas kepegawaian</p>

            @if ($guru->isEmpty())
                <p class="kosong">Tidak ada guru yang cocok dengan pencarian.</p>
            @else
                <div class="kisi kisi-4">
                    @foreach ($guru as $g)
                        <article class="kartu kartu-guru">
                            <div class="foto-bingkai"><x-foto :src="$g->foto" :alt="$g->nama" ikon="pengguna" /></div>
                            <div class="kartu-isi">
                                <strong>{{ $g->nama }}</strong>
                                <span>{{ $g->jabatan }}@if ($g->mata_pelajaran && $g->mata_pelajaran !== $g->jabatan) · {{ $g->mata_pelajaran }}@endif</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
