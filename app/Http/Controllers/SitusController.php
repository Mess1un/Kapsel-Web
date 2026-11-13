<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\InfoPpdb;
use App\Models\Pengumuman;
use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Halaman publik website sekolah.
 * Data $profil (identitas & kontak sekolah) otomatis tersedia di semua view lewat AppServiceProvider.
 */
class SitusController extends Controller
{
    public function beranda(): View
    {
        // Satu foto (sampul) dari tiap album terbaru untuk bagian "Momen kebersamaan".
        $galeriTerbaru = Galeri::terbit()->take(6)->get()
            ->filter(fn (Galeri $album) => filled($album->sampul))
            ->take(3);

        return view('situs.beranda', [
            'beritaTerbaru' => Berita::terbit()->take(3)->get(),
            'pengumumanTerbaru' => Pengumuman::terbit()->reorder()->orderByDesc('penting')->orderByDesc('tanggal_terbit')->take(3)->get(),
            'galeriTerbaru' => $galeriTerbaru,
            'fotoGuru' => Guru::aktif()->whereNotNull('foto')->value('foto'),
            'ppdb' => InfoPpdb::query()->first(),
        ]);
    }

    public function profil(): View
    {
        return view('situs.profil');
    }

    public function guru(Request $request): View
    {
        $guru = Guru::aktif()
            ->when($request->filled('cari'), fn ($q) => $q->where(fn ($q) => $q
                ->where('nama', 'like', '%' . $request->cari . '%')
                ->orWhere('jabatan', 'like', '%' . $request->cari . '%')
                ->orWhere('mata_pelajaran', 'like', '%' . $request->cari . '%')))
            ->when($request->filled('bidang'), fn ($q) => $q->where(fn ($q) => $q
                ->where('jabatan', $request->bidang)
                ->orWhere('mata_pelajaran', $request->bidang)))
            ->get();

        $bidang = Guru::where('aktif', true)->pluck('jabatan')
            ->merge(Guru::where('aktif', true)->pluck('mata_pelajaran'))
            ->filter()->unique()->sort()->values();

        return view('situs.guru', compact('guru', 'bidang'));
    }

    public function pengumuman(Request $request): View
    {
        $pengumuman = Pengumuman::terbit()
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori', $request->kategori))
            ->when($request->filled('cari'), fn ($q) => $q->where('judul', 'like', '%' . $request->cari . '%'))
            ->paginate(9)
            ->withQueryString();

        return view('situs.pengumuman.index', [
            'pengumuman' => $pengumuman,
            'kategori' => Pengumuman::KATEGORI,
            'terakhirDiperbarui' => Pengumuman::terbit()->value('tanggal_terbit'),
        ]);
    }

    public function detailPengumuman(Pengumuman $pengumuman): View
    {
        abort_unless($this->sudahTerbit($pengumuman), 404);

        return view('situs.pengumuman.show', [
            'pengumuman' => $pengumuman,
            'lainnya' => Pengumuman::terbit()->whereKeyNot($pengumuman->id)->take(3)->get(),
        ]);
    }

    public function berita(Request $request): View
    {
        $berita = Berita::terbit()
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori', $request->kategori))
            ->when($request->filled('cari'), fn ($q) => $q->where('judul', 'like', '%' . $request->cari . '%'))
            ->paginate(9)
            ->withQueryString();

        return view('situs.berita.index', [
            'berita' => $berita,
            'kategori' => Berita::KATEGORI,
        ]);
    }

    public function detailBerita(Berita $berita): View
    {
        abort_unless($this->sudahTerbit($berita), 404);

        $berita->increment('dilihat');

        return view('situs.berita.show', [
            'berita' => $berita,
            'terkait' => Berita::terbit()->whereKeyNot($berita->id)->take(3)->get(),
        ]);
    }

    public function galeri(Request $request): View
    {
        $galeri = Galeri::terbit()
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori', $request->kategori))
            ->paginate(10)
            ->withQueryString();

        return view('situs.galeri', [
            'galeri' => $galeri,
            'kategori' => Galeri::where('diterbitkan', true)->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori'),
        ]);
    }

    public function ppdb(): View
    {
        return view('situs.ppdb', ['ppdb' => InfoPpdb::data()]);
    }

    public function kontak(): View
    {
        return view('situs.kontak');
    }

    private function sudahTerbit(Berita|Pengumuman $item): bool
    {
        return $item->diterbitkan && ($item->tanggal_terbit === null || $item->tanggal_terbit->lte(now()));
    }
}
