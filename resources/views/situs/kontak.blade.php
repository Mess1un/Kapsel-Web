@extends('situs.layout')

@section('judul', 'Kontak dan Lokasi')

@section('isi')
    <x-judul-halaman
        judul="Mari terhubung dengan sekolah"
        sub="Informasi layanan untuk orang tua, calon wali murid, dan masyarakat."
        :remah="['Kontak' => null]" />

    <section class="bagian">
        <div class="wadah kontak-tata">
            <div>
                <div class="kartu kartu-isi">
                    <h3 class="kecil">Kontak resmi sekolah</h3>
                    <ul class="daftar-kontak">
                        @if ($profil->alamat)
                            <li><x-ikon nama="lokasi" /><div><small>Alamat</small>{{ $profil->alamat }}</div></li>
                        @endif
                        @if ($profil->telepon)
                            <li><x-ikon nama="telepon" /><div><small>Telepon</small><a href="tel:{{ preg_replace('/[^0-9+]/', '', $profil->telepon) }}">{{ $profil->telepon }}</a></div></li>
                        @endif
                        @if ($profil->whatsapp)
                            <li><x-ikon nama="telepon" /><div><small>WhatsApp</small><a href="https://wa.me/{{ preg_replace('/\D/', '', $profil->whatsapp) }}" target="_blank" rel="noopener">{{ $profil->whatsapp }}</a></div></li>
                        @endif
                        @if ($profil->email)
                            <li><x-ikon nama="email" /><div><small>Email</small><a href="mailto:{{ $profil->email }}">{{ $profil->email }}</a></div></li>
                        @endif
                    </ul>
                </div>

                @if ($profil->jam_operasional)
                    <div class="kartu kartu-isi" style="margin-top:16px">
                        <h3 class="kecil">Jam layanan administrasi</h3>
                        <p style="font-size:14px;margin:0">{!! nl2br(e($profil->jam_operasional)) !!}</p>
                    </div>
                @endif
            </div>

            <div>
                <div class="peta">
                    @if ($profil->google_maps_embed && str_starts_with($profil->google_maps_embed, 'https://www.google.com/maps/embed'))
                        <iframe src="{{ $profil->google_maps_embed }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Peta lokasi {{ $profil->nama_sekolah }}"></iframe>
                    @else
                        <div class="peta-kosong">
                            <div class="pin">
                                <x-ikon nama="lokasi" />
                                <strong>{{ $profil->nama_sekolah }}</strong>
                                <span class="meta">Peta belum diatur</span>
                            </div>
                        </div>
                    @endif
                </div>
                @if ($profil->google_maps_link)
                    <p style="margin-top:12px">
                        <a class="tombol tombol-garis tombol-kecil" href="{{ $profil->google_maps_link }}" target="_blank" rel="noopener">Buka di Google Maps →</a>
                    </p>
                @endif

                <div class="kartu kartu-isi" style="margin-top:16px">
                    <h3 class="kecil" style="margin-bottom:8px">Sebelum berkunjung</h3>
                    <p style="font-size:13.5px;color:var(--teks-redup);margin:0">
                        Sampaikan tujuan kunjungan kepada petugas administrasi. Untuk konsultasi PPDB, siapkan pertanyaan dan konfirmasikan waktu layanan panitia terlebih dahulu.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
