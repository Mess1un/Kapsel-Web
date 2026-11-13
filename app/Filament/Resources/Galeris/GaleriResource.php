<?php

namespace App\Filament\Resources\Galeris;

use App\Filament\Resources\Galeris\Pages\CreateGaleri;
use App\Filament\Resources\Galeris\Pages\EditGaleri;
use App\Filament\Resources\Galeris\Pages\ListGaleris;
use App\Models\Galeri;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class GaleriResource extends Resource
{
    protected static ?string $model = Galeri::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 3;

    protected static ?string $modelLabel = 'Album';

    protected static ?string $pluralModelLabel = 'Galeri Kegiatan';

    protected static ?string $slug = 'galeri';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Album Kegiatan')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('judul')
                            ->label('Nama kegiatan')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('kategori')
                            ->placeholder('Upacara, Lomba, Study Tour, dll.')
                            ->datalist(fn () => Galeri::query()->whereNotNull('kategori')->distinct()->pluck('kategori')->all())
                            ->maxLength(100),
                        DatePicker::make('tanggal_kegiatan')
                            ->native(false),
                        Toggle::make('diterbitkan')
                            ->label('Terbitkan')
                            ->default(true)
                            ->inline(false),
                        Textarea::make('deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                        FileUpload::make('foto')
                            ->label('Foto kegiatan')
                            ->helperText('Bisa pilih banyak foto sekaligus. Foto pertama menjadi sampul album; seret untuk mengubah urutan.')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->panelLayout('grid')
                            ->directory('galeri')
                            ->maxSize(3072)
                            ->maxFiles(50)
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_kegiatan', 'desc')
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->stacked()
                    ->limit(3)
                    ->limitedRemainingText(),
                TextColumn::make('judul')->searchable()->wrap(),
                TextColumn::make('kategori')->badge(),
                TextColumn::make('tanggal_kegiatan')->date('d M Y')->sortable(),
                IconColumn::make('diterbitkan')->label('Terbit')->boolean(),
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
            'index' => ListGaleris::route('/'),
            'create' => CreateGaleri::route('/create'),
            'edit' => EditGaleri::route('/{record}/edit'),
        ];
    }
}
