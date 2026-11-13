<?php

namespace App\Filament\Pages;

use App\Filament\Support\HalamanSatuData;
use App\Models\InfoPpdb;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class InfoPpdbPage extends HalamanSatuData
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Sekolah';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Informasi PPDB';

    protected static ?string $title = 'Informasi PPDB';

    protected static ?string $slug = 'ppdb';

    protected function ambilData(): Model
    {
        return InfoPpdb::data();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Status Pendaftaran')
                ->columns(3)
                ->schema([
                    TextInput::make('tahun_ajaran')->placeholder('2027/2028')->maxLength(20),
                    DatePicker::make('tanggal_buka')->native(false),
                    DatePicker::make('tanggal_tutup')->native(false)->afterOrEqual('tanggal_buka'),
                    TextInput::make('kuota')->numeric()->minValue(0)->suffix('siswa'),
                    Toggle::make('dibuka')
                        ->label('Pendaftaran sedang dibuka')
                        ->inline(false),
                ]),

            Section::make('Bagian Atas Halaman')
                ->columns(2)
                ->schema([
                    TextInput::make('judul')
                        ->placeholder('Langkah awal untuk tumbuh bersama.')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('deskripsi')->rows(3)->columnSpanFull(),
                    FileUpload::make('gambar')
                        ->helperText('Bila kosong, dipakai foto sekolah dari Profil.')
                        ->image()
                        ->directory('ppdb')
                        ->maxSize(3072)
                        ->columnSpanFull(),
                ]),

            Section::make('Siapa yang Dapat Mendaftar?')->schema([
                Textarea::make('ketentuan_pengantar')->label('Kalimat pengantar')->rows(2),
                Repeater::make('ketentuan')
                    ->label('Butir ketentuan')
                    ->simple(TextInput::make('butir')->required())
                    ->addActionLabel('Tambah ketentuan')
                    ->reorderable(),
                Textarea::make('ketentuan_catatan')->label('Catatan kecil')->rows(2),
            ]),

            Section::make('Daftar Berkas yang Disiapkan')->schema([
                Repeater::make('persyaratan')
                    ->hiddenLabel()
                    ->simple(TextInput::make('berkas')->required())
                    ->addActionLabel('Tambah berkas')
                    ->reorderable(),
                Textarea::make('persyaratan_catatan')->label('Catatan kecil')->rows(2),
            ]),

            Section::make('Jadwal & Tahapan')->schema([
                Repeater::make('tahapan')
                    ->hiddenLabel()
                    ->columns(2)
                    ->schema([
                        TextInput::make('judul')->required(),
                        TextInput::make('tanggal')->placeholder('1–12 Juni 2027'),
                        Textarea::make('keterangan')->rows(2)->columnSpanFull(),
                    ])
                    ->itemLabel(fn (array $state): ?string => $state['judul'] ?? null)
                    ->addActionLabel('Tambah tahapan')
                    ->collapsible()
                    ->reorderable(),
            ]),

            Section::make('Cara Memperoleh Petunjuk Pendaftaran')->schema([
                RichEditor::make('cara_pendaftaran')->hiddenLabel(),
            ]),

            Section::make('Biaya (opsional)')->collapsed()->schema([
                RichEditor::make('biaya')->hiddenLabel(),
            ]),

            Section::make('Kontak Panitia & Tautan')
                ->columns(2)
                ->schema([
                    TextInput::make('email_panitia')->email(),
                    TextInput::make('telepon_panitia')->tel()->maxLength(30),
                    TextInput::make('link_pendaftaran')
                        ->url()
                        ->helperText('Link formulir online (misalnya Google Form), bila ada.')
                        ->columnSpanFull(),
                    FileUpload::make('brosur')
                        ->label('Brosur PPDB (PDF/gambar)')
                        ->directory('ppdb')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->maxSize(5120)
                        ->downloadable()
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
