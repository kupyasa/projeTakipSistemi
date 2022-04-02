<x-app title="Raporları Yükle">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Raporları Yükle') }}
        </h2>
    </x-slot>
    @if ($sisteme_dahil)
        @if (!$konu_onerisi_onay)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Onaylanan proje konu önerisi bulunmamaktadır.</p>
                </div>
            </div>
        @elseif ($rapor_onay)
            <div class="card my-4">
                <div class="card-body text-center">
                    <p>Bütün raporlarınız onaylanmıştır.</p>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Raporları yükle</h5>
                    <form action="{{ route('ogrenci.raporlariyuklepost') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if (!$rapor1doconayveyabekleme)
                            <div class="mb-3">
                                <label for="rapor1doc" class="form-label">Rapor 1 DOC</label>
                                <input class="form-control" type="file" id="rapor1doc" name="rapor1doc"
                                    accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.obt">
                            </div>
                        @endif
                        @if (!$rapor1pdfonayveyabekleme)
                            <div class="mb-3">
                                <label for="rapor1pdf" class="form-label">Rapor 1 PDF</label>
                                <input class="form-control" type="file" id="rapor1pdf" name="rapor1pdf" accept=".pdf">
                            </div>
                        @endif
                        @if (!$rapor2doconayveyabekleme)
                            <div class="mb-3">
                                <label for="rapor2doc" class="form-label">Rapor 2 DOC</label>
                                <input class="form-control" type="file" id="rapor2doc" name="rapor2doc"
                                    accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.obt">
                            </div>
                        @endif
                        @if (!$rapor2pdfonayveyabekleme)
                            <div class="mb-3">
                                <label for="rapor2pdf" class="form-label">Rapor 2 PDF</label>
                                <input class="form-control" type="file" id="rapor2pdf" name="rapor2pdf" accept=".pdf">
                            </div>
                        @endif
                        @if (!$rapor3doconayveyabekleme)
                            <div class="mb-3">
                                <label for="rapor3doc" class="form-label">Rapor 3 DOC</label>
                                <input class="form-control" type="file" id="rapor3doc" name="rapor3doc"
                                    accept=".doc,.docx,.xml,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.obt">
                            </div>
                        @endif
                        @if (!$rapor3pdfonayveyabekleme)
                            <div class="mb-3">
                                <label for="rapor3pdf" class="form-label">Rapor 3 PDF</label>
                                <input class="form-control" type="file" id="rapor3pdf" name="rapor3pdf" accept=".pdf">
                            </div>
                        @endif

                        <div class="text-end my-4 my-2">
                            <button type="submit" class="btn btn-primary">Raporları Yükle</button>
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
