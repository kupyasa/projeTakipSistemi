<x-app title="Tezi Düzenle">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tezi Düzenle') }}
        </h2>
    </x-slot>
    @if ($tez != null)

        @if (!$tez_onay_bekleme)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Bu tez onaylanmış veya reddedilmiştir. Bu tez üzerinde daha fazla değişiklik
                        yapılamaz.
                    </p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Tezi düzenle</h5>
                    <form action="{{ route('danisman.tezduzenlepost') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tez_id" value="{{ $tez->id }}">
                        <input type="hidden" name="ogrenci_id" value="{{ $tez->ogrenci_id }}">
                        <div class="mb-3">
                            <label for="tez_onay_durumu" class="form-label">Tez Onay Durumu</label>
                            <select class="form-select" name="tez_onay_durumu" id="tez_onay_durumu" required>
                                <option value="Onaylandı">Onayla</option>
                                <option value="Reddedildi">Reddet</option>
                            </select>
                        </div>

                        <div class="text-end my-4 my-2">
                            <button type="submit" class="btn btn-primary">Tezi Düzenle</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body">
                <p class="text-center">Sisteme dahil değilsiniz veya danışmanı olmadığınız bir öğrencinin
                    tezi üzerinde değişiklik yapmaya çalışıyorsunuz. Lütfen Sistem Yöneticisi ile iletişime geçiniz.
                </p>
            </div>
        </div>
    @endif

</x-app>
