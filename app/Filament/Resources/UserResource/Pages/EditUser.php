<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Usuario')
                    ->description('Ingrese los datos del nuevo usuario')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('first_name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('last_name')
                                    ->label('Apellidos')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->columnSpan(1),
                                TextInput::make('password')
                                    ->password()
                                    ->nullable()
                                    ->dehydrated(fn($state) => filled($state))
                                    ->label('Nueva contraseña')
                                    ->columnSpan(1),
                                Toggle::make('status')
                                    ->label('Activo')
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->columns(2)
                    ->collapsible()
            ]);
    }




    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        return $data;
    }
}
