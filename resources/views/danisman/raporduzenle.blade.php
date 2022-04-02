<x-app title="Raporu Düzenle">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Raporu Düzenle') }}
        </h2>
    </x-slot>
    @if ($rapor != null)

        @if (!$rapor_onay_bekleme)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Bu rapor onaylanmış veya reddedilmiştir. Bu rapor üzerinde daha fazla değişiklik
                        yapılamaz.
                    </p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Raporu düzenle</h5>
                    <form action="{{ route('danisman.raporduzenlepost') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="rapor_id" value="{{ $rapor->id }}">

                        <div class="mb-3">
                            <label for="rapor_onay_durumu" class="form-label">Rapor Onay Durumu</label>
                            <select class="form-select" name="rapor_onay_durumu" id="rapor_onay_durumu" required>
                                <option value="Onaylandı">Onayla</option>
                                <option value="Reddedildi">Reddet</option>
                            </select>
                        </div>

                        <div class="text-end my-4 my-2">
                            <button type="submit" class="btn btn-primary">Raporu Düzenle</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body">
                <p class="text-center">Sisteme dahil değilsiniz veya danışmanı olmadığınız bir öğrencinin
                    raporu üzerinde değişiklik yapmaya çalışıyorsunuz. Lütfen Sistem Yöneticisi ile iletişime geçiniz.
                </p>
            </div>
        </div>
    @endif

</x-app>
