<?php

namespace App\Http\Controllers;

use App\Models\AktifDonem;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SistemYoneticisiController extends Controller
{
    public function ogrenciEkleGet()
    {
        return view('sistemyoneticisi.ogrenciekle');
    }

    public function ogrenciEklePost(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $imagename = date('dmYHi') . $request->image->getClientOriginalName();
        $request->image->move(public_path('images/profile_photos'), $imagename);

        DB::table('users')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'student_id' => $request->student_id,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'year' => $request->year,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo' => $imagename,
            'role' => 'Öğrenci',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        Mail::send('ogrencimail', array(
            'name' => $request->name,
            'surname' => $request->surname,
            'student_id' => $request->student_id,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'year' => $request->year,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'Öğrenci'
        ), function ($message) use ($request) {
            $message->from('admin@admin.com', 'Sistem Yöneticisi');
            $message->to($request->email)->subject('Proje Takip Sistemi Kayıt Bilgileriniz');
        });

        return redirect(url('/'));
    }

    public function danismanEkleGet()
    {
        return view('sistemyoneticisi.danismanekle');
    }

    public function danismanEklePost(Request $request)
    {
        $request->validate([
            'image' => 'required|image'
        ]);

        $imagename = date('dmYHi') . $request->image->getClientOriginalName();
        $request->image->move(public_path('images/profile_photos'), $imagename);

        DB::table('users')->insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_photo' => $imagename,
            'title' => $request->title,
            'role' => 'Proje Yürütücüsü',
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ]);

        Mail::send('danismanmail', array(
            'name' => $request->name,
            'surname' => $request->surname,
            'faculty' => $request->faculty,
            'department' => $request->department,
            'title' => $request->title,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'Proje Yürütücüsü'
        ), function ($message) use ($request) {
            $message->from('admin@admin.com', 'Sistem Yöneticisi');
            $message->to($request->email)->subject('Proje Takip Sistemi Kayıt Bilgileriniz');
        });

        return redirect(url('/'));
    }

    public function aktifDonemGet()
    {
        $aktif_donem = null;
        
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_donem = AktifDonem::find(1);
        }
        dd($aktif_donem);
        return view('sistemyoneticisi.aktifdonem', ['aktif_donem' => $aktif_donem]);
    }

    public function aktifDonemPost(Request $request)
    {
        AktifDonem::updateOrCreate(
            ['id' =>  1],
            ['yil' => $request->yil, 'donem' => $request->donem]
        );

        return redirect(route('sistemyoneticisi.aktifdonemget'));
    }
    public function danismanDahilEtGet()
    {

        $danismans = User::where([['role', '=', 'Proje Yürütücüsü']])->get();
        return view('sistemyoneticisi.danismandahilet', ['danismans' => $danismans]);
    }

    public function danismanDahilEtPost(Request $request)
    {
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            if (!(DB::table('konus')->where([['danisman_id', '=', $request->danisman_id], ['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem]])->exists())) {
                for ($i = 0; $i < 10; $i++) {
                    DB::table('konus')->insert([
                        'danisman_id' => $request->danisman_id,
                        'proje_yil' => $aktif_yil_donem->yil,
                        'proje_donem' => $aktif_yil_donem->donem,
                        'created_at' => Carbon::now()->toDateTimeString(),
                        'updated_at' => Carbon::now()->toDateTimeString()
                    ]);
                }
            }
        }

        return redirect(route('sistemyoneticisi.danismandahiletget'));
    }

    public function ogrenciDahilEtGet()
    {

        $ogrencis = User::where([['role', '=', 'Öğrenci']])->get();
        return view('sistemyoneticisi.ogrencidahilet', ['ogrencis' => $ogrencis]);
    }

    public function ogrenciDahilEtPost(Request $request)
    {
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            if ((DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem]])->whereNull('ogrenci_id')->exists())) {
                if (!(DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', $request->ogrenci_id]])->exists())) {
                    $ogrenci_atama = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem]])->whereNull('ogrenci_id')->orderByDesc('updated_at')->first();
                    DB::table('konus')->where([['id', '=', $ogrenci_atama->id]])->update(['ogrenci_id' => $request->ogrenci_id]);
                }
            }
        }

        return redirect(route('sistemyoneticisi.ogrencidahiletget'));
    }

    public function konuOnerileriYilDonemGet()
    {
        return view('sistemyoneticisi.konuonerileriyildonem');
    }
    public function konuOnerileriYilDonemPost(Request $request)
    {
        return redirect(route('sistemyoneticisi.konuonerileriget', ['yil' => $request->yil, 'donem' => $request->donem]));
    }

    public function konuOnerileriGet($yil,$donem){
        $konu_onerileri = DB::table('konus')->join('users as danisman_users', function ($join) use ($yil,$donem) {
            $join->on('konus.danisman_id', '=', 'danisman_users.id')->where([['konus.proje_yil', '=', $yil], ['konus.proje_donem', '=', $donem],]);
        })->join('users as ogrenci_users', function ($join) use ($yil,$donem) {
            $join->on('konus.ogrenci_id', '=', 'ogrenci_users.id')->where([['konus.proje_yil', '=', $yil], ['konus.proje_donem', '=', $donem],]);
        })->select('konus.id as konu_id', 'konus.proje_baslik as konu_proje_baslik', 'konus.proje_amac as konu_proje_amac', 'konus.proje_onem as konu_proje_onem', 'konus.proje_kapsam as konu_proje_kapsam', 'konus.proje_anahtar_kelimeler as konu_proje_anahtar_kelimeler', 'konus.proje_materyal as konu_proje_materyal', 'konus.proje_yontem as konu_proje_yontem', 'konus.proje_arastirma as konu_proje_arastirma', 'konus.konu_onay_durumu as konu_onay_durumu', 'konus.red_nedeni as konu_red_nedeni', 'konus.proje_durumu as proje_durumu', 'konus.ogrenci_id as konu_ogrenci_id', 'konus.danisman_id as konu_danisman_id', 'konus.proje_yil as konu_proje_yil', 'konus.proje_donem as konu_proje_donem', 'konus.created_at as konu_created_at', 'konus.updated_at as konu_updated_at', 'danisman_users.name as danisman_ad', 'danisman_users.surname as danisman_soyad', 'danisman_users.email as danisman_email', 'danisman_users.phone_number as danisman_telefon_no', 'danisman_users.title as danisman_unvan', 'danisman_users.faculty as danisman_fakulte', 'danisman_users.department as danisman_bolum','ogrenci_users.name as ogrenci_ad', 'ogrenci_users.surname as ogrenci_soyad', 'ogrenci_users.email as ogrenci_email', 'ogrenci_users.phone_number as ogrenci_telefon_no', 'ogrenci_users.title as ogrenci_unvan', 'ogrenci_users.faculty as ogrenci_fakulte', 'ogrenci_users.department as ogrenci_bolum', 'ogrenci_users.year as ogrenci_sinif', 'ogrenci_users.student_id as ogrenci_id')->orderByDesc('konu_updated_at')->get();
        
        return view('sistemyoneticisi.konuonerileri',['konu_onerileri'=> $konu_onerileri,'yil'=>$yil,'donem' => $donem ]);
    }

    public function raporlarYilDonemGet()
    {
        return view('sistemyoneticisi.raporlaryildonem');
    }
    public function raporlarYilDonemPost(Request $request)
    {
        return redirect(route('sistemyoneticisi.raporlarget', ['yil' => $request->yil, 'donem' => $request->donem]));
    }

    public function raporlarGet($yil,$donem){
        $raporlar = DB::table('rapors')->join('users as danisman_users', function ($join) use ($yil,$donem) {
            $join->on('rapors.danisman_id', '=', 'danisman_users.id')->where([['rapors.proje_yil', '=', $yil], ['rapors.proje_donem', '=', $donem],]);
        })->join('users as ogrenci_users', function ($join) use ($yil,$donem) {
            $join->on('rapors.ogrenci_id', '=', 'ogrenci_users.id')->where([['rapors.proje_yil', '=', $yil], ['rapors.proje_donem', '=', $donem],]);
        })->select('rapors.id as rapor_id', 'rapors.rapor_dosya_yolu as rapor_dosya_yolu', 'rapors.rapor_sayi_turu as rapor_sayi_turu', 'rapors.rapor_gorulme_durumu as rapor_gorulme_durumu', 'rapors.rapor_onay_durumu as rapor_onay_durumu', 'rapors.proje_durumu as proje_durumu', 'rapors.ogrenci_id as rapor_ogrenci_id', 'rapors.danisman_id as rapor_danisman_id', 'rapors.proje_yil as rapor_proje_yil', 'rapors.proje_donem as rapor_proje_donem', 'rapors.created_at as rapor_created_at', 'rapors.updated_at as rapor_updated_at', 'danisman_users.name as danisman_ad', 'danisman_users.surname as danisman_soyad', 'danisman_users.email as danisman_email', 'danisman_users.phone_number as danisman_telefon_no', 'danisman_users.title as danisman_unvan', 'danisman_users.faculty as danisman_fakulte', 'danisman_users.department as danisman_bolum','ogrenci_users.name as ogrenci_ad', 'ogrenci_users.surname as ogrenci_soyad', 'ogrenci_users.email as ogrenci_email', 'ogrenci_users.phone_number as ogrenci_telefon_no', 'ogrenci_users.title as ogrenci_unvan', 'ogrenci_users.faculty as ogrenci_fakulte', 'ogrenci_users.department as ogrenci_bolum', 'ogrenci_users.year as ogrenci_sinif', 'ogrenci_users.student_id as ogrenci_id')->orderByDesc('rapor_updated_at')->get();
        
        return view('sistemyoneticisi.raporlar',['raporlar'=> $raporlar,'yil'=>$yil,'donem' => $donem ]);
    }

    public function tezlerYilDonemGet()
    {
        return view('sistemyoneticisi.tezleryildonem');
    }
    public function tezlerYilDonemPost(Request $request)
    {
        return redirect(route('sistemyoneticisi.tezlerget', ['yil' => $request->yil, 'donem' => $request->donem]));
    }

    public function tezlerGet($yil,$donem){
        $tezler = DB::table('tezs')->join('users as danisman_users', function ($join) use ($yil,$donem) {
            $join->on('tezs.danisman_id', '=', 'danisman_users.id')->where([['tezs.proje_yil', '=', $yil], ['tezs.proje_donem', '=', $donem],]);
        })->join('users as ogrenci_users', function ($join) use ($yil,$donem) {
            $join->on('tezs.ogrenci_id', '=', 'ogrenci_users.id')->where([['tezs.proje_yil', '=', $yil], ['tezs.proje_donem', '=', $donem],]);
        })->select('tezs.id as tez_id', 'tezs.tez_dosya_yolu as tez_dosya_yolu', 'tezs.tez_turu as tez_turu', 'tezs.tez_gorulme_durumu as tez_gorulme_durumu', 'tezs.tez_onay_durumu as tez_onay_durumu', 'tezs.proje_durumu as proje_durumu', 'tezs.ogrenci_id as tez_ogrenci_id', 'tezs.danisman_id as tez_danisman_id', 'tezs.proje_yil as tez_proje_yil', 'tezs.proje_donem as tez_proje_donem', 'tezs.created_at as tez_created_at', 'tezs.updated_at as tez_updated_at', 'danisman_users.name as danisman_ad', 'danisman_users.surname as danisman_soyad', 'danisman_users.email as danisman_email', 'danisman_users.phone_number as danisman_telefon_no', 'danisman_users.title as danisman_unvan', 'danisman_users.faculty as danisman_fakulte', 'danisman_users.department as danisman_bolum','ogrenci_users.name as ogrenci_ad', 'ogrenci_users.surname as ogrenci_soyad', 'ogrenci_users.email as ogrenci_email', 'ogrenci_users.phone_number as ogrenci_telefon_no', 'ogrenci_users.title as ogrenci_unvan', 'ogrenci_users.faculty as ogrenci_fakulte', 'ogrenci_users.department as ogrenci_bolum', 'ogrenci_users.year as ogrenci_sinif', 'ogrenci_users.student_id as ogrenci_id')->orderByDesc('tez_updated_at')->get();
        
        return view('sistemyoneticisi.tezler',['tezler'=> $tezler,'yil'=>$yil,'donem' => $donem ]);
    }
    
}
