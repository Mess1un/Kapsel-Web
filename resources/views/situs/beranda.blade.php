@extends('situs.layout')

@section('isi')
    {{-- Hero --}}
    <section class="hero">
        <div class="wadah">
            <div class="hero-kotak">
                <div class="hero-teks">
                    <span class="label">Selamat datang di {{ $profil->nama_sekolah }}</span>
                    <h1>{{ $profil->hero_judul ?: $profil->nama_sekolah }}</h1>
                    @if ($profil->hero_deskripsi) <p>{{ $profil->hero_deskripsi }}</p> @endif
                    <div class="hero-tombol">
                        <a href="{{ route('profil') }}" class="tombol tombol-putih">Kenali Sekolah</a>
                        <a href="{{ route('ppdb') }}" class="tombol tombol-oranye">Informasi PPDB →</a>
                    </div>
                </div>
                <div class="hero-foto">
                    <x-foto :src="$profil->gambar_banner" :alt="'Gedung ' . $profil->nama_sekolah" />
                </div>
            </div>
            <div class="hero-pita">
                <span>Informasi terbuka untuk semua</span>
                @if ($profil->jam_operasional) <span>Layanan sekolah • {{ str($profil->jam_operasional)->before("\n")->before(':') }}</span> @endif
                @if ($ppdb?->tahun_ajaran) <span>Tahun ajaran {{ $ppdb->tahun_ajaran }}</span> @endif
            </div>
        </div>
    </section>

    {{-- Mengenal sekolah --}}
    @if ($profil->pengenalan)
        <section class="bagian" style="background:var(--latar-lembut)">
            <div class="wadah kenal">
                <div>
                    <span class="label">Mengenal sekolah</span>
                    <h2>{{ $profil->pengenalan_judul ?: 'Mengenal ' . $profil->nama_sekolah }}</h2>
                </div>
                <div class="kenal-teks">
                    @foreach (preg_split('/\n\s*\n/', trim($profil->pengenalan)) as $paragraf)
                        <p>{{ $paragraf }}</p>
                    @endforeach
                    <a class="tautan-panah" href="{{ route('profil') }}">Baca profil sekolah →</a>
                </div>
            </div>
        </section>
    @endif

    {{-- Sambutan kepala sekolah --}}
    @if ($profil->sambutan || $profil->kutipan_sambutan)
        <section class="bagian-rapat" style="background:var(--latar-lembut);padding-top:0">
            <div class="wadah">
                <div class="kartu sambutan">
                    <div class="foto-bingkai">
                        <x-foto :src="$profil->foto_kepala_sekolah" :alt="$profil->nama_kepala_sekolah" ikon="pengguna" />
                    </div>
                    <div>
                        <span class="label">Sambutan kepala sekolah</span>
                        @if ($profil->kutipan_sambutan) <blockquote>“{{ $profil->kutipan_sambutan }}”</blockquote> @endif
                        @if ($profil->sambutan) <p>{{ $profil->sambutan }}</p> @endif
                        @if ($profil->nama_kepala_sekolah)
                            <p class="nama">{{ $profil->nama_kepala_sekolah }}</p>
                            <span class="meta">Kepala Sekolah</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Pengumuman --}}
    <section class="bagian">
        <div class="wadah">
            <div class="kepala-bagian">
                <div>
                    <span class="label">Papan informasi</span>
                    <h2 class="judul-bagian">Pengumuman terbaru</h2>
                </div>
                <a class="tautan-panah" href="{{ route('pengumuman.index') }}">Semua pengumuman →</a>
            </div>
            @if ($pengumumanTerbaru->isEmpty())
                <p class="kosong">Belum ada pengumuman.</p>
            @else
                <div class="kisi kisi-3">
                    @foreach ($pengumumanTerbaru as $item)
                        <x-kartu-pengumuman :item="$item" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Berita --}}
    <section class="bagian" style="padding-top:0">
        <div class="wadah">
            <div class="kepala-bagian">
                <div>
                    <span class="label">Berita & kegiatan</span>
                    <h2 class="judul-bagian">Cerita dari sekolah</h2>
                </div>
                <a class="tautan-panah" href="{{ route('berita.index') }}">Semua berita →</a>
            </div>
            @if ($beritaTerbaru->isEmpty())
                <p class="kosong">Belum ada berita.</p>
            @else
                <div class="kisi kisi-3">
                    @foreach ($beritaTerbaru as $item)
                        <x-kartu-berita :item="$item" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Sorotan: fasilitas & guru --}}
    <section class="bagian" style="padding-top:0">
        <div class="wadah kisi kisi-2">
            <div class="sorotan">
                <div class="foto-bingkai" style="border-radius:6px">
                    <x-foto :src="$profil->fasilitas[0]['foto'] ?? null" alt="Fasilitas sekolah" />
                </div>
                <h3>Ruang yang mendukung rasa ingin tahu</h3>
                <p>Ruang kelas, perpustakaan, halaman, dan kebun menjadi bagian dari lingkungan belajar yang dirawat bersama.</p>
                <a class="tautan-panah" href="{{ route('profil') }}#fasilitas">Jelajahi fasilitas →</a>
            </div>
            <div class="sorotan">
                <div class="foto-bingkai" style="border-radius:6px">
                    <x-foto :src="$fotoGuru" alt="Guru sekolah" ikon="pengguna" />
                </div>
                <h3>Guru yang mendampingi dengan hati</h3>
                <p>Kenali para pendidik yang membantu anak bertumbuh melalui bimbingan, keteladanan, dan perhatian.</p>
                <a class="tautan-panah" href="{{ route('guru') }}">Kenali para guru →</a>
            </div>
        </div>
    </section>

    {{-- Galeri --}}
    @if ($galeriTerbaru->isNotEmpty())
        <section class="bagian" style="padding-top:0">
            <div class="wadah">
                <div class="kepala-bagian">
                    <div>
                        <span class="label">Galeri sekolah</span>
                        <h2 class="judul-bagian">Momen kebersamaan</h2>
                    </div>
                    <a class="tautan-panah" href="{{ route('galeri') }}">Lihat galeri →</a>
                </div>
                <div class="kisi kisi-3 galeri-mini">
                    @foreach ($galeriTerbaru as $album)
                        <figure>
                            <div class="foto-bingkai"><x-foto :src="$album->sampul" :alt="$album->judul" /></div>
                            <figcaption>{{ $album->deskripsi ?: $album->judul }}</figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Ajakan PPDB --}}
    <section class="ajakan">
        <div class="wadah">
            <span class="label">Penerimaan peserta didik baru</span>
            <h2>Mari mengenal sekolah lebih dekat.</h2>
            <p>
                Pelajari persyaratan dan tahapan PPDB @if ($ppdb?->tahun_ajaran) {{ $ppdb->tahun_ajaran }}@endif.
                Untuk konsultasi dan petunjuk pendaftaran, silakan menghubungi panitia atau berkunjung ke sekolah.
            </p>
            <div class="hero-tombol" style="margin-top:20px">
                <a href="{{ route('ppdb') }}" class="tombol tombol-oranye">Lihat Informasi PPDB →</a>
                <a href="{{ route('kontak') }}" class="tombol tombol-putih">Kontak Sekolah</a>
            </div>
        </div>
    </section>
@endsection
