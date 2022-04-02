<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-3" :errors="$errors" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-3">
                    <x-label for="email" :value="__('Eposta')" />

                    <x-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-label for="password" :value="__('Şifre')" />

                    <x-input id="password" type="password" name="password" required />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <x-label for="password_confirmation" :value="__('Şifreyi Onayla')" />

                    <x-input id="password_confirmation" type="password"
                                        name="password_confirmation" required />
                </div>

                <div class="mb-0">
                    <div class="d-flex justify-content-end">
                        <x-button>
                            {{ __('Şifreyi Yenile') }}
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
