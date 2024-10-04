<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input
                    icon="at-symbol"
                    label="Email"
                    name="email"
                    :value="old('email')"
                    placeholder="your email address"
                    required autofocus autocomplete="email"
                />
            </div>

            <div class="mt-4">
                <x-input
                    icon="lock-closed"
                    label="Password"
                    name="password"
                    type="password"
                    :value="old('password')"
                    placeholder="your password"
                    required autofocus autocomplete="password"
                />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <x-button outline :href="route('register')" label="Register" blue />

                <div>
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button type="submit" class="ms-4" blue>
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
