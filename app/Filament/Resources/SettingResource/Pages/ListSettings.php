<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        $maintenanceMode = Setting::where('key', 'maintenance_mode')->first();
        $isActive = $maintenanceMode?->value == '1';

        return [
            Actions\Action::make('toggleMaintenance')
                ->label($isActive ? 'Desactivar modo mantenimiento' : 'Activar modo mantenimiento')
                ->color($isActive ? 'success' : 'warning')
                ->icon($isActive ? 'heroicon-o-check' : 'heroicon-o-wrench')
                ->requiresConfirmation()
                ->modalHeading('¿Estás seguro?')
                ->modalDescription('¿Deseas cambiar el estado del modo mantenimiento?')
                ->modalSubmitActionLabel('Sí, cambiar')
                ->modalCancelActionLabel('No, cancelar')
                ->action(function () use ($maintenanceMode) {
                    if ($maintenanceMode) {
                        $newValue = $maintenanceMode->value == '1' ? '0' : '1';
                        $maintenanceMode->update([
                            'value' => $newValue
                        ]);

                        Notification::make()
                            ->title($newValue == '1' ? 'Modo mantenimiento activado' : 'Modo mantenimiento desactivado')
                            ->success()
                            ->send();
                    }
                })
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->whereNotIn('key', [
                'maintenance_mode',
                'days_enabled',
                'max_reservation'
            ]))
            ->columns([
                Tables\Columns\TextColumn::make('description')->label(__('config.description'))->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label(__('config.value'))
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            '0' => 'Deshabilitado',
                            '1' => 'Habilitado',
                            default => $state,
                        };
                    }),
            ]);
    }
}
