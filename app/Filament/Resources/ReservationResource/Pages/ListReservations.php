<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use App\Filament\Resources\ReservationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;
use Filament\Tables;

class ListReservations extends ListRecords
{
    protected static string $resource = ReservationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')->label('Usuario')->searchable(),
                Tables\Columns\TextColumn::make('schedule.day_of_week')
                    ->label('Día de la semana')
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        // Obtener el día de la semana y el reservation_date
                        $dayOfWeek = $record->schedule->day_of_week ?? null;
                        $reservationDate = $record->reservation_date ?? null;

                        if ($dayOfWeek && $reservationDate) {
                            $formattedDate = \Carbon\Carbon::parse($reservationDate)->format('d/m/Y');
                            return "{$dayOfWeek} ({$formattedDate})";
                        }

                        return null;
                    }),
                Tables\Columns\TextColumn::make('schedule.start_time')
                    ->label('Hora de inicio')
                    ->dateTime('H:i'),
                Tables\Columns\TextColumn::make('schedule.end_time')
                    ->label('Hora de fin')
                    ->dateTime('H:i'),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha de reserva')
                    ->dateTime('d/m/Y H:i'),
                Tables\Columns\TextColumn::make('status')->label('Estado'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
