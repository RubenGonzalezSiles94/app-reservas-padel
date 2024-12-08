<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Actions;
use App\Models\Schedule;
use Filament\Forms\Form;
use App\Models\Reservation;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\ReservationResource;

class EditReservation extends EditRecord
{
    protected static string $resource = ReservationResource::class;

    public $reservation_date;
    public $schedule_id;
    public $schedule_id_options = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function setScheduleOptions($date)
    {
        $reservation = Reservation::find($this->record->id);

        if ($reservation) {
            $this->reservation_date = $reservation->reservation_date->format('d-m-Y');
            $this->schedule_id = $reservation->schedule_id;
        }

        if ($this->reservation_date) {

            $dayOfWeek = Carbon::parse($date)->isoFormat('dddd');
            $dayOfWeek = ucfirst($dayOfWeek);


            $schedules = Schedule::where('day_of_week', $dayOfWeek)
                ->where('is_active', 1)
                ->get()
                ->mapWithKeys(function ($schedule) {
                    return [
                        $schedule->id => $schedule->start_time->format('H:i') . ' - ' . $schedule->end_time->format('H:i'),
                    ];
                });

            $this->schedule_id_options = $schedules;
        }
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Reserva de Horario')
                    ->description('Sólo se podrá cambiar el estado de la reserva')
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                        Select::make('status')
                            ->label('Estado')
                            ->options([
                                'Reservado' => 'Reservado',
                                'Completado' => 'Completado',
                                'Cancelado' => 'Cancelado',
                            ])
                            ->required(),
                    ])
                    ]),
            ]);
        // self::setScheduleOptions($this->record->reservation_date);
        // return $form
        //     ->schema([

        //         Section::make('Reserva de Horario')
        //             ->schema([
        //                 Forms\Components\Grid::make(2)
        //                     ->schema([
        //                         DatePicker::make('reservation_date')
        //                             ->label('Fecha de Reserva')
        //                             ->required()
        //                             ->minDate(now()->toDateString())
        //                             ->placeholder('Selecciona una fecha')
        //                             ->reactive()
        //                             ->afterStateUpdated(function (callable $set, $state) {
        //                                 if ($state) {
        //                                     Carbon::setLocale('es');
        //                                     $dayOfWeek = Carbon::parse($state)->isoFormat('dddd');
        //                                     $dayOfWeek = ucfirst($dayOfWeek);

        //                                     $schedules = Schedule::where('day_of_week', $dayOfWeek)
        //                                         ->where('is_active', 1)
        //                                         ->get()
        //                                         ->mapWithKeys(function ($schedule) {
        //                                             return [
        //                                                 $schedule->id => $schedule->start_time->format('H:i') . ' - ' . $schedule->end_time->format('H:i'),
        //                                             ];
        //                                         });
        //                                     $set('schedule_id_options', $schedules);
        //                                     $set('schedule_id', null);
        //                                 }
        //                             }),

        //                             Select::make('schedule_id')
        //                             ->label('Horario')
        //                             ->options(function (callable $get) {

        //                                 return $get('schedule_id_options') ?? [];
        //                             })
        //                             ->formatStateUsing(fn () => Schedule::find($this->schedule_id)->start_time->format('H:i').' - '.Schedule::find($this->schedule_id)->end_time->format('H:i'))
        //                             ->required()
        //                             ->searchable()

        //                     ]),

        //                 Forms\Components\Grid::make(2)
        //                     ->schema([
        //                         Select::make('user_id')
        //                             ->label('Usuario')
        //                             ->options(
        //                                 User::all()->pluck('email', 'id')
        //                             )
        //                             ->required()
        //                             ->searchable(),

        //                         Select::make('status')
        //                             ->label('Estado')
        //                             ->options([
        //                                 'Reservado' => 'Reservado',
        //                                 'Completado' => 'Completado',
        //                                 'Cancelado' => 'Cancelado',
        //                             ])
        //                             ->required(),
        //                     ]),
        //             ])
        //     ]);
    }
}
