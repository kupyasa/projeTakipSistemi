<x-app title="Danışman Dahil Et">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Danışmanı Dahil Et') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Danışmanı sisteme dahil et</h5>

            <form action="{{ route('sistemyoneticisi.danismandahiletpost') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="danisman_id" class="form-label">Danışman bilgileri</label>
                    <select class="form-select" name="danisman_id" id="danisman_id" required>
                        @foreach ($danismans as $danisman)
                            <option value="{{ $danisman->id }}">{{ $danisman->title }} {{ $danisman->name }}
                                {{ $danisman->surname }}</option>
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
