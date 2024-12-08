<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use Filament\Forms;
use App\Models\User;
use Filament\Actions;
use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ReservationResource;
use Filament\Forms\Components\Section;
use Carbon\Carbon;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Reserva de Horario')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                DatePicker::make('reservation_date')
                                    ->label('Fecha de Reserva')
                                    ->required()
                                    ->minDate(now()->toDateString())
                                    ->placeholder('Selecciona una fecha')
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        if ($state) {
                                            Carbon::setLocale('es');
                                            $dayOfWeek = Carbon::parse($state)->isoFormat('dddd');
                                            $dayOfWeek = ucfirst($dayOfWeek);

                                            $schedules = Schedule::where('day_of_week', $dayOfWeek)
                                                ->where('is_active', 1)
                                                ->get()
                                                ->mapWithKeys(function ($schedule) {
                                                    return [
                                                        $schedule->id => $schedule->start_time->format('H:i') . ' - ' . $schedule->end_time->format('H:i'),
                                                    ];
                                                });

                                            $set('schedule_id_options', $schedules);
                                        }
                                    }),

                                Select::make('schedule_id')
                                    ->label('Horario')
                                    ->options(function (callable $get) {
                                        return $get('schedule_id_options') ?? [];
                                    })
                                    ->required()
                                    ->searchable(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('Usuario')
                                    ->options(
                                        User::all()->pluck('email', 'id')
                                    )
                                    ->required()
                                    ->searchable(),

                                Select::make('status')
                                    ->label('Estado')
                                    ->options([
                                        'Reservado' => 'Reservado',
                                        'Completado' => 'Completado',
                                        'Cancelado' => 'Cancelado',
                                    ])
                                    ->required(),
                            ]),
                    ])
            ]);
    }
}
