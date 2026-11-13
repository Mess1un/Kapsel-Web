{{--
    Layout utama halaman publik: pita atas, header + menu, isi halaman, footer.
    Variabel $profil (data Profil Sekolah) tersedia otomatis di semua view situs.*
--}}
@php
    $menu = [
        'Beranda' => ['beranda', 'beranda'],
        'Profil' => ['profil', 'profil'],
        'Guru' => ['guru', 'guru'],
        'Pengumuman' => ['pengumuman.index', 'pengumuman.*'],
        'Berita' => ['berita.index', 'berita.*'],
        'Galeri' => ['galeri', 'galeri'],
        'Kontak' => ['kontak', 'kontak'],
    ];
    $deskripsiHalaman = trim($__env->yieldContent('deskripsi')) ?: ($profil->hero_deskripsi ?? $profil->slogan);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@hasSection('judul')@yield('judul') — @endif{{ $profil->nama_sekolah }}</title>
    @if ($deskripsiHalaman)
        <meta name="description" content="{{ str($deskripsiHalaman)->limit(160) }}">
    @endif
    <meta property="og:title" content="@hasSection('judul')@yield('judul') — @endif{{ $profil->nama_sekolah }}">
    <meta property="og:site_name" content="{{ $profil->nama_sekolah }}">
    @if ($profil->logo)
        <link rel="icon" href="{{ Storage::url($profil->logo) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/situs.css') }}?v={{ filemtime(public_path('css/situs.css')) }}">
</head>
<body>
    <div class="pita-atas">
        <div class="wadah">
            <div>
                @if ($profil->telepon) <span>Telepon: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $profil->telepon) }}">{{ $profil->telepon }}</a></span> @endif
                @if ($profil->email) <span class="email">&nbsp;•&nbsp; <a href="mailto:{{ $profil->email }}">{{ $profil->email }}</a></span> @endif
            </div>
            @if ($profil->alamat)
                <div class="alamat"><x-ikon nama="lokasi" /> {{ str($profil->alamat)->before(',') }}</div>
            @endif
        </div>
    </div>

    <header class="header">
        <div class="wadah">
            <a href="{{ route('beranda') }}" class="merek">
                <span class="merek-logo">
                    @if ($profil->logo)
                        <img src="{{ Storage::url($profil->logo) }}" alt="">
                    @else
                        <x-ikon nama="buku" style="width:20px;height:20px" />
                    @endif
                </span>
                <span>
                    <span class="merek-nama">{{ $profil->nama_sekolah }}</span><br>
                    @if ($profil->slogan) <span class="merek-slogan">{{ $profil->slogan }}</span> @endif
                </span>
            </a>

            <button class="tombol-menu" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="menu-utama" data-tombol-menu>
                <x-ikon nama="menu" style="width:22px;height:22px" />
            </button>

            <nav class="nav" id="menu-utama" aria-label="Menu utama">
                @foreach ($menu as $label => [$rute, $pola])
                    <a href="{{ route($rute) }}" @class(['aktif' => request()->routeIs($pola)]) @if (request()->routeIs($pola)) aria-current="page" @endif>{{ $label }}</a>
                @endforeach
                <a href="{{ route('ppdb') }}" class="tombol tombol-oranye tombol-kecil">PPDB Info</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('isi')
    </main>

    <footer class="footer">
        <div class="wadah">
            <div class="footer-atas">
                <div>
                    <a href="{{ route('beranda') }}" class="merek">
                        <span class="merek-logo"><x-ikon nama="buku" style="width:18px;height:18px" /></span>
                        <span>
                            <span class="merek-nama">{{ $profil->nama_sekolah }}</span><br>
                            @if ($profil->slogan) <span class="merek-slogan">{{ $profil->slogan }}</span> @endif
                        </span>
                    </a>
                    <p style="margin-top:14px">Ruang informasi dan kabar sekolah untuk orang tua, guru, dan masyarakat. Bersama mendampingi setiap langkah anak.</p>
                    @php
                        $medsos = collect(['facebook', 'instagram', 'youtube', 'tiktok'])->filter(fn ($m) => filled($profil->$m));
                    @endphp
                    @if ($medsos->isNotEmpty())
                        <div class="medsos">
                            @foreach ($medsos as $m)
                                <a href="{{ $profil->$m }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($m) }}"><x-ikon :nama="$m" /></a>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div>
                    <h4>Jelajahi sekolah</h4>
                    <ul>
                        <li><a href="{{ route('profil') }}">Profil Sekolah</a></li>
                        <li><a href="{{ route('guru') }}">Informasi Guru</a></li>
                        <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                        <li><a href="{{ route('ppdb') }}">Informasi PPDB</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Hubungi sekolah</h4>
                    @if ($profil->alamat) <p>{{ $profil->alamat }}</p> @endif
                    <p>
                        @if ($profil->email) <a href="mailto:{{ $profil->email }}">{{ $profil->email }}</a><br> @endif
                        @if ($profil->telepon) Telepon: {{ $profil->telepon }} @endif
                    </p>
                    @if ($profil->jam_operasional)
                        <p style="font-size:12px">{{ str($profil->jam_operasional)->before("\n") }}</p>
                    @endif
                </div>
            </div>
            <div class="footer-bawah">
                <span>&copy; {{ date('Y') }} {{ $profil->nama_sekolah }}. Seluruh hak cipta dilindungi.</span>
                <a href="{{ url('/admin') }}">Akses Admin</a>
            </div>
        </div>
    </footer>

    <script>
        // Menu HP: buka/tutup daftar menu
        (function () {
            var tombol = document.querySelector('[data-tombol-menu]');
            var nav = document.getElementById('menu-utama');
            if (!tombol || !nav) return;
            tombol.addEventListener('click', function () {
                var buka = nav.classList.toggle('buka');
                tombol.setAttribute('aria-expanded', buka ? 'true' : 'false');
            });
        })();
    </script>
    @stack('skrip')
</body>
</html>
