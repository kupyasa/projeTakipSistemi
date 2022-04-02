<x-app title="Tezlerim">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tezlerim') }}
        </h2>
    </x-slot>

    @if ($sisteme_dahil)
        @if ($konu_onerisi_onay)
            @if ($rapor_onay)
                @if (!$tezler->isEmpty())
                    <div class="accordion" id="accordionExample">
                        @foreach ($tezler as $tez)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $tez->tez_id }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $tez->tez_id }}" aria-expanded="true"
                                        aria-controls="collapse{{ $tez->tez_id }}">
                                        Tez : {{ $tez->tez_id }}
                                        {{ $tez->tez_turu }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $tez->tez_id }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $tez->tez_id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <h3>Tez Bilgileri</h3>
                                        <p><b>Tez :</b> {{ $tez->tez_turu }}</p>
                                        <p><b>Tez Link :</b><a
                                                href="{{ asset('public/tezler/') }}/{{ $tez->tez_dosya_yolu }}"
                                                target="_blank"> {{ $tez->tez_dosya_yolu }} </a> </p>
                                        <p><b>Tez Görülme Durumu :</b> {{ $tez->tez_gorulme_durumu }}</p>
                                        <p><b>Tez Onay Durumu :</b>
                                            {{ $tez->tez_onay_durumu }}</p>
                                        <p><b>Proje Durumu:</b> {{ $tez->proje_durumu }}</p>
                                        <p><b>Proje Yıl :</b> {{ $tez->tez_proje_yil }}</p>
                                        <p><b>Proje Dönem :</b> {{ $tez->tez_proje_donem }}</p>
                                        <h3>Danışman Bilgileri</h3>
                                        <p><b>Danışman Ad Soyad :</b> {{ $tez->danisman_unvan }}
                                            {{ $tez->danisman_ad }}
                                            {{ $tez->danisman_soyad }}</p>
                                        <p><b>Danışman Eposta :</b> {{ $tez->danisman_email }}</p>
                                        <p><b>Danışman Telefon Numarası :</b> {{ $tez->danisman_telefon_no }}
                                        </p>
                                        <p><b>Fakülte :</b> {{ $tez->danisman_fakulte }}</p>
                                        <p><b>Bölüm :</b> {{ $tez->danisman_bolum }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if (!$tez_onay)
                    <div class="card my-4">
                        <div class="card-body text-end">
                            <a href="{{ route('ogrenci.tezyukleget') }}" class="btn btn-primary">Tez
                                Yükle</a>
                        </div>
                    </div>
                @endif
            @else
                <div class="card">
                    <div class="card-body">
                        <p class="text-center">Raporlarınız onaylanmamıştır.
                        </p>
                    </div>
                </div>
            @endif
        @else
            <div class="card">
                <div class="card-body">
                    <p class="text-center">Onaylanmış proje konu öneriniz bulunmamaktadır.
                    </p>
                </div>
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body">
                <p class="text-center">Sisteme dahil değilsiniz. Lütfen Sistem Yöneticisi ile iletişime geçiniz.
                </p>
            </div>
        </div>
    @endif

</x-app>
