<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex justify-center items-center h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-center text-indigo-600 mb-6">Iniciar sesión</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('front.email')" />
                    <x-text-input id="email" class="block mt-1 w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('front.password')" />
                    <x-text-input id="password" class="block mt-1 w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('front.remember_me') }}</span>
                    </label>
                </div>

                <!-- Forgot Password -->
                <div class="flex justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('front.forgot_password') }}
                        </a>
                    @endif
                </div>

                <!-- Login Button (Centrado) -->
                <div class="flex justify-center mt-6">
                    <x-primary-button class="w-full py-3 text-white font-bold rounded-md bg-indigo-600 hover:bg-indigo-700 focus:outline-none flex items-center justify-center">
                        {{ __('front.login') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Register Button -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">{{ __('front.no_account') }}</p>
                <a href="{{ route('register') }}" class="inline-block mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                    {{ __('front.register') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
