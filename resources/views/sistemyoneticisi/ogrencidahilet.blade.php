<x-app title="Öğrenci Dahil Et">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Öğrenci Dahil Et') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Öğrenciyi sisteme dahil et</h5>

            <form action="{{ route('sistemyoneticisi.ogrencidahiletpost') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="ogrenci_id" class="form-label">Öğrenci bilgileri</label>
                    <select class="form-select" name="ogrenci_id" id="ogrenci_id" required>
                        @foreach ($ogrencis as $ogrenci)
                            <option value="{{ $ogrenci->id }}">{{ $ogrenci->student_id }} {{ $ogrenci->name }}
                                {{ $ogrenci->surname }} {{ $ogrenci->faculty }} {{ $ogrenci->department }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="text-end my-4 my-2">
                    <button type="submit" class="btn btn-primary">Dahil et</button>
                </div>
            </form>
        </div>
    </div>
</x-app>