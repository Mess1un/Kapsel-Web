@props(['nama'])
{{-- Ikon garis sederhana (gaya Lucide). Pemakaian: <x-ikon nama="telepon" /> --}}
<svg {{ $attributes->merge(['class' => 'ikon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
@switch($nama)
    @case('buku')
        <path d="M2 4h6a4 4 0 0 1 4 4v13a3 3 0 0 0-3-3H2z"/><path d="M22 4h-6a4 4 0 0 0-4 4v13a3 3 0 0 1 3-3h7z"/>
        @break
    @case('telepon')
        <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>
        @break
    @case('email')
        <rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>
        @break
    @case('lokasi')
        <path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/>
        @break
    @case('jam')
        <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
        @break
    @case('info')
        <circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>
        @break
    @case('cari')
        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
        @break
    @case('centang')
        <rect x="3" y="3" width="18" height="18" rx="3"/><path d="m8 12 3 3 5-6"/>
        @break
    @case('menu')
        <path d="M4 6h16M4 12h16M4 18h16"/>
        @break
    @case('tutup')
        <path d="M18 6 6 18M6 6l12 12"/>
        @break
    @case('kiri')
        <path d="m15 18-6-6 6-6"/>
        @break
    @case('kanan')
        <path d="m9 18 6-6-6-6"/>
        @break
    @case('gambar')
        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.1-3.1a2 2 0 0 0-2.8 0L6 21"/>
        @break
    @case('pengguna')
        <circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>
        @break
    @case('unduh')
        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
        @break
    @case('facebook')
        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
        @break
    @case('instagram')
        <rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01"/>
        @break
    @case('youtube')
        <path d="M2.5 17a24 24 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.6 49.6 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24 24 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.6 49.6 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/>
        @break
    @case('tiktok')
        <path d="M9 12a4 4 0 1 0 4 4V2a5 5 0 0 0 5 5"/>
        @break
@endswitch
</svg>
