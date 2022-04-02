<x-app title="Kullanıcı Bilgileri">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Kullanıcı Bilgileri') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Kullanıcı bilgilerini düzenle</h5>
            <form action="{{ route('sistemyoneticisi.kullaniciduzenlepost', $user->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                @if ($user->profile_photo)
                    <img src="{{ asset('images/profile_photos/' . $user->profile_photo) }}" class="rounded mx-auto d-block"
                        style="width: 25%;height:25%">
                @endif
                <input type="hidden" name="role" value="{{$user->role}}">
                <div class="mb-3">
                    <label for="name" class="form-label">Ad</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Soyad</label>
                    <input type="text" class="form-control" id="surname" name="surname" value="{{ $user->surname }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Eposta adresi</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Telefon Numarası</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                        value="{{ $user->phone_number }}" required>
                </div>
                <div class="mb-3">
                    <label for="faculty" class="form-label">Fakülte</label>
                    <input type="text" class="form-control" id="faculty" name="faculty" value="{{ $user->faculty }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Bölüm</label>
                    <input type="text" class="form-control" id="department" name="department"
                        value="{{ $user->department }}" required>
                </div>
                @if ($user->title)
                    <div class="mb-3">
                        <label for="title" class="form-label">Unvan</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ $user->title }}" required>
                    </div>
                @endif
                @if ($user->year)
                    <div class="mb-3">
                        <label for="year" class="form-label">Sınıf</label>
                        <input type="text" class="form-control" id="year" name="year"
                            value="{{ $user->year }}" required>
                    </div>
                @endif
                @if ($user->student_id)
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Öğrenci Numarası</label>
                        <input type="text" class="form-control" id="student_id" name="student_id"
                            value="{{ $user->student_id }}" required>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="image" class="form-label">Profil fotoğrafı</label>
                    <input class="form-control" type="file" id="image" name="image">
                </div>
                <div class="text-end my-4 my-2">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>

</x-app>
