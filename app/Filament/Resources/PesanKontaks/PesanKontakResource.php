<?php

namespace App\Filament\Resources\PesanKontaks;

use App\Filament\Resources\PesanKontaks\Pages\ManagePesanKontaks;
use App\Models\PesanKontak;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use UnitEnum;

/**
 * Kotak masuk pesan dari formulir Kontak di website (hanya dibaca, tidak dibuat dari admin).
 */
class PesanKontakResource extends Resource
{
    protected static ?string $model = PesanKontak::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static string|UnitEnum|null $navigationGroup = 'Sekolah';

    protected static ?int $navigationSort = 9;

    protected static ?string $modelLabel = 'Pesan';

    protected static ?string $pluralModelLabel = 'Pesan Masuk';

    protected static ?string $slug = 'pesan-masuk';

    protected static ?string $recordTitleAttribute = 'nama';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        $belumDibaca = PesanKontak::where('sudah_dibaca', false)->count();

        return $belumDibaca > 0 ? (string) $belumDibaca : null;
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('nama'),
                TextEntry::make('email')->copyable(),
                TextEntry::make('telepon')->placeholder('-')->copyable(),
                TextEntry::make('created_at')->label('Dikirim')->dateTime('d M Y, H:i'),
                TextEntry::make('subjek')->placeholder('-')->columnSpanFull(),
                TextEntry::make('pesan')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                IconColumn::make('sudah_dibaca')
                    ->label('Dibaca')
                    ->boolean(),
                TextColumn::make('nama')->searchable()->weight(fn (PesanKontak $r) => $r->sudah_dibaca ? null : 'bold'),
                TextColumn::make('email')->searchable(),
                TextColumn::make('subjek')->searchable()->limit(40),
                TextColumn::make('created_at')->label('Dikirim')->since()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('sudah_dibaca')->label('Status dibaca'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->after(fn (PesanKontak $record) => $record->update(['sudah_dibaca' => true])),
                Action::make('tandaiBelumDibaca')
                    ->label('Belum dibaca')
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->visible(fn (PesanKontak $record) => $record->sudah_dibaca)
                    ->action(fn (PesanKontak $record) => $record->update(['sudah_dibaca' => false])),
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
            'index' => ManagePesanKontaks::route('/'),
        ];
    }
}
