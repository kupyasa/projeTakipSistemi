<?php

use App\Http\Controllers\SistemYoneticisiController;
use App\Http\Controllers\SistemYoneticisiKullaniciController;
use App\Http\Controllers\OgrenciController;
use App\Http\Controllers\DanismanController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

Route::get('/public/raporlar/{filepath}', function ($filepath) {
    if (File::exists(public_path('raporlar/' . $filepath))) {
        return Response::download(public_path('raporlar/' . $filepath));
    }
    abort(404);
})->middleware(['auth']);

Route::get('/public/tezler/{filepath}', function ($filepath) {
    if (File::exists(public_path('tezler/' . $filepath))) {
        return Response::download(public_path('tezler/' . $filepath));
    }
    abort(404);
})->middleware(['auth']);


//Öğrenci
Route::get('/ogrenci/konu-onerilerim', [OgrenciController::class, 'konuOnerileriGet'])->name('ogrenci.konuonerileriget')->middleware('can:ogrenci');
Route::get('/ogrenci/konu-onerisi-yap', [OgrenciController::class, 'konuOnerisiYapGet'])->name('ogrenci.konuonerisiyapget')->middleware('can:ogrenci');
Route::post('/ogrenci/konu-onerisi-yap', [OgrenciController::class, 'konuOnerisiYapPost'])->name('ogrenci.konuonerisiyappost')->middleware('can:ogrenci');

Route::get('/ogrenci/raporlarim', [OgrenciController::class, 'raporlarGet'])->name('ogrenci.raporlarget')->middleware('can:ogrenci');
Route::get('/ogrenci/raporlari-yukle', [OgrenciController::class, 'raporlariYukleGet'])->name('ogrenci.raporlariyukleget')->middleware('can:ogrenci');
Route::post('/ogrenci/raporlari-yukle', [OgrenciController::class, 'raporlariYuklePost'])->name('ogrenci.raporlariyuklepost')->middleware('can:ogrenci');

Route::get('/ogrenci/tezlerim', [OgrenciController::class, 'tezlerGet'])->name('ogrenci.tezlerget')->middleware('can:ogrenci');
Route::get('/ogrenci/tez-yukle', [OgrenciController::class, 'tezYukleGet'])->name('ogrenci.tezyukleget')->middleware('can:ogrenci');
Route::post('/ogrenci/tez-yukle', [OgrenciController::class, 'tezYuklePost'])->name('ogrenci.tezyuklepost')->middleware('can:ogrenci');

Route::get('/ogrenci/benzer-konu-onerilerim',[OgrenciController::class, 'benzerKonuOnerileriGet'])->name('ogrenci.benzerkonuonerileriget')->middleware('can:ogrenci');


//Danışman
Route::get('/danisman/konu-onerileri', [DanismanController::class, 'konuOnerileriGet'])->name('danisman.konuonerileriget')->middleware('can:danisman');
Route::get('/danisman/konu-onerisi-duzenle/{konu_onerisi_id}', [DanismanController::class, 'konuOnerisiDuzenleGet'])->name('danisman.konuonerisiduzenleget')->middleware('can:danisman');
Route::post('/danisman/konu-onerisi-duzenle', [DanismanController::class, 'konuOnerisiDuzenlePost'])->name('danisman.konuonerisiduzenlepost')->middleware('can:danisman');

Route::get('/danisman/raporlar', [DanismanController::class, 'raporlarGet'])->name('danisman.raporlarget')->middleware('can:danisman');
Route::get('/danisman/raporlari-duzenle/{rapor_id}', [DanismanController::class, 'raporDuzenleGet'])->name('danisman.raporduzenleget')->middleware('can:danisman');
Route::post('/danisman/raporlari-duzenle', [DanismanController::class, 'raporDuzenlePost'])->name('danisman.raporduzenlepost')->middleware('can:danisman');

Route::get('/danisman/tezler', [DanismanController::class, 'tezlerGet'])->name('danisman.tezlerget')->middleware('can:danisman');
Route::get('/danisman/tez-duzenle/{tez_id}', [DanismanController::class, 'tezDuzenleGet'])->name('danisman.tezduzenleget')->middleware('can:danisman');
Route::post('/danisman/tez-duzenle', [DanismanController::class, 'tezDuzenlePost'])->name('danisman.tezduzenlepost')->middleware('can:danisman');

