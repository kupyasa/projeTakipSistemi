<x-app title="Raporlar">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ $yil }} {{ $donem }} Raporları
        </h2>
    </x-slot>


    @if (!$raporlar->isEmpty())
        <div class="accordion" id="accordionExample">
            @foreach ($raporlar as $rapor)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $rapor->rapor_id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $rapor->rapor_id }}" aria-expanded="true"
                            aria-controls="collapse{{ $rapor->rapor_id }}">
                            Rapor : {{ $rapor->rapor_id }}
                            {{ $rapor->rapor_sayi_turu }} {{ $rapor->ogrenci_id }} {{ $rapor->ogrenci_ad }}
                            {{ $rapor->ogrenci_soyad }}
                        </button>
                    </h2>
                    <div id="collapse{{ $rapor->rapor_id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $rapor->rapor_id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <h3>Rapor Bilgileri</h3>
                            <p><b>Rapor :</b> {{ $rapor->rapor_sayi_turu }}</p>
                            <p><b>Rapor Link :</b><a
                                    href="{{ asset('public/raporlar/') }}/{{ $rapor->rapor_dosya_yolu }}"
                                    target="_blank"> {{ $rapor->rapor_dosya_yolu }} </a> </p>
                            <p><b>Rapor Görülme Durumu :</b> {{ $rapor->rapor_gorulme_durumu }}</p>
                            <p><b>Rapor Onay Durumu :</b>
                                {{ $rapor->rapor_onay_durumu }}</p>
                            <p><b>Proje Durumu:</b> {{ $rapor->proje_durumu }}</p>
                            <p><b>Proje Yıl :</b> {{ $rapor->rapor_proje_yil }}</p>
                            <p><b>Proje Dönem :</b> {{ $rapor->rapor_proje_donem }}</p>
                            <h3>Öğrenci Bilgileri</h3>
                            <p><b>Öğrenci Ad Soyad :</b>
                                {{ $rapor->ogrenci_ad }}
                                {{ $rapor->ogrenci_soyad }}</p>
                            <p><b>Öğrenci Eposta :</b> {{ $rapor->ogrenci_email }}</p>
                            <p><b>Öğrenci Telefon Numarası :</b> {{ $rapor->ogrenci_telefon_no }}</p>
                            <p><b>Öğrenci Numarası :</b> {{ $rapor->ogrenci_id }}</p>
                            <p><b>Fakülte :</b> {{ $rapor->ogrenci_fakulte }}</p>
                            <p><b>Bölüm :</b> {{ $rapor->ogrenci_bolum }}</p>
                            <p><b>Öğrenci Sınıf :</b> {{ $rapor->ogrenci_sinif }}</p>
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
    @else
        <div class="card">
            <div class="card-body">
                <p class="text-center">Bu yıl ve dönemde rapor bulunmamaktadır.</p>
            </div>
        </div>
    @endif
</x-app>
