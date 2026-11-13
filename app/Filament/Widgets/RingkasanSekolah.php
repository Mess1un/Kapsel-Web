<?php

namespace App\Filament\Widgets;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Pengumuman;
use App\Models\PesanKontak;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RingkasanSekolah extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Berita', Berita::count())
                ->description(Berita::where('diterbitkan', true)->count() . ' sudah terbit')
                ->icon(Heroicon::OutlinedNewspaper),
            Stat::make('Pengumuman', Pengumuman::count())
                ->description(Pengumuman::where('penting', true)->count() . ' ditandai penting')
                ->icon(Heroicon::OutlinedMegaphone),
            Stat::make('Guru aktif', Guru::where('aktif', true)->count())
                ->icon(Heroicon::OutlinedUserGroup),
            Stat::make('Album galeri', Galeri::count())
                ->icon(Heroicon::OutlinedPhoto),
            Stat::make('Pesan belum dibaca', PesanKontak::where('sudah_dibaca', false)->count())
                ->icon(Heroicon::OutlinedInbox)
                ->color('warning'),
        ];
    }
}
