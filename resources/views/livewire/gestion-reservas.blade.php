<div>
    <div class="container">
        <h1 class="title">Gestión de Reservas</h1>

        @forelse ($reservationsGroups as $status => $group)
            <h2 class="status-heading">{{ $status }}</h2>
            @if ($group->isEmpty())
                <p class="no-reservations">No hay reservas en esta categoría.</p>
            @else
                <div class="reservation-list">
                    @foreach ($group as $reservation)
                        <div class="reservation-card">
                            <div class="reservation-info">
                                <h3 class="reservation-title">Horario: {{ $reservation->schedule->day_of_week }} - {{ $reservation->schedule->start_time->format('H:i') }} a {{ $reservation->schedule->end_time->format('H:i') }}</h3>
                                <p class="reservation-date">📅 {{ $reservation->reservation_date->format('d/m/Y') }}</p>
                                <p class="reservation-status">Estado:
                                    <span
                                        class="{{ $reservation->status === 'Reservado' ? 'status-active' : ($reservation->status === 'Cancelado' ? 'status-cancelled' : 'status-completed') }}">
                                        {{ $reservation->status }}
                                    </span>
                                </p>
                            </div>
                            @if ($reservation->status === 'Reservado')
                                <button wire:click="cancelar({{ $reservation->id }})" class="cancel-button">
                                    Cancelar
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Paginación de cada grupo -->
                <div class="pagination-container">
                    {{ $group->links('pagination.custom-pagination') }}
                </div>
            @endif
        @empty
            <p class="no-reservations">No tienes reservas activas.</p>
        @endforelse
    </div>

    <style>
        .pagination-container {
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .page-link {
            color: #3498db;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: #e9ecef;
            color: #2980b9;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background-color: #3498db;
            border-color: #3498db;
            color: #fff;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #333;
        }

        .status-heading {
            font-size: 20px;
            font-weight: 500;
            color: #555;
            margin-top: 20px;
            border-bottom: 2px solid #3498db;
            display: inline-block;
            padding-bottom: 5px;
        }

        .no-reservations {
            text-align: center;
            color: #888;
            font-size: 18px;
            font-style: italic;
            margin-top: 15px;
        }

        /* Lista de reservas */
        .reservation-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 15px;
        }

        .reservation-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .reservation-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .reservation-info {
            flex-grow: 1;
            margin-right: 15px;
        }

        .reservation-title {
            font-size: 18px;
            font-weight: bold;
            color: #3498db;
        }

        .reservation-date {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }

        .reservation-status {
            font-size: 14px;
            font-weight: 600;
        }

        .status-active {
            color: #28a745;
        }

        .status-cancelled {
            color: #dc3545;
        }

        .status-completed {
            color: #6c757d;
        }

        /* Botón cancelar */
        .cancel-button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .cancel-button:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }

        .cancel-button:active {
            transform: scale(1);
        }

        /* SweetAlert estilos */
        .swal-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .swal-content {
            font-size: 1.2rem;
            color: #555;
        }

        .swal-btn {
            font-size: 14px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .swal-btn-confirm {
            background-color: #3498db;
            color: #fff;
        }

        .swal-btn-cancel {
            background-color: #e74c3c;
            color: #fff;
        }

        .swal-btn:hover {
            opacity: 0.9;
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('cancel-reserve', event => {
                    Swal.fire({
                        title: '¿Estás seguro de cancelar esta reserva?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, cancelar',
                        cancelButtonText: 'No, volver',
                        customClass: {
                            title: 'swal-title',
                            content: 'swal-content',
                            confirmButton: 'swal-btn swal-btn-confirm',
                            cancelButton: 'swal-btn swal-btn-cancel'
                        },
                        buttonsStyling: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.cancelarReserva(event.detail);
                            Swal.fire({
                                title: 'Reserva cancelada',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                customClass: {
                                    title: 'swal-title',
                                    content: 'swal-content'
                                }
                            });

                            window.location.assign('/reservas'); 
                        }
                    });
                });
            });
        </script>
    @endpush
</div>
