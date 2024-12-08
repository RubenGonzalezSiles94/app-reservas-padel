<div style="display: flex; justify-content: center;">
    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary font-weight-bold">Reservar Pista de Pádel</h2>
        @if ($canReserve)
            <div class="row justify-content-center" style="display: flex; justify-content: center; position: relative;">
                <div class="col-md-6 col-sm-8 col-10">
                    <input type="text" id="datepicker" class="form-control form-control-lg" wire:model="selectedDate"
                        placeholder="Selecciona una fecha" />
                </div>
            </div>


            @if ($selectedDate)
                <div class="mt-4 text-center">
                    <p class="h5 text-secondary"><strong>Fecha seleccionada:</strong> {{ $selectedDate }}</p>
                    <p class="h5 text-secondary"><strong>Día de la semana:</strong>
                        {{ Carbon\Carbon::parse($selectedDate)->locale('es')->dayName }}</p>
                    <p class="h4 font-weight-bold text-primary" style="margin-top: 2%">Horarios disponibles:</p>

                    @if ($availableSchedules->isEmpty())
                        <div class="alert alert-warning" role="alert" style="margin-top: 2%">
                            No hay horarios disponibles para este día.
                        </div>
                    @else
                        <div class="d-flex flex-wrap justify-content-center" style="margin-top: 1%">
                            @foreach ($availableSchedules as $schedule)
                                <button class="btn btn-schedule mx-2 mb-3"
                                    wire:click="confirmReserve({{ $schedule->id }})"
                                    style="margin-top: 1%; margin-right: 1%">
                                    <strong>{{ $schedule->start_time->format('H:i') }} -
                                        {{ $schedule->end_time->format('H:i') }}</strong>
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        @else
            <div class="alert alert-danger text-center no-reservas" role="alert" style="margin-top: 2%">
                Has alcanzado el límite de reservas activas.
            </div>
        @endif
    </div>

    <style>
        .flatpickr-calendar {
            position: absolute !important;
            top: 420% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            z-index: 99999 !important;
            background: #fff !important;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2) !important;
        }

        .container {
            min-height: 600px;
            position: relative;
            overflow: visible;
        }

        .flatpickr-calendar.open {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
        }


        h2 {
            font-size: 2.5rem;
            color: #2c3e50;
        }

        .btn-schedule {
            background-color: #3498db;
            border: none;
            color: white;
            font-size: 1.1rem;
            padding: 12px 25px;
            border-radius: 30px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-schedule:hover {
            background-color: #2980b9;
            transform: translateY(-3px);
        }

        .btn-schedule:active {
            transform: translateY(0);
        }

        .btn-schedule:focus {
            outline: none;
        }

        .alert-warning {
            background-color: #f9e0a4;
            color: #d1a100;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 15px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            font-size: 1.1rem;
            font-weight: bold;
        }

        #datepicker {
            font-size: 1.2rem;
            padding: 10px;
            border-radius: 10px;
            border: 2px solid #ced4da;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #datepicker:focus {
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        @media (max-width: 768px) {
            .flatpickr-calendar {
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                z-index: 99999 !important;
            }

            .flatpickr-day {
                height: 40px !important;
                line-height: 40px !important;
                margin: 2px !important;
            }

            #datepicker {
                font-size: 16px !important;
                height: 44px !important;
                cursor: pointer !important;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }

            /* Estilos específicos para iOS */
            @supports (-webkit-touch-callout: none) {
                .flatpickr-calendar {
                    background: #fff !important;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2) !important;
                }

                .flatpickr-day.selected {
                    background: #3498db !important;
                    border-color: #3498db !important;
                }
            }

            .container {
                padding: 20px;
            }

            h2 {
                font-size: 2rem;
            }

            .btn-schedule {
                font-size: 1rem;
                padding: 10px 20px;
            }
        }

        .text-secondary {
            font-size: 1.2rem;
            color: #7f8c8d;
        }

        .font-weight-bold {
            font-weight: 600;
        }

        body {
            background-color: #ecf0f1;
        }

        .swal-title {
            font-size: 1.8rem;
            color: #2c3e50;
            font-weight: bold;
        }

        .swal-content {
            font-size: 1.2rem;
            color: #7f8c8d;
        }

        .swal-btn {
            background-color: #3498db;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 30px;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .swal-btn-confirm {
            background-color: #3498db;
        }

        .swal-btn-cancel {
            background-color: #e74c3c;
        }

        .swal-btn:hover {
            background-color: #2980b9;

            transform: translateY(-3px);
        }

        .swal-btn:active {
            transform: translateY(0);
        }

        .swal-btn:focus {
            outline: none;
        }

        /* movimiento limite reservas */
        .no-reservas {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #ff0000;
            animation: shake 1.2s infinite;
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-20px);
            }

            40% {
                transform: translateX(20px);
            }

            60% {
                transform: translateX(-20px);
            }

            80% {
                transform: translateX(20px);
            }

            100% {
                transform: translateX(0);
            }
        }
    </style>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/es.js"></script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let fpInstance;

                function initializeDatepicker() {
                    if (fpInstance) {
                        fpInstance.destroy();
                    }
                    const maxDays = @json($maxDaysAvailable);
                    fpInstance = flatpickr("#datepicker", {
                        minDate: "today",
                        maxDate: maxDays > 0 ? new Date().fp_incr(maxDays) : null,
                        locale: "es",
                        dateFormat: "d-m-Y",
                        disableMobile: "true",
                        allowInput: false,
                        static: true,
                        onChange: function(selectedDates, dateStr, instance) {
                            @this.call('updateTimeReserve', dateStr);
                        }
                    });

                    const dateInput = document.querySelector("#datepicker");

                    dateInput.addEventListener('click', function(e) {
                        e.preventDefault();
                        fpInstance.open();
                    });

                    dateInput.addEventListener('keydown', function(e) {
                        e.preventDefault();
                    });
                }

                initializeDatepicker();

                window.Livewire.on('contentChanged', () => {
                    setTimeout(initializeDatepicker, 100);
                });

                window.addEventListener('confirm-reserve', event => {
                    Swal.fire({
                        title: '¿Estás seguro de reservar a esta hora?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Reservar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            title: 'swal-title',
                            content: 'swal-content',
                            confirmButton: 'swal-btn swal-btn-confirm',
                            cancelButton: 'swal-btn swal-btn-cancel'
                        },
                        buttonsStyling: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.reserveSlot(event.detail);
                            Swal.fire({
                                title: 'Reserva realizada con éxito!',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                customClass: {
                                    title: 'swal-title',
                                    content: 'swal-content',
                                    confirmButton: 'swal-btn swal-btn-confirm'
                                }
                            }).then(() => {
                                setTimeout(() => {
                                    initializeDatepicker();
                                }, 500);
                            });
                        }
                        initializeDatepicker();
                    });

                });
            });
        </script>
    @endpush
</div>
