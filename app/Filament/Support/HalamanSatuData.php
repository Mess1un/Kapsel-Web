<?php

namespace App\Filament\Support;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

/**
 * Halaman admin untuk data yang hanya ada satu baris (Profil Sekolah, Informasi PPDB).
 * Turunan cukup mengisi ambilData() dan form().
 *
 * @property-read Schema $form
 */
abstract class HalamanSatuData extends Page
{
    /** @var array<string, mixed>|null */
    public ?array $data = [];

    abstract protected function ambilData(): Model;

    public function mount(): void
    {
        $this->form->fill($this->ambilData()->attributesToArray());
    }

    public function defaultForm(Schema $schema): Schema
    {
        return $schema
            ->operation('edit')
            ->model($this->ambilData())
            ->statePath('data');
    }

    public function form(Schema $schema): Schema
    {
        return $schema;
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('simpan')
                ->footer([
                    Actions::make([
                        Action::make('simpan')
                            ->label('Simpan perubahan')
                            ->submit('simpan')
                            ->keyBindings(['mod+s']),
                    ])->sticky(),
                ]),
        ]);
    }

    public function simpan(): void
    {
        $data = $this->form->getState();

        $record = $this->ambilData();
        $record->update($data);

        // Simpan relasi/berkas yang dikelola komponen form.
        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->success()
            ->title('Perubahan berhasil disimpan')
            ->send();
    }
}
