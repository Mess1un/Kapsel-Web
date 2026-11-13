<?php

namespace App\Filament\Resources\Pengumumen;

use App\Filament\Resources\Pengumumen\Pages\CreatePengumuman;
use App\Filament\Resources\Pengumumen\Pages\EditPengumuman;
use App\Filament\Resources\Pengumumen\Pages\ListPengumumen;
use App\Models\Pengumuman;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

class PengumumanResource extends Resource
{
    protected static ?string $model = Pengumuman::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static ?int $navigationSort = 2;

    protected static ?string $modelLabel = 'Pengumuman';

    protected static ?string $pluralModelLabel = 'Pengumuman';

    protected static ?string $slug = 'pengumuman';

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Isi Pengumuman')->schema([
                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('ringkasan')
                            ->helperText('Ditampilkan di kartu pengumuman. Kosongkan untuk memakai awal isi.')
                            ->rows(2)
                            ->maxLength(300),
                        RichEditor::make('isi')
                            ->required()
                            ->fileAttachmentsDirectory('pengumuman/lampiran'),
                    ]),
                ])->columnSpan(2),

                Group::make([
                    Section::make('Pengaturan')->schema([
                        Select::make('kategori')
                            ->options(Pengumuman::KATEGORI)
                            ->default('Umum'),
                        FileUpload::make('lampiran')
                            ->label('Lampiran (PDF/dokumen)')
                            ->directory('pengumuman')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'image/jpeg',
                                'image/png',
                            ])
                            ->maxSize(5120)
                            ->downloadable(),
                        DateTimePicker::make('tanggal_terbit')
                            ->default(now())
                            ->native(false),
                        Toggle::make('penting')
                            ->label('Tandai sebagai penting')
                            ->helperText('Pengumuman penting tampil paling menonjol di beranda.'),
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
                TextColumn::make('judul')
                    ->searchable()
                    ->limit(60)
                    ->wrap(),
                TextColumn::make('kategori')->badge(),
                IconColumn::make('penting')->boolean(),
                TextColumn::make('tanggal_terbit')
                    ->dateTime('d M Y')
                    ->sortable(),
                IconColumn::make('diterbitkan')->label('Terbit')->boolean(),
            ])
            ->filters([
                TernaryFilter::make('penting'),
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
            'index' => ListPengumumen::route('/'),
            'create' => CreatePengumuman::route('/create'),
            'edit' => EditPengumuman::route('/{record}/edit'),
        ];
    }
}
