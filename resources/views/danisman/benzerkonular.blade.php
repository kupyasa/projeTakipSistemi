<x-app title="Benzer Konu Önerileri">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Benzer Konu Önerileri') }}
        </h2>
    </x-slot>
    @if ($sisteme_dahil)
        @if (!$benzer_konu_onerileri->isEmpty())
            <div class="accordion" id="accordionExample">
                @foreach ($benzer_konu_onerileri as $benzer_konu_onerisi)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $benzer_konu_onerisi->benzer_konu_id }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $benzer_konu_onerisi->benzer_konu_id }}"
                                aria-expanded="true"
                                aria-controls="collapse{{ $benzer_konu_onerisi->benzer_konu_id }}">
                                Önerilen Proje Konusu : {{ $benzer_konu_onerisi->yeni_konu_proje_baslik }}
                            </button>
                        </h2>
                        <div id="collapse{{ $benzer_konu_onerisi->benzer_konu_id }}"
                            class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $benzer_konu_onerisi->benzer_konu_id }}"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <h3>Önerilen Projenin Konu Bilgileri</h3>
                                <p><b>Proje Konu Amaç :</b> {{ $benzer_konu_onerisi->yeni_konu_proje_amac }}</p>
                                <p><b>Proje Konu Önem :</b> {{ $benzer_konu_onerisi->yeni_konu_proje_onem }}</p>
                                <p><b>Proje Konu Kapsam :</b> {{ $benzer_konu_onerisi->yeni_konu_proje_kapsam }}</p>
                                <p><b>Proje Konu Anahtar Kelimeler :</b>
                                    {{ $benzer_konu_onerisi->yeni_konu_proje_anahtar_kelimeler }}</p>
                                <p><b>Proje Konu Materyal :</b> {{ $benzer_konu_onerisi->yeni_konu_proje_materyal }}
                                </p>
                                <p><b>Proje Konu Yöntem :</b> {{ $benzer_konu_onerisi->yeni_konu_proje_yontem }}</p>
                                <p><b>Proje Konu Araştırma :</b>
                                    {{ $benzer_konu_onerisi->yeni_konu_proje_arastirma }}</p>
                                <p><b>Proje Konu Onay Durumu :</b> {{ $benzer_konu_onerisi->yeni_konu_onay_durumu }}
                                </p>
                                <p><b>Proje Konu Red Nedeni :</b> {{ $benzer_konu_onerisi->yeni_konu_red_nedeni }}
                                </p>
                                <p><b>Proje Durumu:</b> {{ $benzer_konu_onerisi->yeni_konu_proje_durumu }}</p>
                                <p><b>Proje Konu Yıl :</b> {{ $benzer_konu_onerisi->yeni_konu_proje_yil }}</p>
                                <p><b>Proje Konu Dönem :</b> {{ $benzer_konu_onerisi->yeni_konu_proje_donem }}</p>

                                <h3>Benzer Projenin Konu Bilgileri</h3>
                                <p><b>Proje Konu Başlık :</b> {{ $benzer_konu_onerisi->eski_konu_proje_baslik }}</p>
                                <p><b>Proje Konu Amaç :</b> {{ $benzer_konu_onerisi->eski_konu_proje_amac }}</p>
                                <p><b>Proje Konu Önem :</b> {{ $benzer_konu_onerisi->eski_konu_proje_onem }}</p>
                                <p><b>Proje Konu Kapsam :</b> {{ $benzer_konu_onerisi->eski_konu_proje_kapsam }}</p>
                                <p><b>Proje Konu Anahtar Kelimeler :</b>
                                    {{ $benzer_konu_onerisi->eski_konu_proje_anahtar_kelimeler }}</p>
                                <p><b>Proje Konu Materyal :</b> {{ $benzer_konu_onerisi->eski_konu_proje_materyal }}
                                </p>
                                <p><b>Proje Konu Yöntem :</b> {{ $benzer_konu_onerisi->eski_konu_proje_yontem }}</p>
                                <p><b>Proje Konu Araştırma :</b>
                                    {{ $benzer_konu_onerisi->eski_konu_proje_arastirma }}</p>
                                <p><b>Proje Konu Onay Durumu :</b> {{ $benzer_konu_onerisi->eski_konu_onay_durumu }}
                                </p>
                                <p><b>Proje Konu Red Nedeni :</b> {{ $benzer_konu_onerisi->eski_konu_red_nedeni }}
                                </p>
                                <p><b>Proje Durumu:</b> {{ $benzer_konu_onerisi->eski_konu_proje_durumu }}</p>
                                <p><b>Proje Konu Yıl :</b> {{ $benzer_konu_onerisi->eski_konu_proje_yil }}</p>
                                <p><b>Proje Konu Dönem :</b> {{ $benzer_konu_onerisi->eski_konu_proje_donem }}</p>

                                <h3>Daha Önce Konuyu Önermiş Öğrencinin Bilgileri</h3>
                                <p><b>Öğrenci Ad Soyad :</b>
                                    {{ $benzer_konu_onerisi->ogrenci_ad }}
                                    {{ $benzer_konu_onerisi->ogrenci_soyad }}</p>
                                <p><b>Öğrenci Eposta :</b> {{ $benzer_konu_onerisi->ogrenci_email }}</p>
                                <p><b>Öğrenci Telefon Numarası :</b> {{ $benzer_konu_onerisi->ogrenci_telefon_no }}</p>
                                <p><b>Öğrenci Numarası :</b> {{ $benzer_konu_onerisi->ogrenci_no }}</p>
                                <p><b>Fakülte :</b> {{ $benzer_konu_onerisi->ogrenci_fakulte }}</p>
                                <p><b>Bölüm :</b> {{ $benzer_konu_onerisi->ogrenci_bolum }}</p>
                                <p><b>Öğrenci Sınıf :</b> {{ $benzer_konu_onerisi->ogrenci_sinif }}</p>
                                
                                <h3>Benzer Projenin Danışmanının Bilgileri</h3>
                                <p><b>Danışman Ad Soyad :</b> {{ $benzer_konu_onerisi->danisman_unvan }}
                                    {{ $benzer_konu_onerisi->danisman_ad }}
                                    {{ $benzer_konu_onerisi->danisman_soyad }}</p>
                                <p><b>Danışman Eposta :</b> {{ $benzer_konu_onerisi->danisman_email }}</p>
                                <p><b>Danışman Telefon Numarası :</b> {{ $benzer_konu_onerisi->danisman_telefon_no }}
                                </p>
                                <p><b>Fakülte :</b> {{ $benzer_konu_onerisi->danisman_fakulte }}</p>
                                <p><b>Bölüm :</b> {{ $benzer_konu_onerisi->danisman_bolum }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <p class="text-center">Aktif yıl ve dönemde benzer konu önerisi yapan öğrenciniz yok.</p>
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