<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo width="82" />
            </a>
        </x-slot>

        <div class="card-body">
            <div class="mb-4 small text-muted">
                {{ __('Kayıt olduğun için teşekkürler! Başlamadn önce, epostana gönderilen linke tıklayarak epostanı onalayabilir misin? Eğer eposta gelmediyse tekrar yollayabiliriz.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    {{ __('Epostana yeni onay linki gönderildi.') }}
                </div>
            @endif

            <div class="mt-4 d-flex justify-content-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-button>
                            {{ __('Onaylama Epostasını Tekrar Gönder') }}
                        </x-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-link">
                        {{ __('Çıkış Yap') }}
                    </button>
                </form>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
