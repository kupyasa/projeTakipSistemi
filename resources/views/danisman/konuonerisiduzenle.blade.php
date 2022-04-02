<x-app title="Konu Önerisi Düzenle">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Konu Önerisi Düzenle') }}
        </h2>
    </x-slot>
    @if ($konu_onerisi != null)

        @if (!$konu_onerisi_bekleme)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Bu proje konu önerisi onaylanmış veya reddedilmiştir. Bu öneri üzerinde daha fazla değişiklik
                        yapılamaz.
                    </p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Konu önerisi düzenle</h5>
                    <form action="{{ route('danisman.konuonerisiduzenlepost') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="oneri_id" value="{{ $konu_onerisi->id }}">
                        <div class="mb-3">
                            <label for="proje_baslik" class="form-label">Proje Konu Başlık</label>
                            <input readonly type="text" class="form-control" id="proje_baslik" name="proje_baslik"
                                value="{{ $konu_onerisi->proje_baslik }}">
                        </div>
                        <div class="mb-3">
                            <label for="proje_amac" class="form-label">Proje Konu Amaç</label>
                            <textarea readonly class="form-control" id="proje_amac" name="proje_amac" rows="3" style="resize:vertical"
                                minlength="200">{{ $konu_onerisi->proje_amac }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proje_onem" class="form-label">Proje Konu Önem</label>
                            <textarea readonly class="form-control" id="proje_onem" name="proje_onem" rows="3" style="resize:vertical"
                                minlength="200">{{ $konu_onerisi->proje_onem }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proje_kapsam" class="form-label">Proje Konu Kapsam</label>
                            <textarea readonly class="form-control" id="proje_kapsam" name="proje_kapsam" rows="3" style="resize:vertical"
                                minlength="200">{{ $konu_onerisi->proje_kapsam }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="anahtar_kelimeler" class="form-label">Anahtar Kelime 1</label>
                            <input readonly type="text" class="form-control" id="anahtar_kelimeler"
                                name="anahtar_kelimeler" value="{{ $konu_onerisi->proje_anahtar_kelimeler }}">
                        </div>

                        <div class="mb-3">
                            <label for="proje_materyal" class="form-label">Proje Konu Materyal</label>
                            <textarea readonly class="form-control" id="proje_materyal" name="proje_materyal" rows="3" style="resize:vertical"
                                minlength="300">{{ $konu_onerisi->proje_materyal }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proje_yontem" class="form-label">Proje Konu Yöntem</label>
                            <textarea readonly class="form-control" id="proje_yontem" name="proje_yontem" rows="3" style="resize:vertical"
                                minlength="300">{{ $konu_onerisi->proje_yontem }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proje_arastirma" class="form-label">Proje Konu Araştırma</label>
                            <textarea readonly class="form-control" id="proje_arastirma" name="proje_arastirma" rows="3" style="resize:vertical"
                                minlength="300">{{ $konu_onerisi->proje_arastirma }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="konu_onay_durumu" class="form-label">Proje Konusu Onay Durumu</label>
                            <select class="form-select" name="konu_onay_durumu" id="konu_onay_durumu" required>
                                <option value="Onaylandı">Onayla</option>
                                <option value="Reddedildi">Reddet</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="red_nedeni" class="form-label">Konu Red Nedeni</label>
                            <textarea class="form-control" id="red_nedeni" name="red_nedeni" rows="3" style="resize:vertical"></textarea>
                        </div>
                        <div class="text-end my-4 my-2">
                            <button type="submit" class="btn btn-primary">Konu Önerisi Düzenle</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body">
                <p class="text-center">Sisteme dahil değilsiniz veya danışmanı olmadığınız bir öğrencinin proje
                    konusu üzerinde değişiklik yapmaya çalışıyorsunuz. Lütfen Sistem Yöneticisi ile iletişime geçiniz.
                </p>
            </div>
        </div>
    @endif

</x-app>
