<x-app title="Kullanıcılar">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Kullanıcılar') }}
        </h2>
    </x-slot>


    @if ($kullanicilar->count())
        <div class="accordion" id="accordionExample">

            @foreach ($kullanicilar as $kullanici)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $kullanici->id }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $kullanici->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $kullanici->id }}">
                            {{ $kullanici->name }} {{ $kullanici->surname }}
                        </button>
                    </h2>
                    <div id="collapse{{ $kullanici->id }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ $kullanici->id }}" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if ($kullanici->created_at)
                                <p>Üyelik oluşturulma tarihi :
                                    {{ $kullanici->created_at->timezone('Europe/Istanbul')->format('d-m-Y H:i:s') }}
                                </p>
                            @endif

                            <p>Eposta: {{ $kullanici->email }}</p>
                            <p>Telefon Numarası: {{ $kullanici->phone_number }}</p>
                            <p>Fakülte: {{ $kullanici->faculty }}</p>
                            <p>Bölüm: {{ $kullanici->department }}</p>
                            @if ($kullanici->title)
                                <p>Unvan: {{ $kullanici->title }}</p>
                            @endif
                            @if ($kullanici->year)
                                <p>Sınıf: {{ $kullanici->year }}</p>
                            @endif
                            @if ($kullanici->student_id)
                                <p>Öğrenci Numarası: {{ $kullanici->student_id }}</p>
                            @endif
                            <form action="{{ route('sistemyoneticisi.kullaniciduzenleget', $kullanici->id) }}"
                                method="get" enctype="multipart/form-data">
                                @csrf
                                <div class="text-end my-2">
                                    <button type="submit" class="btn btn-primary">Kullanıcıyı Düzenle</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <p class="text-center">Kullanıcı bulunmamaktadır.</p>
            </div>
        </div>

    @endif
</x-app>
