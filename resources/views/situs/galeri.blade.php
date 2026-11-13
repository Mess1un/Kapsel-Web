@extends('situs.layout')

@section('judul', 'Galeri Kegiatan')

@section('isi')
    <x-judul-halaman
        judul="Merekam momen, merawat kenangan"
        sub="Dokumentasi kegiatan belajar dan kebersamaan warga sekolah."
        :remah="['Galeri' => null]" />

    <section class="bagian">
        <div class="wadah">
            <nav class="cip" aria-label="Kategori album">
                <a href="{{ route('galeri') }}" @class(['aktif' => ! request('kategori')])>Semua album</a>
                @foreach ($kategori as $k)
                    <a href="{{ route('galeri', ['kategori' => $k]) }}" @class(['aktif' => request('kategori') === $k])>{{ $k }}</a>
                @endforeach
            </nav>

            @if ($galeri->isEmpty())
                <p class="kosong">Belum ada album di kategori ini.</p>
            @else
                <div class="kisi kisi-2">
                    @foreach ($galeri as $album)
                        @php($daftarFoto = collect($album->foto)->map(fn ($f) => Storage::url($f))->values())
                        <article class="kartu kartu-album">
                            <div class="foto-bingkai" @if ($daftarFoto->isNotEmpty()) data-album='@json(['judul' => $album->judul, 'foto' => $daftarFoto])' role="button" tabindex="0" aria-label="Buka album {{ $album->judul }}" @endif>
                                <x-foto :src="$album->sampul" :alt="$album->judul" />
                            </div>
                            <div class="kartu-isi">
                                <span class="meta">
                                    {{ $album->kategori }}@if ($album->kategori) • @endif{{ $album->tanggal_kegiatan?->translatedFormat('j F Y') }} • {{ $daftarFoto->count() }} foto
                                </span>
                                <h3>{{ $album->judul }}</h3>
                                @if ($album->deskripsi) <p>{{ $album->deskripsi }}</p> @endif
                                @if ($daftarFoto->isNotEmpty())
                                    <button type="button" class="tautan-panah" data-buka-album>Lihat album →</button>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
                <x-penomoran :data="$galeri" satuan="album" />
            @endif
        </div>
    </section>

    {{-- Penampil foto layar penuh --}}
    <div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Foto album">
        <div class="lb-judul" id="lb-judul"></div>
        <button type="button" class="lb-tutup" aria-label="Tutup"><x-ikon nama="tutup" /></button>
        <button type="button" class="lb-kiri" aria-label="Foto sebelumnya"><x-ikon nama="kiri" /></button>
        <img id="lb-gambar" alt="">
        <button type="button" class="lb-kanan" aria-label="Foto berikutnya"><x-ikon nama="kanan" /></button>
        <div class="lb-hitung" id="lb-hitung"></div>
    </div>
@endsection

@push('skrip')
<script>
(function () {
    var lb = document.getElementById('lightbox');
    var gambar = document.getElementById('lb-gambar');
    var judul = document.getElementById('lb-judul');
    var hitung = document.getElementById('lb-hitung');
    var album = null, posisi = 0;

    function tampil() {
        gambar.src = album.foto[posisi];
        gambar.alt = album.judul + ' — foto ' + (posisi + 1);
        judul.textContent = album.judul;
        hitung.textContent = (posisi + 1) + ' / ' + album.foto.length;
    }
    function buka(data) { album = data; posisi = 0; tampil(); lb.classList.add('buka'); document.body.style.overflow = 'hidden'; }
    function tutup() { lb.classList.remove('buka'); document.body.style.overflow = ''; }
    function geser(n) { if (!album) return; posisi = (posisi + n + album.foto.length) % album.foto.length; tampil(); }

    document.querySelectorAll('.kartu-album').forEach(function (kartu) {
        var bingkai = kartu.querySelector('[data-album]');
        if (!bingkai) return;
        var data = JSON.parse(bingkai.getAttribute('data-album'));
        bingkai.addEventListener('click', function () { buka(data); });
        bingkai.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); buka(data); } });
        var tombol = kartu.querySelector('[data-buka-album]');
        if (tombol) tombol.addEventListener('click', function () { buka(data); });
    });

    lb.querySelector('.lb-tutup').addEventListener('click', tutup);
    lb.querySelector('.lb-kiri').addEventListener('click', function () { geser(-1); });
    lb.querySelector('.lb-kanan').addEventListener('click', function () { geser(1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) tutup(); });
    document.addEventListener('keydown', function (e) {
        if (!lb.classList.contains('buka')) return;
        if (e.key === 'Escape') tutup();
        if (e.key === 'ArrowLeft') geser(-1);
        if (e.key === 'ArrowRight') geser(1);
    });
})();
</script>
@endpush
