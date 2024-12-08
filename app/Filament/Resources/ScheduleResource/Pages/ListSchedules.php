<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use Carbon\Carbon;
use Filament\Tables;
use Filament\Actions;
use Filament\Tables\Table;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ScheduleResource;

class ListSchedules extends ListRecords
{
    protected static string $resource = ScheduleResource::class;

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
                //
                Tables\Columns\TextColumn::make('day_of_week')->label('Día de la semana')->searchable(),
                Tables\Columns\TextColumn::make('start_time')
                ->label('Hora de inicio')
                ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('H:i')),
                Tables\Columns\TextColumn::make('end_time')
                ->label('Hora de fin')
                ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('H:i')),
                Tables\Columns\TextColumn::make('is_active')->label('Activo')->formatStateUsing(fn ($state) => $state ? 'Si' : 'No'),
                
            ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            // ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
