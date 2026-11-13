<?php

namespace App\Filament\Pages;

use App\Filament\Support\HalamanSatuData;
use App\Models\ProfilSekolah;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class ProfilSekolahPage extends HalamanSatuData
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Sekolah';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Profil Sekolah';

    protected static ?string $title = 'Pengelolaan Profil Sekolah';

    protected static ?string $slug = 'profil';

    protected function ambilData(): Model
    {
        return ProfilSekolah::data();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('profil')
                ->persistTabInQueryString()
                ->tabs([
                    Tab::make('Identitas')
                        ->icon(Heroicon::OutlinedIdentification)
                        ->columns(2)
                        ->schema([
                            TextInput::make('nama_sekolah')->required()->maxLength(255),
                            TextInput::make('slogan')
                                ->helperText('Tampil di bawah nama sekolah pada header.')
                                ->maxLength(255),
                            TextInput::make('jenjang')->placeholder('Sekolah Dasar')->maxLength(255),
                            TextInput::make('npsn')->label('NPSN')->maxLength(20),
                            Select::make('akreditasi')
                                ->options(['A' => 'A', 'B' => 'B', 'C' => 'C', 'Belum' => 'Belum terakreditasi']),
                            FileUpload::make('logo')
                                ->helperText('Bila kosong, dipakai ikon buku.')
                                ->image()
                                ->directory('profil')
                                ->maxSize(1024),
                        ]),

                    Tab::make('Beranda')
                        ->icon(Heroicon::OutlinedHome)
                        ->schema([
                            Section::make('Bagian utama (hero)')->columns(2)->schema([
                                TextInput::make('hero_judul')
                                    ->label('Judul besar')
                                    ->placeholder('Tempat tumbuh, belajar, dan menjadi berarti.')
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Textarea::make('hero_deskripsi')->label('Deskripsi singkat')->rows(2)->columnSpanFull(),
                                FileUpload::make('gambar_banner')
                                    ->label('Foto sekolah')
                                    ->helperText('Dipakai di beranda, profil, dan PPDB.')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('profil')
                                    ->maxSize(3072)
                                    ->columnSpanFull(),
                            ]),
                            Section::make('Mengenal sekolah')->schema([
                                TextInput::make('pengenalan_judul')
                                    ->label('Judul')
                                    ->placeholder('Pendidikan yang dekat dengan kehidupan.')
                                    ->maxLength(255),
                                Textarea::make('pengenalan')
                                    ->label('Paragraf pengenalan')
                                    ->helperText('Pisahkan paragraf dengan baris kosong.')
                                    ->rows(5),
                            ]),
                        ]),

                    Tab::make('Sambutan Kepala Sekolah')
                        ->icon(Heroicon::OutlinedChatBubbleBottomCenterText)
                        ->columns(3)
                        ->schema([
                            Section::make()->columnSpan(1)->schema([
                                TextInput::make('nama_kepala_sekolah')->maxLength(255),
                                FileUpload::make('foto_kepala_sekolah')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('profil')
                                    ->maxSize(1024),
                            ]),
                            Section::make()->columnSpan(2)->schema([
                                TextInput::make('kutipan_sambutan')
                                    ->label('Kutipan')
                                    ->placeholder('Setiap anak membawa potensi yang layak kita rawat bersama.')
                                    ->maxLength(255),
                                Textarea::make('sambutan')->label('Isi sambutan')->rows(5),
                            ]),
                        ]),

                    Tab::make('Sejarah, Visi & Misi')
                        ->icon(Heroicon::OutlinedBookOpen)
                        ->schema([
                            RichEditor::make('sejarah'),
                            Textarea::make('visi')->rows(3),
                            Repeater::make('misi')
                                ->simple(TextInput::make('butir')->required())
                                ->addActionLabel('Tambah butir misi')
                                ->reorderable(),
                        ]),

                    Tab::make('Fasilitas')
                        ->icon(Heroicon::OutlinedBuildingOffice2)
                        ->schema([
                            Repeater::make('fasilitas')
                                ->hiddenLabel()
                                ->columns(2)
                                ->schema([
                                    TextInput::make('nama')->required()->maxLength(100),
                                    Textarea::make('deskripsi')->rows(2),
                                    FileUpload::make('foto')
                                        ->image()
                                        ->directory('fasilitas')
                                        ->maxSize(2048)
                                        ->columnSpanFull(),
                                ])
                                ->itemLabel(fn (array $state): ?string => $state['nama'] ?? null)
                                ->addActionLabel('Tambah fasilitas')
                                ->collapsible()
                                ->reorderable(),
                        ]),

                    Tab::make('Struktur Organisasi')
                        ->icon(Heroicon::OutlinedUsers)
                        ->schema([
                            Repeater::make('struktur_organisasi')
                                ->hiddenLabel()
                                ->helperText('Butir pertama tampil paling atas sebagai pimpinan.')
                                ->columns(2)
                                ->schema([
                                    TextInput::make('jabatan')->required()->maxLength(100),
                                    TextInput::make('nama')->maxLength(150),
                                ])
                                ->addActionLabel('Tambah jabatan')
                                ->reorderable(),
                        ]),

                    Tab::make('Statistik')
                        ->icon(Heroicon::OutlinedChartBar)
                        ->columns(4)
                        ->schema([
                            TextInput::make('jumlah_siswa')->numeric()->minValue(0)->default(0),
                            TextInput::make('jumlah_guru')->numeric()->minValue(0)->default(0),
                            TextInput::make('jumlah_kelas')->numeric()->minValue(0)->default(0),
                            TextInput::make('jumlah_ekstrakurikuler')->numeric()->minValue(0)->default(0),
                        ]),

                    Tab::make('Kontak & Lokasi')
                        ->icon(Heroicon::OutlinedMapPin)
                        ->columns(2)
                        ->schema([
                            Textarea::make('alamat')->rows(2)->columnSpanFull(),
                            TextInput::make('telepon')->tel()->maxLength(30),
                            TextInput::make('whatsapp')
                                ->tel()
                                ->placeholder('6281234567890')
                                ->helperText('Format internasional tanpa tanda +')
                                ->maxLength(30),
                            TextInput::make('email')->email()->maxLength(255),
                            Textarea::make('jam_operasional')
                                ->label('Jam layanan')
                                ->placeholder("Senin–Jumat: 07.30–14.00 WIB\nSabtu–Minggu: Tidak melayani")
                                ->helperText('Satu baris untuk tiap hari/jadwal.')
                                ->rows(3),
                            TextInput::make('google_maps_link')
                                ->label('Link Google Maps')
                                ->url()
                                ->helperText('Untuk tombol "Buka di Google Maps".')
                                ->columnSpanFull(),
                            Textarea::make('google_maps_embed')
                                ->label('Link embed Google Maps')
                                ->helperText('Di Google Maps: Bagikan → Sematkan peta → salin alamat di dalam src="..."')
                                ->rows(2)
                                ->columnSpanFull(),
                        ]),

                    Tab::make('Media Sosial')
                        ->icon(Heroicon::OutlinedShare)
                        ->columns(2)
                        ->schema([
                            TextInput::make('facebook')->url()->prefixIcon(Heroicon::OutlinedLink),
                            TextInput::make('instagram')->url()->prefixIcon(Heroicon::OutlinedLink),
                            TextInput::make('youtube')->url()->prefixIcon(Heroicon::OutlinedLink),
                            TextInput::make('tiktok')->url()->prefixIcon(Heroicon::OutlinedLink),
                        ]),
                ]),
        ]);
    }
}
