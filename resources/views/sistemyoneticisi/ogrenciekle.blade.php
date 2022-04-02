<x-app title="Öğrenci Ekle">
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Öğrenci Ekle') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Sisteme yeni öğrenci ekle</h5>
            <form action="{{route('sistemyoneticisi.ogrencieklepost')}}" method="POST" enctype="multipart/form-data">
                @csrf               
                <div class="mb-3">
                    <label for="name" class="form-label">Ad</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Soyad</label>
                    <input type="text" class="form-control" id="surname" name="surname"  required>
                </div>
                <div class="mb-3">
                    <label for="student_id" class="form-label">Öğrenci numarası</label>
                    <input type="text" class="form-control" id="student_id" name="student_id"  required>
                </div>
                <div class="mb-3">
                    <label for="faculty" class="form-label">Fakülte</label>
                    <input type="text" class="form-control" id="faculty" name="faculty"  required>
                </div>
                <div class="mb-3">
                    <label for="department" class="form-label">Bölüm</label>
                    <input type="text" class="form-control" id="department" name="department"  required>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Sınıf</label>
                    <input type="text" class="form-control" id="year" name="year"  required>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Telefon numarası</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"  required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Eposta adresi</label>
                    <input type="email" class="form-control" id="email" name="email"  required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" class="form-control" id="password" name="password"  required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Profil fotoğrafı</label>
                    <input class="form-control" type="file" id="image" name="image" required>
                </div>
                <div class="text-end my-4 my-2">
                    <button type="submit" class="btn btn-primary">Öğrenciyi ekle</button>
                </div>
            </form>
        </div>
    </div>

</x-app>