<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\Setting;

class Dashboard extends Component
{
    public $selectedDate;
    public $canReserve;
    public $maxDaysAvailable;
    public $availableSchedules = [];

    public function updated($name, $value)
    {
        if ($name === 'selectedDate') {
            $this->dispatch('contentChanged');
        }
    }


    public function updateTimeReserve($date)
    {
        $carbonDate = Carbon::parse($date);
        $dayOfWeekInSpanish = $carbonDate->locale('es')->dayName;


        $scheduleForDay = Schedule::where('day_of_week', '=', $dayOfWeekInSpanish)
            ->where('is_active', true)
            ->get();

        $this->availableSchedules = $scheduleForDay->filter(function ($schedule) use ($carbonDate) {
            return !Reservation::reservedOnDate($schedule->id, $carbonDate->toDateString())->exists();
        });
        $this->selectedDate = $date;
    }

    public function confirmReserve($scheduleId)
    {
        $formattedDate = Carbon::parse($this->selectedDate)->format('Y-m-d');
        $this->dispatch('confirm-reserve', ['scheduleId' => $scheduleId, 'date' => $formattedDate]);
    }

    public function reserveSlot($scheduleId)
    {
        $id = $scheduleId[0]['scheduleId'];
        $date = $scheduleId[0]['date'];

        $schedule = Schedule::find($id);

        if ($schedule && !Reservation::reservedOnDate($schedule->id, Carbon::parse($date)->toDateString())->exists()) {
            Reservation::create([
                'user_id' => auth()->id(),
                'schedule_id' => $schedule->id,
                'reservation_date' => Carbon::parse($this->selectedDate)->toDateString(),
                'status' => 'Reservado',
            ]);

            session()->flash('message', '¡Reserva realizada con éxito!');
            $this->reset();
            self::canReserve();
        } else {
            session()->flash('error', 'Este horario ya está reservado.');
        }
    }

    private function canReserve()
    {
        $this->canReserve = true;
        if (Setting::isMaxReservationActive())
            if (auth()->user()->reservations()->where('status', 'Reservado')->count() >= Setting::getMaxReservation())
                $this->canReserve = false;

        if (Setting::isActiveLimitDays())
            $this->maxDaysAvailable = Setting::getLimitDays();
    }

    public function mount()
    {
        self::canReserve();
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
