<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class GestionReservas extends Component
{
    use WithPagination;

    public $perPage = 5;

    private function getReservationsByStatus()
    {
        return [
            'Reservadas' =>
            Reservation::where('user_id', Auth::id())
                ->where('status', 'Reservado')
                ->orderBy('reservation_date', 'asc')
                ->paginate($this->perPage, ['*'], 'Reservado' . 'Page'),
            'Completadas' => Reservation::where('user_id', Auth::id())
                ->where('status', 'Completado')
                ->orderBy('reservation_date', 'asc')
                ->paginate($this->perPage, ['*'], 'Completado' . 'Page'),
            'Canceladas' => Reservation::where('user_id', Auth::id())
                ->where('status', 'Cancelado')
                ->orderBy('reservation_date', 'asc')
                ->paginate($this->perPage, ['*'], 'Cancelado' . 'Page')
        ];
    }

    public function render()
    {
        return view('livewire.gestion-reservas', [
            'reservationsGroups' => self::getReservationsByStatus()
        ]);
    }

    public function cancelar($reservationId)
    {
        $this->dispatch('cancel-reserve', ['reservationId' => $reservationId]);
    }

    public function cancelarReserva($reservationId)
    {
        $reservation = Reservation::find($reservationId[0]['reservationId']);

        if ($reservation && $reservation->user_id === Auth::id()) {
            $reservation->update(['status' => 'Cancelado']);
        }
    }
}
