@extends('situs.layout')

@section('judul', 'Informasi PPDB')

@section('isi')
    <x-judul-halaman
        judul="Informasi PPDB"
        sub="Panduan bagi calon orang tua dan wali murid untuk mengenal proses penerimaan peserta didik baru."
        :remah="['PPDB' => null]" />

    <section class="bagian">
        <div class="wadah">
            {{-- Bagian atas --}}
            <div class="ppdb-atas">
                <div>
                    <span class="label">
                        Tahun ajaran {{ $ppdb->tahun_ajaran }}
                        <span @class(['status-ppdb', 'buka' => $ppdb->dibuka, 'tutup' => ! $ppdb->dibuka])>
                            {{ $ppdb->dibuka ? 'Pendaftaran dibuka' : 'Pendaftaran ditutup' }}
                        </span>
                    </span>
                    <h2>{{ $ppdb->judul ?: 'Penerimaan Peserta Didik Baru' }}</h2>
                    @if ($ppdb->deskripsi) <p>{{ $ppdb->deskripsi }}</p> @endif
                    @if ($ppdb->tanggal_buka)
                        <p class="meta">
                            Periode: {{ $ppdb->tanggal_buka->translatedFormat('j F Y') }}
                            @if ($ppdb->tanggal_tutup) – {{ $ppdb->tanggal_tutup->translatedFormat('j F Y') }} @endif
                            @if ($ppdb->kuota) • Kuota {{ $ppdb->kuota }} siswa @endif
                        </p>
                    @endif
                    <div class="hero-tombol">
                        <a href="#kontak-panitia" class="tombol tombol-utama">Hubungi Panitia PPDB</a>
                        @if ($ppdb->dibuka && $ppdb->link_pendaftaran)
                            <a href="{{ $ppdb->link_pendaftaran }}" class="tombol tombol-oranye" target="_blank" rel="noopener">Daftar Online →</a>
                        @endif
                        @if ($ppdb->brosur)
                            <a href="{{ Storage::url($ppdb->brosur) }}" class="tombol tombol-garis" target="_blank" rel="noopener"><x-ikon nama="unduh" /> Brosur</a>
                        @endif
                    </div>
                </div>
                <div class="foto-bingkai">
                    <x-foto :src="$ppdb->gambar ?: $profil->gambar_banner" :alt="'Gedung ' . $profil->nama_sekolah" />
                </div>
            </div>

            {{-- Ketentuan & berkas --}}
            @if ($ppdb->ketentuan || $ppdb->persyaratan)
                <div class="kisi kisi-2" style="margin-top:36px">
                    <div class="kartu kartu-isi">
                        <h3 class="kecil">Siapa yang dapat mendaftar?</h3>
                        @if ($ppdb->ketentuan_pengantar) <p style="font-size:14px">{{ $ppdb->ketentuan_pengantar }}</p> @endif
                        <ul class="daftar-titik">
                            @foreach ($ppdb->ketentuan ?? [] as $butir)
                                <li>{{ $butir }}</li>
                            @endforeach
                        </ul>
                        @if ($ppdb->ketentuan_catatan) <p class="catatan-kecil">{{ $ppdb->ketentuan_catatan }}</p> @endif
                    </div>
                    <div class="kartu kartu-isi">
                        <h3 class="kecil">Daftar berkas yang disiapkan</h3>
                        <ul class="daftar-centang">
                            @foreach ($ppdb->persyaratan ?? [] as $berkas)
                                <li><x-ikon nama="centang" />{{ $berkas }}</li>
                            @endforeach
                        </ul>
                        @if ($ppdb->persyaratan_catatan) <p class="catatan-kecil">{{ $ppdb->persyaratan_catatan }}</p> @endif
                    </div>
                </div>
            @endif

            {{-- Tahapan --}}
            @if ($ppdb->tahapan)
                <div style="margin-top:48px">
                    <span class="label">Alur penerimaan</span>
                    <h2 class="judul-bagian" style="margin-bottom:20px">Jadwal & tahapan</h2>
                    <div class="tahapan">
                        @foreach ($ppdb->tahapan as $i => $tahap)
                            <div class="kartu tahap">
                                <span class="nomor">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <div>
                                    <h3>{{ $tahap['judul'] ?? '' }}</h3>
                                    @if (! empty($tahap['tanggal'])) <p class="tanggal">{{ $tahap['tanggal'] }}</p> @endif
                                    @if (! empty($tahap['keterangan'])) <p>{{ $tahap['keterangan'] }}</p> @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Cara pendaftaran --}}
            @if ($ppdb->cara_pendaftaran)
                <div class="kartu kartu-isi" style="margin-top:36px">
                    <h3 class="kecil">Cara memperoleh petunjuk pendaftaran</h3>
                    <div class="konten" style="font-size:14px">{!! str($ppdb->cara_pendaftaran)->sanitizeHtml() !!}</div>
                    <a href="{{ route('kontak') }}" class="tombol tombol-garis tombol-kecil">Lihat Kontak & Lokasi →</a>
                </div>
            @endif

            @if ($ppdb->biaya)
                <div class="kartu kartu-isi" style="margin-top:20px">
                    <h3 class="kecil">Rincian biaya</h3>
                    <div class="konten" style="font-size:14px">{!! str($ppdb->biaya)->sanitizeHtml() !!}</div>
                </div>
            @endif

            {{-- Kontak panitia --}}
            <div class="kotak-tanya" id="kontak-panitia" style="margin-top:36px">
                <h2>Ada yang ingin ditanyakan?</h2>
                <p style="margin-bottom:16px">Panitia PPDB {{ $profil->nama_sekolah }} siap membantu menjelaskan proses penerimaan pada jam layanan sekolah.</p>
                @php($emailPanitia = $ppdb->email_panitia ?: $profil->email)
                @php($teleponPanitia = $ppdb->telepon_panitia ?: $profil->telepon)
                @if ($emailPanitia) <p>Email: <a href="mailto:{{ $emailPanitia }}">{{ $emailPanitia }}</a></p> @endif
                @if ($teleponPanitia) <p>Telepon: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $teleponPanitia) }}">{{ $teleponPanitia }}</a></p> @endif
                @if ($profil->whatsapp) <p>WhatsApp: <a href="https://wa.me/{{ preg_replace('/\D/', '', $profil->whatsapp) }}" target="_blank" rel="noopener">{{ $profil->whatsapp }}</a></p> @endif
                @if ($profil->jam_operasional) <p>{{ str($profil->jam_operasional)->before("\n") }}</p> @endif
                @if ($profil->alamat) <p>{{ $profil->alamat }}</p> @endif
            </div>
        </div>
    </section>
@endsection
