<?php

namespace App\Filament\Resources\Gurus;

use App\Filament\Resources\Gurus\Pages\CreateGuru;
use App\Filament\Resources\Gurus\Pages\EditGuru;
use App\Filament\Resources\Gurus\Pages\ListGurus;
use App\Models\Guru;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|UnitEnum|null $navigationGroup = 'Sekolah';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Guru';

    protected static ?string $pluralModelLabel = 'Data Guru';

    protected static ?string $slug = 'guru';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Data Guru')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama lengkap (dengan gelar)')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('nip')
                            ->label('NIP')
                            ->maxLength(30),
                        TextInput::make('jabatan')
                            ->placeholder('Guru, Wakasek Kurikulum, dll.')
                            ->maxLength(255),
                        TextInput::make('mata_pelajaran')
                            ->maxLength(255),
                        TextInput::make('pendidikan_terakhir')
                            ->placeholder('S1 Pendidikan Matematika')
                            ->maxLength(255),
                    ]),
                Section::make('Foto & Tampilan')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('foto')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->directory('guru')
                            ->maxSize(1024),
                        TextInput::make('urutan')
                            ->label('Urutan tampil')
                            ->helperText('Angka kecil tampil lebih dulu.')
                            ->numeric()
                            ->default(0),
                        Toggle::make('aktif')
                            ->label('Tampilkan di website')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('urutan')
            ->reorderable('urutan')
            ->columns([
                ImageColumn::make('foto')->circular(),
                TextColumn::make('nama')->searchable()->sortable(),
                TextColumn::make('nip')->label('NIP')->searchable()->toggleable(),
                TextColumn::make('jabatan')->searchable(),
                TextColumn::make('mata_pelajaran')->searchable(),
                ToggleColumn::make('aktif'),
            ])
            ->filters([
                TernaryFilter::make('aktif'),
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
            'index' => ListGurus::route('/'),
            'create' => CreateGuru::route('/create'),
            'edit' => EditGuru::route('/{record}/edit'),
        ];
    }
}
