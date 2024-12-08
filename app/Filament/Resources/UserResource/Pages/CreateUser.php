<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;


class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Usuario')
                    ->description('Ingrese los datos del nuevo usuario')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nombre')
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
                                    ->required()
                                    ->dehydrated(fn($state) => filled($state))
                                    ->label('Contraseña')
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
}
