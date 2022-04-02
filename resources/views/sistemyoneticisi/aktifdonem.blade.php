<x-app title="Aktif Dönem">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Aktif Dönemi Belirle') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Aktif dönemi değiştir</h5>
            @if (aktif_donem != null)
                <h6><b>Aktif dönem : {{ $aktif_donem->yil }} {{ $aktif_donem->donem }}</b></h6>
            @endif

            <form action="{{ route('sistemyoneticisi.aktifdonempost') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="yil" class="form-label">Aktif yıl</label>
                    <select class="form-select" name="yil" id="yil" required>
                        @for ($i = 2020; $i < 2050; $i++)
                            <option value="{{ $i }}-{{ $i + 1 }}">
                                {{ $i }}-{{ $i + 1 }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label for="donem" class="form-label">Aktif dönem</label>
                    <select class="form-select" name="donem" id="donem" required>
                        <option value="Güz">Güz</option>
                        <option value="Bahar">Bahar</option>
                    </select>
                </div>
                <div class="text-end my-4 my-2">
                    <button type="submit" class="btn btn-primary">Aktif dönemi belirle</button>
                </div>
            </form>
        </div>
    </div>
</x-app>
