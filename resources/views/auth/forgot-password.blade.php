<x-guest-layout>
    <head>
        <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}" />
    </head>
    <div class="container">
        <x-authentication-card>
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <p class="big-heading">{{ __('Lupa password?') }}</p>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Kirimkan email kamu yang terdaftar, kami akan mengirimkan link reset password ke email Anda. No problem.') }}
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="text-fields">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button class="login-btn">
                        {{ __('Kirim Email') }}
                    </x-button>
                </div>
            </form>
        </x-authentication-card>
    </div>
</x-guest-layout>