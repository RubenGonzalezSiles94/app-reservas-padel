<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Artisan;
use App\Filament\Resources\UserResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('sendWelcomeEmails')
                ->label('Enviar emails de bienvenida')
                ->icon('heroicon-o-envelope')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('¿Enviar emails de bienvenida?')
                ->modalDescription('Se enviarán emails de bienvenida a todos los usuarios no verificados.')
                ->modalSubmitActionLabel('Sí, enviar')
                ->modalCancelActionLabel('No, cancelar')
                ->action(function () {
                    // Obtener el número de usuarios que recibirán el email
                    $userCount = User::whereNull('email_verified_at')
                        ->where('id', '!=', 1)
                        ->count();

                    if ($userCount === 0) {
                        Notification::make()
                            ->title('No hay usuarios pendientes')
                            ->warning()
                            ->send();
                        return;
                    }

                    try {
                        Artisan::call('app:send-welcome-emails');

                        Notification::make()
                            ->title('Emails enviados correctamente')
                            ->success()
                            ->body("Se han enviado {$userCount} emails de bienvenida.")
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error al enviar los emails')
                            ->danger()
                            ->body($e->getMessage())
                            ->send();
                    }
                }),
        ];
    }

    public function getFilters(): array
    {
        return [
            //
            Tables\Filters\TrashedFilter::make(),
            Tables\Filters\SelectFilter::make('role')->relationship('roles', 'name'),
            Tables\Filters\SelectFilter::make('status')->options([
                '1' => 'Habilitado',
                '0' => 'Deshabilitado',
            ])
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                fn() => User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'super_admin');
                })
            )
            ->columns([
                //
                TextColumn::make('first_name')->label('Nombre')->searchable(),
                TextColumn::make('last_name')->label('Apellidos')->searchable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('cif')->label('CIF')->searchable(),
                TextColumn::make('created_at')->label('Fecha de creación')->dateTime('d/m/Y'),
                TextColumn::make('status')->label('Estado')->formatStateUsing(fn($state) => $state ? 'Habilitado' : 'Deshabilitado'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
