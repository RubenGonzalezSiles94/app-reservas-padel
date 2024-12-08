<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- First name -->
        <div>
            <x-input-label for="first_name" :value="__('front.first_name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last name -->
        <div>
            <x-input-label for="last_name" :value="__('front.last_name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('front.email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- CIF -->
        <div>
            <x-input-label for="cif" :value="__('front.dni').' / '.__('front.cif')" />
            <x-text-input id="cif" class="block mt-1 w-full" type="text" name="cif" :value="old('cif')" required autocomplete="cif" />
            <x-input-error :messages="$errors->get('cif')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('front.password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('front.confirm_password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register and Login Link -->
        <div class="flex flex-col justify-center items-center mt-6 space-y-4">
            <a class="inline-block mt-2 text-indigo-600 hover:text-indigo-800 text-sm font-semibold"
                href="{{ route('login') }}">
                {{ __('front.already_registered') }}
            </a>

            <div class="w-full">
                <x-primary-button class="w-full mt-2 py-3 text-white font-bold rounded-md bg-indigo-600 hover:bg-indigo-700 focus:outline-none flex items-center justify-center">
                    {{ __('front.register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
