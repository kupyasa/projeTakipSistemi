<x-app title="Konu Önerilerim">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Konu Önerilerim') }}
        </h2>
    </x-slot>


    @if (!$konu_onerileri->isEmpty())
        <div class="accordion" id="accordionExample">
            @foreach ($konu_onerileri as $konu_onerisi)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $konu_onerisi->konu_id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $konu_onerisi->konu_id }}" aria-expanded="true"
                            aria-controls="collapse{{ $konu_onerisi->konu_id }}">
                            Proje Konusu : {{ $konu_onerisi->konu_id }} {{ $konu_onerisi->konu_proje_baslik }}
                        </button>
                    </h2>
                    <div id="collapse{{ $konu_onerisi->konu_id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $konu_onerisi->konu_id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h3>Proje Konu Bilgileri</h3>
                            <p><b>Proje Konu Amaç :</b> {{ $konu_onerisi->konu_proje_amac }}</p>
                            <p><b>Proje Konu Önem :</b> {{ $konu_onerisi->konu_proje_onem }}</p>
                            <p><b>Proje Konu Kapsam :</b> {{ $konu_onerisi->konu_proje_kapsam }}</p>
                            <p><b>Proje Konu Anahtar Kelimeler :</b>
                                {{ $konu_onerisi->konu_proje_anahtar_kelimeler }}</p>
                            <p><b>Proje Konu Materyal :</b> {{ $konu_onerisi->konu_proje_materyal }}</p>
                            <p><b>Proje Konu Yöntem :</b> {{ $konu_onerisi->konu_proje_yontem }}</p>
                            <p><b>Proje Konu Araştırma :</b> {{ $konu_onerisi->konu_proje_arastirma }}</p>
                            <p><b>Proje Konu Onay Durumu :</b> {{ $konu_onerisi->konu_onay_durumu }}</p>
                            <p><b>Proje Konu Red Nedeni :</b> {{ $konu_onerisi->konu_red_nedeni }}</p>
                            <p><b>Proje Durumu:</b> {{ $konu_onerisi->proje_durumu }}</p>
                            <p><b>Proje Konu Yıl :</b> {{ $konu_onerisi->konu_proje_yil }}</p>
                            <p><b>Proje Konu Dönem :</b> {{ $konu_onerisi->konu_proje_donem }}</p>
                            <h3>Danışman Bilgileri</h3>
                            <p><b>Danışman Ad Soyad :</b> {{ $konu_onerisi->danisman_unvan }}
                                {{ $konu_onerisi->danisman_ad }}
                                {{ $konu_onerisi->danisman_soyad }}</p>
                            <p><b>Danışman Eposta :</b> {{ $konu_onerisi->danisman_email }}</p>
                            <p><b>Danışman Telefon Numarası :</b> {{ $konu_onerisi->danisman_telefon_no }}</p>
                            <p><b>Fakülte :</b> {{ $konu_onerisi->danisman_fakulte }}</p>
                            <p><b>Bölüm :</b> {{ $konu_onerisi->danisman_bolum }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if (!$konu_onerisi_onay)
            <div class="card my-4">
                <div class="card-body text-end">
                    <a href="{{ route('ogrenci.konuonerisiyapget') }}" class="btn btn-primary">Konu Önerisi Yap</a>
                </div>
            </div>
        @else
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Konu öneriniz onaylanmıştır.</p>
                </div>
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body">
                <p class="text-center">Sisteme dahil değilsiniz. Lütfen Sistem Yöneticisi ile iletişime geçiniz.</p>
            </div>
        </div>

    @endif
</x-app>
