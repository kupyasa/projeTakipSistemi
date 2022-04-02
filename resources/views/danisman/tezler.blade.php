<x-app title="Tezler">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Danışmanı Olduğum Öğrencilerin Tezleri') }}
        </h2>
    </x-slot>

    @if ($sisteme_dahil)
        @if (!$tezler->isEmpty())
            <div class="accordion" id="accordionExample">
                @foreach ($tezler as $tez)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $tez->tez_id }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $tez->tez_id }}" aria-expanded="true"
                                aria-controls="collapse{{ $tez->tez_id }}">
                                Tez : {{ $tez->tez_id }}
                                {{ $tez->tez_turu }} {{ $tez->ogrenci_id }} {{ $tez->ogrenci_ad }}
                                {{ $tez->ogrenci_soyad }}
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
                                <h3>Öğrenci Bilgileri</h3>
                                <p><b>Öğrenci Ad Soyad :</b>
                                    {{ $tez->ogrenci_ad }}
                                    {{ $tez->ogrenci_soyad }}</p>
                                <p><b>Öğrenci Eposta :</b> {{ $tez->ogrenci_email }}</p>
                                <p><b>Öğrenci Telefon Numarası :</b> {{ $tez->ogrenci_telefon_no }}</p>
                                <p><b>Öğrenci Numarası :</b> {{ $tez->ogrenci_id }}</p>
                                <p><b>Fakülte :</b> {{ $tez->ogrenci_fakulte }}</p>
                                <p><b>Bölüm :</b> {{ $tez->ogrenci_bolum }}</p>
                                <p><b>Öğrenci Sınıf :</b> {{ $tez->ogrenci_sinif }}</p>
                                <div class="text-end">
                                    <a href="{{ route('danisman.tezduzenleget', ['tez_id' => $tez->tez_id]) }}"
                                        class="btn btn-primary text-end">Tez Onayı</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <p class="text-center">Herhangi bir öğrenci tez teslim etmemiştir.
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