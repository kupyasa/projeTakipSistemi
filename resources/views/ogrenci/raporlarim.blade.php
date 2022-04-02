<x-app title="Raporlarım">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Raporlarım') }}
        </h2>
    </x-slot>

    @if ($sisteme_dahil)
        @if ($konu_onerisi_onay)
            @if (!$raporlar->isEmpty())
                <div class="accordion" id="accordionExample">
                    @foreach ($raporlar as $rapor)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $rapor->rapor_id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $rapor->rapor_id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $rapor->rapor_id }}">
                                    Rapor : {{ $rapor->rapor_id }}
                                    {{ $rapor->rapor_sayi_turu }}
                                </button>
                            </h2>
                            <div id="collapse{{ $rapor->rapor_id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $rapor->rapor_id }}"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <h3>Rapor Bilgileri</h3>
                                    <p><b>Rapor :</b> {{ $rapor->rapor_sayi_turu }}</p>
                                    <p><b>Rapor Link :</b><a href="{{asset('public/raporlar/')}}/{{ $rapor->rapor_dosya_yolu }}" target="_blank"> {{ $rapor->rapor_dosya_yolu }} </a> </p>
                                    <p><b>Rapor Görülme Durumu :</b> {{ $rapor->rapor_gorulme_durumu }}</p>
                                    <p><b>Rapor Onay Durumu :</b>
                                        {{ $rapor->rapor_onay_durumu }}</p>
                                    <p><b>Proje Durumu:</b> {{ $rapor->proje_durumu}}</p>
                                    <p><b>Proje Yıl :</b> {{ $rapor->rapor_proje_yil}}</p>
                                    <p><b>Proje Dönem :</b> {{ $rapor->rapor_proje_donem}}</p>
                                    <h3>Danışman Bilgileri</h3>
                                    <p><b>Danışman Ad Soyad :</b> {{ $rapor->danisman_unvan }}
                                        {{ $rapor->danisman_ad }}
                                        {{ $rapor->danisman_soyad }}</p>
                                    <p><b>Danışman Eposta :</b> {{ $rapor->danisman_email }}</p>
                                    <p><b>Danışman Telefon Numarası :</b> {{ $rapor->danisman_telefon_no }}
                                    </p>
                                    <p><b>Fakülte :</b> {{ $rapor->danisman_fakulte }}</p>
                                    <p><b>Bölüm :</b> {{ $rapor->danisman_bolum }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (!$rapor_onay)
                <div class="card my-4">
                    <div class="card-body text-end">
                        <a href="{{ route('ogrenci.raporlariyukleget') }}" class="btn btn-primary">Raporları Yükle</a>
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
