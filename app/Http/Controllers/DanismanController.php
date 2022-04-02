<?php

namespace App\Http\Controllers;

use App\Models\AktifDonem;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DanismanController extends Controller
{
    public function konuOnerileriGet()
    {
        $sisteme_dahil = false;
        $konu_onerileri = null;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['danisman_id', '=', auth()->user()->id]])->exists();
            $konu_onerileri = DB::table('konus')->join('users', function ($join) use ($aktif_yil_donem) {
                $join->on('konus.ogrenci_id', '=', 'users.id')->where([['konus.proje_yil', '=', $aktif_yil_donem->yil], ['konus.proje_donem', '=', $aktif_yil_donem->donem], ['konus.danisman_id', '=', auth()->user()->id]]);
            })->select('konus.id as konu_id', 'konus.proje_baslik as konu_proje_baslik', 'konus.proje_amac as konu_proje_amac', 'konus.proje_onem as konu_proje_onem', 'konus.proje_kapsam as konu_proje_kapsam', 'konus.proje_anahtar_kelimeler as konu_proje_anahtar_kelimeler', 'konus.proje_materyal as konu_proje_materyal', 'konus.proje_yontem as konu_proje_yontem', 'konus.proje_arastirma as konu_proje_arastirma', 'konus.konu_onay_durumu as konu_onay_durumu', 'konus.red_nedeni as konu_red_nedeni', 'konus.proje_durumu as proje_durumu', 'konus.ogrenci_id as konu_ogrenci_id', 'konus.danisman_id as konu_danisman_id', 'konus.proje_yil as konu_proje_yil', 'konus.proje_donem as konu_proje_donem', 'konus.created_at as konu_created_at', 'konus.updated_at as konu_updated_at', 'users.name as ogrenci_ad', 'users.surname as ogrenci_soyad', 'users.email as ogrenci_email', 'users.phone_number as ogrenci_telefon_no', 'users.title as ogrenci_unvan', 'users.faculty as ogrenci_fakulte', 'users.department as ogrenci_bolum', 'users.year as ogrenci_sinif', 'users.student_id as ogrenci_id','users.profile_photo as ogrenci_foto')->orderByDesc('konu_updated_at')->get();
        }
        return view('danisman.konuonerileri', ['konu_onerileri' => $konu_onerileri, 'sisteme_dahil' => $sisteme_dahil]);
    }

    public function konuOnerisiDuzenleGet($konu_onerisi_id)
    {
        $konu_onerisi = null;
        $konu_onerisi_bekleme = false;
        if (DB::table('konus')->where([['id', '=', $konu_onerisi_id], ['danisman_id', '=', auth()->user()->id]])->exists()) {
            $konu_onerisi = DB::table('konus')->where([['id', '=', $konu_onerisi_id]])->first();
            $konu_onerisi_bekleme = DB::table('konus')->where([['id', '=', $konu_onerisi_id], ['konu_onay_durumu', '=', 'Beklemede']])->exists();
        }

        return view('danisman.konuonerisiduzenle', ['konu_onerisi' => $konu_onerisi, 'konu_onerisi_bekleme' => $konu_onerisi_bekleme]);
    }

    public function konuOnerisiDuzenlepost(Request $request)
    {
        if ($request->konu_onay_durumu == 'Onaylandı') {
            DB::table('konus')->where([['id', '=', $request->oneri_id]])->update([
                'konu_onay_durumu' => 'Onaylandı',
                'proje_durumu' => 'Devam Ediyor',
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        } elseif ($request->konu_onay_durumu == 'Reddedildi') {
            DB::table('konus')->where([['id', '=', $request->oneri_id]])->update([
                'konu_onay_durumu' => 'Reddedildi',
                'proje_durumu' => 'Konu Önerisi Reddedildi',
                'red_nedeni' => $request->red_nedeni,
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        return redirect(route('danisman.konuonerileriget'));
    }

    public function raporlarGet()
    {
        $sisteme_dahil = false;
        $raporlar = null;

        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['danisman_id', '=', auth()->user()->id]])->exists();
            $raporlar = DB::table('rapors')->join('users', function ($join) use ($aktif_yil_donem) {
                $join->on('rapors.ogrenci_id', '=', 'users.id')->where([['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['rapors.danisman_id', '=', auth()->user()->id]]);
            })->select('rapors.id as rapor_id', 'rapors.rapor_dosya_yolu as rapor_dosya_yolu', 'rapors.rapor_sayi_turu as rapor_sayi_turu', 'rapors.rapor_gorulme_durumu as rapor_gorulme_durumu', 'rapors.rapor_onay_durumu as rapor_onay_durumu', 'rapors.proje_durumu as proje_durumu', 'rapors.ogrenci_id as rapor_ogrenci_id', 'rapors.danisman_id as rapor_danisman_id', 'rapors.proje_yil as rapor_proje_yil', 'rapors.proje_donem as rapor_proje_donem', 'rapors.created_at as rapor_created_at', 'rapors.updated_at as rapor_updated_at', 'users.name as ogrenci_ad', 'users.surname as ogrenci_soyad', 'users.email as ogrenci_email', 'users.phone_number as ogrenci_telefon_no', 'users.title as ogrenci_unvan', 'users.faculty as ogrenci_fakulte', 'users.department as ogrenci_bolum', 'users.year as ogrenci_sinif', 'users.student_id as ogrenci_id')->orderByDesc('rapor_updated_at')->get();
        }

        return view('danisman.raporlar', ['raporlar' => $raporlar, 'sisteme_dahil' => $sisteme_dahil,]);
    }

    public function raporDuzenleGet($rapor_id)
    {
        $rapor = null;
        $rapor_onay_bekleme = false;
        if (DB::table('rapors')->where([['id', '=', $rapor_id], ['danisman_id', '=', auth()->user()->id]])->exists()) {
            $rapor = DB::table('rapors')->where([['id', '=', $rapor_id]])->first();

            $rapor_onay_bekleme = DB::table('rapors')->where([['id', '=', $rapor_id], ['rapor_onay_durumu', '=', 'Beklemede']])->exists();
        }

        return view('danisman.raporduzenle', ['rapor' => $rapor, 'rapor_onay_bekleme' => $rapor_onay_bekleme]);
    }

    public function raporDuzenlepost(Request $request)
    {
        if ($request->rapor_onay_durumu == 'Onaylandı') {
            DB::table('rapors')->where([['id', '=', $request->rapor_id]])->update([
                'rapor_gorulme_durumu' => 'Görüldü',
                'rapor_onay_durumu' => 'Onaylandı',
                'proje_durumu' => 'Devam Ediyor',
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        } elseif ($request->rapor_onay_durumu == 'Reddedildi') {
            DB::table('rapors')->where([['id', '=', $request->rapor_id]])->update([
                'rapor_gorulme_durumu' => 'Görüldü',
                'rapor_onay_durumu' => 'Reddedildi',
                'proje_durumu' => 'Rapor Reddedildi',
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        return redirect(route('danisman.raporlarget'));
    }

    public function tezlerGet()
    {
        $sisteme_dahil = false;
        $tezler = null;

        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['danisman_id', '=', auth()->user()->id]])->exists();
            $tezler = DB::table('tezs')->join('users', function ($join) use ($aktif_yil_donem) {
                $join->on('tezs.ogrenci_id', '=', 'users.id')->where([['tezs.proje_yil', '=', $aktif_yil_donem->yil], ['tezs.proje_donem', '=', $aktif_yil_donem->donem], ['tezs.danisman_id', '=', auth()->user()->id]]);
            })->select('tezs.id as tez_id', 'tezs.tez_dosya_yolu as tez_dosya_yolu', 'tezs.tez_turu as tez_turu', 'tezs.tez_gorulme_durumu as tez_gorulme_durumu', 'tezs.tez_onay_durumu as tez_onay_durumu', 'tezs.proje_durumu as proje_durumu', 'tezs.ogrenci_id as tez_ogrenci_id', 'tezs.danisman_id as tez_danisman_id', 'tezs.proje_yil as tez_proje_yil', 'tezs.proje_donem as tez_proje_donem', 'tezs.created_at as tez_created_at', 'tezs.updated_at as tez_updated_at', 'users.name as ogrenci_ad', 'users.surname as ogrenci_soyad', 'users.email as ogrenci_email', 'users.phone_number as ogrenci_telefon_no', 'users.title as ogrenci_unvan', 'users.faculty as ogrenci_fakulte', 'users.department as ogrenci_bolum', 'users.year as ogrenci_sinif', 'users.student_id as ogrenci_id')->orderByDesc('tez_updated_at')->get();
        }

        return view('danisman.tezler', ['tezler' => $tezler, 'sisteme_dahil' => $sisteme_dahil]);
    }

    public function tezDuzenleGet($tez_id)
    {
        $tez = null;
        $tez_onay_bekleme = false;
        if (DB::table('tezs')->where([['id', '=', $tez_id], ['danisman_id', '=', auth()->user()->id]])->exists()) {
            $tez = DB::table('tezs')->where([['id', '=', $tez_id]])->first();

            $tez_onay_bekleme = DB::table('tezs')->where([['id', '=', $tez_id], ['tez_onay_durumu', '=', 'Beklemede']])->exists();
        }

        return view('danisman.tezduzenle', ['tez' => $tez, 'tez_onay_bekleme' => $tez_onay_bekleme]);
    }

    public function tezDuzenlepost(Request $request)
    {
        $aktif_yil_donem = AktifDonem::find(1);
        if ($request->tez_onay_durumu == 'Onaylandı') {
            DB::table('tezs')->where([['id', '=', $request->tez_id]])->update([
                'tez_gorulme_durumu' => 'Görüldü',
                'tez_onay_durumu' => 'Onaylandı',
                'proje_durumu' => 'Devam Ediyor',
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        } elseif ($request->tez_onay_durumu == 'Reddedildi') {
            DB::table('tezs')->where([['id', '=', $request->tez_id]])->update([
                'tez_gorulme_durumu' => 'Görüldü',
                'tezonay_durumu' => 'Reddedildi',
                'proje_durumu' => 'Tez Reddedildi',
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        if ((2 == DB::table('tezs')->whereIn('tez_turu', ['Tez DOC', 'Tez PDF'])->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', $request->ogrenci_id], ['tez_onay_durumu', '=', 'Onaylandı']])->count())) {
            DB::table('tezs')->whereIn('tez_turu', ['Tez DOC', 'Tez PDF'])->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', $request->ogrenci_id], ['tez_onay_durumu', '=', 'Onaylandı']])->update(['proje_durumu' => 'Tamamlandı', 'updated_at' => Carbon::now()->toDateTimeString()]);
            DB::table('rapors')->whereIn('rapor_sayi_turu', ['Rapor 1 DOC', 'Rapor 2 DOC', 'Rapor 3 DOC', 'Rapor 1 PDF', 'Rapor 2 PDF', 'Rapor 3 PDF'])->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', $request->ogrenci_id], ['rapor_onay_durumu', '=', 'Onaylandı']])->update(['proje_durumu' => 'Tamamlandı', 'updated_at' => Carbon::now()->toDateTimeString()]);
            DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', $request->ogrenci_id], ['konu_onay_durumu', '=', 'Onaylandı']])->update(['proje_durumu' => 'Tamamlandı', 'updated_at' => Carbon::now()->toDateTimeString()]);
        }

        return redirect(route('danisman.tezlerget'));
    }

    public function benzerKonuOnerileriGet() {
        $sisteme_dahil = false;
        $benzer_konu_onerileri = null;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['danisman_id', '=', auth()->user()->id]])->exists();
            $benzer_konu_onerileri = DB::table('benzer_konus')->join('konus as yeni_konus', function ($join) use ($aktif_yil_donem) {
                $join->on('benzer_konus.yeni_proje_id', '=', 'yeni_konus.id')->where([['benzer_konus.yil', '=', $aktif_yil_donem->yil], ['benzer_konus.donem', '=', $aktif_yil_donem->donem], ['benzer_konus.yeni_danisman_id', '=', auth()->user()->id]]);
            })->join('konus as eski_konus', function ($join) use ($aktif_yil_donem) {
                $join->on('benzer_konus.eski_proje_id', '=', 'eski_konus.id')->where([['benzer_konus.yil', '=', $aktif_yil_donem->yil], ['benzer_konus.donem', '=', $aktif_yil_donem->donem], ['benzer_konus.yeni_danisman_id', '=', auth()->user()->id]]);
            })->join('users as eski_danisman_users', function ($join) use ($aktif_yil_donem) {
                $join->on('benzer_konus.eski_danisman_id', '=', 'eski_danisman_users.id')->where([['benzer_konus.yil', '=', $aktif_yil_donem->yil], ['benzer_konus.donem', '=', $aktif_yil_donem->donem], ['benzer_konus.yeni_danisman_id', '=', auth()->user()->id]]);
            })->join('users as eski_ogrenci_users', function ($join) use ($aktif_yil_donem) {
                $join->on('benzer_konus.eski_ogrenci_id', '=', 'eski_ogrenci_users.id')->where([['benzer_konus.yil', '=', $aktif_yil_donem->yil], ['benzer_konus.donem', '=', $aktif_yil_donem->donem], ['benzer_konus.yeni_danisman_id', '=', auth()->user()->id]]);
            })->select('benzer_konus.id as benzer_konu_id', 'yeni_konus.proje_baslik as yeni_konu_proje_baslik', 'yeni_konus.proje_amac as yeni_konu_proje_amac', 'yeni_konus.proje_onem as yeni_konu_proje_onem', 'yeni_konus.proje_kapsam as yeni_konu_proje_kapsam', 'yeni_konus.proje_anahtar_kelimeler as yeni_konu_proje_anahtar_kelimeler', 'yeni_konus.proje_materyal as yeni_konu_proje_materyal', 'yeni_konus.proje_yontem as yeni_konu_proje_yontem', 'yeni_konus.proje_arastirma as yeni_konu_proje_arastirma', 'yeni_konus.konu_onay_durumu as yeni_konu_onay_durumu', 'yeni_konus.red_nedeni as yeni_konu_red_nedeni', 'yeni_konus.proje_durumu as yeni_konu_proje_durumu', 'yeni_konus.ogrenci_id as yeni_konu_ogrenci_id', 'yeni_konus.danisman_id as yeni_konu_danisman_id', 'yeni_konus.proje_yil as yeni_konu_proje_yil', 'yeni_konus.proje_donem as yeni_konu_proje_donem', 'yeni_konus.created_at as yeni_konu_created_at', 'yeni_konus.updated_at as yeni_konu_updated_at','eski_konus.proje_baslik as eski_konu_proje_baslik', 'eski_konus.proje_amac as eski_konu_proje_amac', 'eski_konus.proje_onem as eski_konu_proje_onem', 'eski_konus.proje_kapsam as eski_konu_proje_kapsam', 'eski_konus.proje_anahtar_kelimeler as eski_konu_proje_anahtar_kelimeler', 'eski_konus.proje_materyal as eski_konu_proje_materyal', 'eski_konus.proje_yontem as eski_konu_proje_yontem', 'eski_konus.proje_arastirma as eski_konu_proje_arastirma', 'eski_konus.konu_onay_durumu as eski_konu_onay_durumu', 'eski_konus.red_nedeni as eski_konu_red_nedeni', 'eski_konus.proje_durumu as eski_konu_proje_durumu', 'eski_konus.ogrenci_id as eski_konu_ogrenci_id', 'eski_konus.danisman_id as eski_konu_danisman_id', 'eski_konus.proje_yil as eski_konu_proje_yil', 'eski_konus.proje_donem as eski_konu_proje_donem', 'eski_konus.created_at as eski_konu_created_at', 'eski_konus.updated_at as eski_konu_updated_at', 'eski_danisman_users.name as danisman_ad', 'eski_danisman_users.surname as danisman_soyad', 'eski_danisman_users.email as danisman_email', 'eski_danisman_users.phone_number as danisman_telefon_no', 'eski_danisman_users.title as danisman_unvan', 'eski_danisman_users.faculty as danisman_fakulte', 'eski_danisman_users.department as danisman_bolum','eski_ogrenci_users.name as ogrenci_ad','eski_ogrenci_users.surname as ogrenci_soyad','eski_ogrenci_users.email as ogrenci_email','eski_ogrenci_users.phone_number as ogrenci_telefon_no','eski_ogrenci_users.year as ogrenci_sinif','eski_ogrenci_users.student_id as ogrenci_no','eski_ogrenci_users.faculty as ogrenci_fakulte','eski_ogrenci_users.department as ogrenci_bolum')->orderByDesc('yeni_konu_updated_at')->get();
            
        }

        return view('danisman.benzerkonular', ['benzer_konu_onerileri' => $benzer_konu_onerileri, 'sisteme_dahil' => $sisteme_dahil]);
    }
}
