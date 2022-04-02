<x-app title="Tezler Yıl Dönem">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Tezler Yıl Dönem') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Hangi yıl ve dönem içindeki tezleri görmek istediğinizi
                seçiniz</h5>

            <form action="{{ route('sistemyoneticisi.tezleryildonempost') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="yil" class="form-label">Tez Yıl</label>
                    <select class="form-select" name="yil" id="yil" required>
                        @for ($i = 2020; $i < 2050; $i++)
                            <option value="{{ $i }}-{{ $i + 1 }}">
                                {{ $i }}-{{ $i + 1 }}</option>
                        @endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label for="donem" class="form-label">Tez Dönem</label>
                    <select class="form-select" name="donem" id="donem" required>
                        <option value="Güz">Güz</option>
                        <option value="Bahar">Bahar</option>
                    </select>
                </div>
                <div class="text-end my-4 my-2">
                    <button type="submit" class="btn btn-primary">Yıl ve dönemi seç</button>
                </div>
            </form>
        </div>
    </div>
</x-app>