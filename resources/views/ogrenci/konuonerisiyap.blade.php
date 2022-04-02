<x-app title="Konu Önerisi Yap">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Konu Önerisi Yap') }}
        </h2>
    </x-slot>
    @if ($sisteme_dahil)
        @if ($konu_onerisi_onay)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Konu öneriniz onaylanmıştır.</p>
                </div>
            </div>
        @elseif ($konu_onerisi_bekleme)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Beklemede bulunan bir öneriniz bulunmaktadır. Lütfen danışmanınızın geri bildirimini bekleyin.
                    </p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Konu önerisi yap</h5>
                    <form action="{{ route('ogrenci.konuonerisiyappost') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="proje_baslik" class="form-label">Proje Konu Başlık</label>
                            <input type="text" class="form-control" id="proje_baslik" name="proje_baslik" required>
                        </div>
                        <div class="mb-3">
                            <label for="proje_amac" class="form-label">Proje Konu Amaç</label>
                            <textarea class="form-control" id="proje_amac" name="proje_amac" rows="3" style="resize:vertical" minlength="200"
                                required></textarea>
                        </div>
                        <div class=" mb-3">
                            <label for="proje_onem" class="form-label">Proje Konu Önem</label>
                            <textarea class="form-control" id="proje_onem" name="proje_onem" rows="3" style="resize:vertical" minlength="200"
                                required></textarea>
                        </div>
                        <div class=" mb-3">
                            <label for="proje_kapsam" class="form-label">Proje Konu Kapsam</label>
                            <textarea class="form-control" id="proje_kapsam" name="proje_kapsam" rows="3" style="resize:vertical" minlength="200"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="anahtar_kelime1" class="form-label">Anahtar Kelime 1</label>
                            <input type="text" class="form-control" id="anahtar_kelime1" name="anahtar_kelime1"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="anahtar_kelime2" class="form-label">Anahtar Kelime 2</label>
                            <input type="text" class="form-control" id="anahtar_kelime2" name="anahtar_kelime2"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="anahtar_kelime3" class="form-label">Anahtar Kelime 3</label>
                            <input type="text" class="form-control" id="anahtar_kelime3" name="anahtar_kelime3"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="anahtar_kelime4" class="form-label">Anahtar Kelime 4</label>
                            <input type="text" class="form-control" id="anahtar_kelime4" name="anahtar_kelime4"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="anahtar_kelime5" class="form-label">Anahtar Kelime 5</label>
                            <input type="text" class="form-control" id="anahtar_kelime5" name="anahtar_kelime5"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="proje_materyal" class="form-label">Proje Konu Materyal</label>
                            <textarea class="form-control" id="proje_materyal" name="proje_materyal" rows="3" style="resize:vertical"
                                minlength="300" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proje_yontem" class="form-label">Proje Konu Yöntem</label>
                            <textarea class="form-control" id="proje_yontem" name="proje_yontem" rows="3" style="resize:vertical" minlength="300"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="proje_arastirma" class="form-label">Proje Konu Araştırma</label>
                            <textarea class="form-control" id="proje_arastirma" name="proje_arastirma" rows="3" style="resize:vertical"
                                minlength="300" required></textarea>
                        </div>

                        <div class="text-end my-4 my-2">
                            <button type="submit" class="btn btn-primary">Konu Önerisi Yap</button>
                        </div>
                    </form>
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
