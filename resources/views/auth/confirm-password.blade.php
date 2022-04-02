<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <div class="mb-4 text-sm text-muted">
                {{ __('Devam etmeden önce şifreni onayla.') }}
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-3">
                <x-label for="password" :value="__('Şifre')" />

                <x-input id="password" type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="d-flex justify-content-end mt-4">
                <x-button class="ms-4">
                    {{ __('Onayla') }}
                </x-button>
            </div>
        </form>
        </div>
    </x-auth-card>
</x-guest-layout>
