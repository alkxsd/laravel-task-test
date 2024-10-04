<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-input
                    icon="user"
                    label="Name"
                    name="name"
                    :value="old('name')"
                    placeholder="your name"
                    required autofocus autocomplete="name"
                />
            </div>

            <div class="mt-4">
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

            <div class="mt-4">
                <x-input
                    icon="lock-closed"
                    label="Confirm Password"
                    name="password_confirmation"
                    type="password"
                    :value="old('password_confirmation')"
                    placeholder="confirm your password"
                    required autofocus autocomplete="email"
                />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4" type="submit">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
