<x-app title="Tez Yükle">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tez Yükle') }}
        </h2>
    </x-slot>
    @if ($sisteme_dahil)
        @if (!$konu_onerisi_onay)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Onaylanan proje konu önerisi bulunmamaktadır.</p>
                </div>
            </div>
        @elseif (!$rapor_onay)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Raporlarınızın tamamı onaylanmamıştır.</p>
                </div>
            </div>
        @elseif($tez_onay)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Teziniz onaylanmış ve projeniz tamamlanmıştır.</p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Tezi yükle</h5>
                    <form action="{{ route('ogrenci.tezyuklepost') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (!$tezdoconayveyabekleme)
                            <div class="mb-3">
                                <label for="tezdoc" class="form-label">Tez DOC</label>
                                <input class="form-control" type="file" id="tezdoc" name="tezdoc"
                                    accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.obt">
                            </div>
                        @endif
                        @if (!$tezpdfonayveyabekleme)
                            <div class="mb-3">
                                <label for="tezpdf" class="form-label">Tez PDF</label>
                                <input class="form-control" type="file" id="tezpdf" name="tezpdf" accept=".pdf">
                            </div>
                        @endif

                        <div class="text-end my-4 my-2">
                            <button type="submit" class="btn btn-primary">Tezi Yükle</button>
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
