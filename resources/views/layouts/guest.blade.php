<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-image {
            background-image: url('{{ asset('public/img/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .bg-image::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.8);
            z-index: 1;
        }

        .content-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 0 1rem;
        }

        @media (min-width: 640px) {
            .content-wrapper {
                padding: 0 2rem;
            }
        }

        @media (min-width: 1024px) {
            .content-wrapper {
                padding: 0 4rem;
            }
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-image px-4 sm:px-6 md:px-8 lg:px-12">
        <div class="content-wrapper flex flex-col items-center">
            <div>
                <a href="/">
                    {{-- <img src="{{ asset('logos/logo.webp') }}" alt="Application Logo" class="w-40 h-40"> --}}
                </a>
            </div>
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
            <!-- Box más grande con padding lateral responsivo -->
            <div class="w-full sm:max-w-xl md:max-w-2xl lg:max-w-4xl xl:max-w-6xl mt-6 px-8 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg mx-4 sm:mx-6 md:mx-8 lg:mx-12" style="padding: 2rem !important">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
