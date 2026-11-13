<?php

namespace App\Filament\Resources\Beritas;

use App\Filament\Resources\Beritas\Pages\CreateBerita;
use App\Filament\Resources\Beritas\Pages\EditBerita;
use App\Filament\Resources\Beritas\Pages\ListBeritas;
use App\Models\Berita;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

class BeritaResource extends Resource
{
    protected static ?string $model = Berita::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Berita';

    protected static ?string $pluralModelLabel = 'Berita & Kegiatan';

    protected static ?string $slug = 'berita';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Isi Berita')->schema([
                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('ringkasan')
                            ->helperText('Ditampilkan di kartu berita. Kosongkan untuk memakai awal isi berita.')
                            ->rows(3)
                            ->maxLength(300),
                        RichEditor::make('isi')
                            ->required()
                            ->fileAttachmentsDirectory('berita/lampiran'),
                    ]),
                ])->columnSpan(2),

                Group::make([
                    Section::make('Pengaturan')->schema([
                        FileUpload::make('gambar')
                            ->label('Gambar utama')
                            ->image()
                            ->imageEditor()
                            ->directory('berita')
                            ->maxSize(2048),
                        TextInput::make('keterangan_gambar')
                            ->placeholder('Membaca bersama di perpustakaan sekolah.')
                            ->maxLength(255),
                        Select::make('kategori')
                            ->options(Berita::KATEGORI)
                            ->default('Kegiatan'),
                        TextInput::make('topik')
                            ->placeholder('Literasi dan kebiasaan membaca')
                            ->maxLength(255),
                        TextInput::make('penulis')
                            ->label('Penulis / dokumentasi')
                            ->placeholder('Tim Publikasi Sekolah')
                            ->maxLength(255),
                        DateTimePicker::make('tanggal_terbit')
                            ->default(now())
                            ->native(false),
                        Toggle::make('diterbitkan')
                            ->label('Terbitkan')
                            ->default(true),
                    ]),
                ])->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_terbit', 'desc')
            ->columns([
                ImageColumn::make('gambar')->square(),
                TextColumn::make('judul')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('kategori')->badge(),
                TextColumn::make('tanggal_terbit')
                    ->dateTime('d M Y')
                    ->sortable(),
                IconColumn::make('diterbitkan')->label('Terbit')->boolean(),
                TextColumn::make('dilihat')->numeric()->sortable(),
                TextColumn::make('penulis.name')
                    ->label('Penulis')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('kategori')->options(Berita::KATEGORI),
                TernaryFilter::make('diterbitkan')->label('Status terbit'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBeritas::route('/'),
            'create' => CreateBerita::route('/create'),
            'edit' => EditBerita::route('/{record}/edit'),
        ];
    }
}
