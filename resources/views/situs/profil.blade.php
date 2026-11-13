@extends('situs.layout')

@section('judul', 'Profil Sekolah')

@section('isi')
    <x-judul-halaman
        :judul="'Mengenal ' . $profil->nama_sekolah"
        sub="Membangun fondasi pengetahuan, karakter, dan kepedulian bersama keluarga."
        :remah="['Profil' => null]" />

    <section class="bagian-rapat">
        <div class="wadah">
            <div class="banner-profil"><x-foto :src="$profil->gambar_banner" :alt="'Gedung ' . $profil->nama_sekolah" /></div>
        </div>
    </section>

    {{-- Sejarah + identitas --}}
    <section class="bagian-rapat">
        <div class="wadah sejarah">
            <div>
                <span class="label">Sejarah sekolah</span>
                <h2 class="judul-bagian" style="margin-bottom:16px">Berakar pada kebersamaan</h2>
                <div class="konten">{!! str($profil->sejarah)->sanitizeHtml() !!}</div>
            </div>
            <aside class="kartu kartu-isi">
                <h3 style="font-size:16px">Identitas sekolah</h3>
                <dl class="daftar-info">
                    <dt>Nama</dt><dd>{{ $profil->nama_sekolah }}</dd>
                    @if ($profil->jenjang) <dt>Jenjang</dt><dd>{{ $profil->jenjang }}</dd> @endif
                    <dt>NPSN / status</dt><dd>{{ $profil->npsn ?: '—' }}@if ($profil->akreditasi) · Akreditasi {{ $profil->akreditasi }}@endif</dd>
                    @if ($profil->alamat) <dt>Alamat</dt><dd>{{ $profil->alamat }}</dd> @endif
                </dl>
            </aside>
        </div>
    </section>

    {{-- Visi & misi --}}
    @if ($profil->visi || $profil->misi)
        <section class="bagian-rapat">
            <div class="wadah visi-misi">
                <div class="kartu-visi">
                    <span class="label">Visi kami</span>
                    <p class="visi">{{ $profil->visi }}</p>
                    <small style="color:#a9b8e0">Nilai yang hidup dalam tindakan sehari-hari.</small>
                </div>
                <div class="kartu kartu-isi">
                    <h3 class="kecil" style="font-size:17px;margin-bottom:16px">Misi sekolah</h3>
                    <ol class="daftar-misi">
                        @foreach ($profil->misi ?? [] as $i => $butir)
                            <li><span>{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>{{ $butir }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </section>
    @endif

    {{-- Fasilitas --}}
    @if (! empty($profil->fasilitas))
        <section class="bagian-rapat" id="fasilitas">
            <div class="wadah">
                <span class="label">Fasilitas</span>
                <h2 class="judul-bagian" style="margin-bottom:22px">Lingkungan untuk belajar dan tumbuh</h2>
                <div class="kisi kisi-3 fasilitas">
                    @foreach ($profil->fasilitas as $f)
                        <div>
                            <div class="foto-bingkai"><x-foto :src="$f['foto'] ?? null" :alt="$f['nama'] ?? ''" /></div>
                            <h3>{{ $f['nama'] ?? '' }}</h3>
                            <p>{{ $f['deskripsi'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Struktur organisasi --}}
    @if (! empty($profil->struktur_organisasi))
        @php($struktur = collect($profil->struktur_organisasi))
        <section class="bagian-rapat" style="padding-bottom:60px">
            <div class="wadah">
                <span class="label">Struktur organisasi</span>
                <h2 class="judul-bagian" style="margin-bottom:22px">Bekerja bersama untuk sekolah</h2>
                <div class="bagan">
                    <div class="bagan-puncak">
                        <div class="kotak">
                            <strong>{{ $struktur->first()['jabatan'] ?? '' }}</strong>
                            <span>{{ $struktur->first()['nama'] ?? '' }}</span>
                        </div>
                    </div>
                    @if ($struktur->count() > 1)
                        <div class="bagan-bawah">
                            @foreach ($struktur->skip(1) as $s)
                                <div class="kotak">
                                    <strong>{{ $s['jabatan'] ?? '' }}</strong>
                                    <span>{{ $s['nama'] ?? '' }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endsection