Route::get('/danisman/benzer-konu-onerilerim',[DanismanController::class, 'benzerKonuOnerileriGet'])->name('danisman.benzerkonuonerileriget')->middleware('can:danisman');

//Sistem Yöneticisi
Route::get('/sistem-yoneticisi/ogrenci-ekle', [SistemYoneticisiController::class, 'ogrenciEkleGet'])->name('sistemyoneticisi.ogrenciekleget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/ogrenci-ekle', [SistemYoneticisiController::class, 'ogrenciEklePost'])->name('sistemyoneticisi.ogrencieklepost')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/danisman-ekle', [SistemYoneticisiController::class, 'danismanEkleGet'])->name('sistemyoneticisi.danismanekleget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/danisman-ekle', [SistemYoneticisiController::class, 'danismanEklePost'])->name('sistemyoneticisi.danismaneklepost')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/aktif-donem', [SistemYoneticisiController::class, 'aktifDonemGet'])->name('sistemyoneticisi.aktifdonemget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/aktif-donem', [SistemYoneticisiController::class, 'aktifDonemPost'])->name('sistemyoneticisi.aktifdonempost')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/danisman-dahil-et', [SistemYoneticisiController::class, 'danismanDahilEtGet'])->name('sistemyoneticisi.danismandahiletget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/danisman-dahil-et', [SistemYoneticisiController::class, 'danismanDahilEtPost'])->name('sistemyoneticisi.danismandahiletpost')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/ogrenci-dahil-et', [SistemYoneticisiController::class, 'ogrenciDahilEtGet'])->name('sistemyoneticisi.ogrencidahiletget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/ogrenci-dahil-et', [SistemYoneticisiController::class, 'ogrenciDahilEtPost'])->name('sistemyoneticisi.ogrencidahiletpost')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/konu-onerileri-yil-donem', [SistemYoneticisiController::class, 'konuOnerileriYilDonemGet'])->name('sistemyoneticisi.konuonerileriyildonemget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/konu-onerileri-yil-donem', [SistemYoneticisiController::class, 'konuOnerileriYilDonemPost'])->name('sistemyoneticisi.konuonerileriyildonempost')->middleware('can:sistemyoneticisi');
Route::get('/sistem-yoneticisi/konu-onerileri/{yil}/{donem}', [SistemYoneticisiController::class, 'konuOnerileriGet'])->name('sistemyoneticisi.konuonerileriget')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/raporlar-yil-donem', [SistemYoneticisiController::class, 'raporlarYilDonemGet'])->name('sistemyoneticisi.raporlaryildonemget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/raporlar-yil-donem', [SistemYoneticisiController::class, 'raporlarYilDonemPost'])->name('sistemyoneticisi.raporlaryildonempost')->middleware('can:sistemyoneticisi');
Route::get('/sistem-yoneticisi/raporlar/{yil}/{donem}', [SistemYoneticisiController::class, 'raporlarGet'])->name('sistemyoneticisi.raporlarget')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/tezler-yil-donem', [SistemYoneticisiController::class, 'tezlerYilDonemGet'])->name('sistemyoneticisi.tezleryildonemget')->middleware('can:sistemyoneticisi');
Route::post('/sistem-yoneticisi/tezler-yil-donem', [SistemYoneticisiController::class, 'tezlerYilDonemPost'])->name('sistemyoneticisi.tezleryildonempost')->middleware('can:sistemyoneticisi');
Route::get('/sistem-yoneticisi/tezler/{yil}/{donem}', [SistemYoneticisiController::class, 'tezlerGet'])->name('sistemyoneticisi.tezlerget')->middleware('can:sistemyoneticisi');

Route::get('/sistem-yoneticisi/kullanicilar', [SistemYoneticisiKullaniciController::class, 'index'])->name('sistemyoneticisi.kullanicilarget')->middleware('can:sistemyoneticisi');
Route::get('/sistem-yoneticisi/kullanicilar/{user}/duzenle', [SistemYoneticisiKullaniciController::class, 'edit'])->name('sistemyoneticisi.kullaniciduzenleget')->middleware('can:sistemyoneticisi');
Route::patch('/sistem-yoneticisi/kullanicilar/{user}/duzenle', [SistemYoneticisiKullaniciController::class, 'update'])->name('sistemyoneticisi.kullaniciduzenlepost')->middleware('can:sistemyoneticisi');


require __DIR__ . '/auth.php';
