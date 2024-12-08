<?php

namespace App\Filament\Resources\ScheduleResource\Pages;

use App\Filament\Resources\ScheduleResource;
use Filament\Forms;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del horario')
                    ->description('Ingrese los datos del nuevo horario')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('day_of_week')
                                    ->label('Día de la semana')
                                    ->required()
                                    ->options([
                                        'Lunes' => 'Lunes',
                                        'Martes' => 'Martes',
                                        'Miércoles' => 'Miércoles',
                                        'Jueves' => 'Jueves',
                                        'Viernes' => 'Viernes',
                                        'Sábado' => 'Sábado',
                                        'Domingo' => 'Domingo',
                                    ]),
                                Forms\Components\TimePicker::make('start_time')
                                    ->label('Hora de inicio')
                                    ->required(),
                                Forms\Components\TimePicker::make('end_time')
                                    ->label('Hora de fin')
                                    ->required(),
                            ]),
                    ])

            ]);
    }
}
