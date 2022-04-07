<?php

namespace App\Http\Controllers;

use App\Models\AktifDonem;
use App\Helpers\SmithWatermanGotoh;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OgrenciController extends Controller
{

    public function konuOnerileriGet()
    {

        $konu_onerileri = null;
        $konu_onerisi_onay = false;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $konu_onerileri = DB::table('konus')->join('users', function ($join) use ($aktif_yil_donem) {
                $join->on('konus.danisman_id', '=', 'users.id')->where([['konus.proje_yil', '=', $aktif_yil_donem->yil], ['konus.proje_donem', '=', $aktif_yil_donem->donem], ['konus.ogrenci_id', '=', auth()->user()->id]]);
            })->select('konus.id as konu_id', 'konus.proje_baslik as konu_proje_baslik', 'konus.proje_amac as konu_proje_amac', 'konus.proje_onem as konu_proje_onem', 'konus.proje_kapsam as konu_proje_kapsam', 'konus.proje_anahtar_kelimeler as konu_proje_anahtar_kelimeler', 'konus.proje_materyal as konu_proje_materyal', 'konus.proje_yontem as konu_proje_yontem', 'konus.proje_arastirma as konu_proje_arastirma', 'konus.konu_onay_durumu as konu_onay_durumu', 'konus.red_nedeni as konu_red_nedeni', 'konus.proje_durumu as proje_durumu', 'konus.ogrenci_id as konu_ogrenci_id', 'konus.danisman_id as konu_danisman_id', 'konus.proje_yil as konu_proje_yil', 'konus.proje_donem as konu_proje_donem', 'konus.created_at as konu_created_at', 'konus.updated_at as konu_updated_at', 'users.name as danisman_ad', 'users.surname as danisman_soyad', 'users.email as danisman_email', 'users.phone_number as danisman_telefon_no', 'users.title as danisman_unvan', 'users.faculty as danisman_fakulte', 'users.department as danisman_bolum')->orderByDesc('konu_updated_at')->get();
            $konu_onerisi_onay = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['konu_onay_durumu', '=', 'Onaylandı']])->exists();
        }

        return view('ogrenci.konuonerilerim', ['konu_onerileri' => $konu_onerileri, 'konu_onerisi_onay' => $konu_onerisi_onay]);
    }

    public function konuOnerisiYapGet()
    {

        $sisteme_dahil = false;
        $konu_onerisi_onay = false;
        $konu_onerisi_bekleme = false;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $konu_onerisi_onay = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['konu_onay_durumu', '=', 'Onaylandı']])->exists();
            $konu_onerisi_bekleme = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['konu_onay_durumu', '=', 'Beklemede']])->exists();
        }

        return view('ogrenci.konuonerisiyap', ['konu_onerisi_onay' => $konu_onerisi_onay, 'sisteme_dahil' => $sisteme_dahil, 'konu_onerisi_bekleme' => $konu_onerisi_bekleme]);
    }

    public function konuOnerisiYapPost(Request $request)
    {
        $swg = new SmithWatermanGotoh();


        $request->validate([
            'proje_amac' => 'min:200',
            'proje_onem' => 'min:200',
            'proje_kapsam' => 'min:200',
            'proje_materyal' => 'min:300',
            'proje_yontem' => 'min:300',
            'proje_arastirma' => 'min:300',

        ]);
        if ((count(explode(" ",$request->proje_amac)) < 200) ||
            (count(explode(" ",$request->proje_onem)) < 200) ||
            (count(explode(" ",$request->proje_kapsam)) < 200) ||
            (count(explode(" ",$request->proje_materyal)) < 300) ||
            (count(explode(" ",$request->proje_yontem)) < 300) ||
            (count(explode(" ",$request->proje_arastirma)) < 300)) {
            return redirect(route('ogrenci.konuonerisiyapget'));
        }

        $konular = DB::table('konus')->whereNotNull('proje_baslik')->get();
        if (!$konular->isEmpty()) {
            foreach ($konular as $konu) {
                if ((($swg->compare($request->proje_baslik, $konu->proje_baslik) * 100) > 30.0) &&
                    (($swg->compare($request->proje_amac, $konu->proje_amac) * 100) > 30.0) &&
                    (($swg->compare($request->proje_onem, $konu->proje_onem) * 100) > 30.0) &&
                    (($swg->compare($request->proje_kapsam, $konu->proje_kapsam) * 100) > 30.0)
                ) {

                    return redirect(route('ogrenci.konuonerisiyapget'));
                }
            }
        }
        $benzer_konular = collect([]);
        $en_son_konu = null;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);

            foreach ($konular as $konu) {
                if ((($swg->compare(implode(" ", [$request->anahtar_kelime1, $request->anahtar_kelime2, $request->anahtar_kelime3, $request->anahtar_kelime4, $request->anahtar_kelime5]), $konu->proje_anahtar_kelimeler) * 100) > 40)) {
                    $benzer_konular->push($konu);
                }
            }

            if (DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->whereNull('proje_baslik')->exists()) {
                $en_son_konu = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->whereNull('proje_baslik')->first();
                DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->whereNull('proje_baslik')->update([
                    'proje_baslik' => $request->proje_baslik,
                    'proje_amac' => $request->proje_amac,
                    'proje_onem' => $request->proje_onem,
                    'proje_kapsam' => $request->proje_kapsam,
                    'proje_anahtar_kelimeler' => implode(" ", [$request->anahtar_kelime1, $request->anahtar_kelime2, $request->anahtar_kelime3, $request->anahtar_kelime4, $request->anahtar_kelime5]),
                    'proje_materyal' => $request->proje_materyal,
                    'proje_yontem' => $request->proje_yontem,
                    'proje_arastirma' => $request->proje_arastirma,
                    'konu_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Konu Onay Aşamasında',
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            } else {
                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                $en_son_konu_id = DB::table('konus')->insertGetId([
                    'proje_baslik' => $request->proje_baslik,
                    'proje_amac' => $request->proje_amac,
                    'proje_onem' => $request->proje_onem,
                    'proje_kapsam' => $request->proje_kapsam,
                    'proje_anahtar_kelimeler' => implode(" ", [$request->anahtar_kelime1, $request->anahtar_kelime2, $request->anahtar_kelime3, $request->anahtar_kelime4, $request->anahtar_kelime5]),
                    'proje_materyal' => $request->proje_materyal,
                    'proje_yontem' => $request->proje_yontem,
                    'proje_arastirma' => $request->proje_arastirma,
                    'konu_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Konu Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
                $en_son_konu = DB::table('konus')->find($en_son_konu_id);
            }
            if (!$benzer_konular->isEmpty() && $en_son_konu != null) {
                foreach ($benzer_konular as $benzer_konu) {
                    DB::table('benzer_konus')->insert([
                        'yeni_proje_id' => $en_son_konu->id,
                        'eski_proje_id' => $benzer_konu->id,
                        'yeni_ogrenci_id' => $en_son_konu->ogrenci_id,
                        'yeni_danisman_id' => $en_son_konu->danisman_id,
                        'eski_ogrenci_id' => $benzer_konu->ogrenci_id,
                        'eski_danisman_id' => $benzer_konu->danisman_id,
                        'yil' => $en_son_konu->proje_yil,
                        'donem' => $en_son_konu->proje_donem,

                    ]);
                }
            }
        }

        return redirect(route('ogrenci.konuonerileriget'));
    }

    public function raporlarGet()
    {
        $sisteme_dahil = false;
        $raporlar = null;
        $konu_onerisi_onay = false;
        $rapor_onay = false;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $raporlar = DB::table('rapors')->join('users', function ($join) use ($aktif_yil_donem) {
                $join->on('rapors.danisman_id', '=', 'users.id')->where([['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['rapors.ogrenci_id', '=', auth()->user()->id]]);
            })->select('rapors.id as rapor_id', 'rapors.rapor_dosya_yolu as rapor_dosya_yolu', 'rapors.rapor_sayi_turu as rapor_sayi_turu', 'rapors.rapor_gorulme_durumu as rapor_gorulme_durumu', 'rapors.rapor_onay_durumu as rapor_onay_durumu', 'rapors.proje_durumu as proje_durumu', 'rapors.ogrenci_id as rapor_ogrenci_id', 'rapors.danisman_id as rapor_danisman_id', 'rapors.proje_yil as rapor_proje_yil', 'rapors.proje_donem as rapor_proje_donem', 'rapors.created_at as rapor_created_at', 'rapors.updated_at as rapor_updated_at', 'users.name as danisman_ad', 'users.surname as danisman_soyad', 'users.email as danisman_email', 'users.phone_number as danisman_telefon_no', 'users.title as danisman_unvan', 'users.faculty as danisman_fakulte', 'users.department as danisman_bolum')->orderByDesc('rapor_updated_at')->get();
            $konu_onerisi_onay = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['konu_onay_durumu', '=', 'Onaylandı']])->exists();
            $rapor_onay = (6 == DB::table('rapors')->whereIn('rapor_sayi_turu', ['Rapor 1 DOC', 'Rapor 2 DOC', 'Rapor 3 DOC', 'Rapor 1 PDF', 'Rapor 2 PDF', 'Rapor 3 PDF'])->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['rapor_onay_durumu', '=', 'Onaylandı']])->count());
        }

        return view('ogrenci.raporlarim', ['raporlar' => $raporlar, 'konu_onerisi_onay' => $konu_onerisi_onay, 'sisteme_dahil' => $sisteme_dahil, 'rapor_onay' => $rapor_onay]);
    }

    public function raporlariYukleGet()
    {
        $sisteme_dahil = false;
        $konu_onerisi_onay = false;
        $rapor_onay = false;
        $rapor1doconayveyabekleme = false;
        $rapor1pdfonayveyabekleme = false;
        $rapor2doconayveyabekleme = false;
        $rapor2pdfonayveyabekleme = false;
        $rapor3doconayveyabekleme = false;
        $rapor3pdfonayveyabekleme = false;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $konu_onerisi_onay = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['konu_onay_durumu', '=', 'Onaylandı']])->exists();
            $rapor_onay = (6 == DB::table('rapors')->whereIn('rapor_sayi_turu', ['Rapor 1 DOC', 'Rapor 2 DOC', 'Rapor 3 DOC', 'Rapor 1 PDF', 'Rapor 2 PDF', 'Rapor 3 PDF'])->where([['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['rapor_onay_durumu', '=', 'Onaylandı']])->count());
            $rapor1doconayveyabekleme = DB::table('rapors')->whereIn('rapor_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['rapor_sayi_turu', '=', 'Rapor 1 DOC'], ['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $rapor1pdfonayveyabekleme = DB::table('rapors')->whereIn('rapor_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['rapor_sayi_turu', '=', 'Rapor 1 PDF'], ['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id],])->exists();
            $rapor2doconayveyabekleme = DB::table('rapors')->whereIn('rapor_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['rapor_sayi_turu', '=', 'Rapor 2 DOC'], ['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id],])->exists();
            $rapor2pdfonayveyabekleme = DB::table('rapors')->whereIn('rapor_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['rapor_sayi_turu', '=', 'Rapor 2 PDF'], ['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id],])->exists();
            $rapor3doconayveyabekleme = DB::table('rapors')->whereIn('rapor_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['rapor_sayi_turu', '=', 'Rapor 3 DOC'], ['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id],])->exists();
            $rapor3pdfonayveyabekleme = DB::table('rapors')->whereIn('rapor_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['rapor_sayi_turu', '=', 'Rapor 3 PDF'], ['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id],])->exists();
        }

        return view('ogrenci.raporlariyukle', ['konu_onerisi_onay' => $konu_onerisi_onay, 'sisteme_dahil' => $sisteme_dahil, 'rapor_onay' => $rapor_onay, 'rapor1doconayveyabekleme' => $rapor1doconayveyabekleme, 'rapor1pdfonayveyabekleme' => $rapor1pdfonayveyabekleme, 'rapor2doconayveyabekleme' => $rapor2doconayveyabekleme, 'rapor2pdfonayveyabekleme' => $rapor2pdfonayveyabekleme, 'rapor3doconayveyabekleme' => $rapor3doconayveyabekleme, 'rapor3pdfonayveyabekleme' => $rapor3pdfonayveyabekleme]);
    }

    public function raporlariYuklePost(Request $request)
    {
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);


            if ($request->has('rapor1doc')) {
                $request->validate([
                    'rapor1doc' => 'mimetypes:application/vnd.oasis.opendocument.text,application/octet-stream,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword'
                ]);


                $filename = date('dmYHi') . $request->rapor1doc->getClientOriginalName();
                $request->rapor1doc->move(public_path('raporlar'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('rapors')->insert([
                    'rapor_dosya_yolu' => $filename,
                    'rapor_sayi_turu' => 'Rapor 1 DOC',
                    'rapor_gorulme_durumu' => 'Görülmedi',
                    'rapor_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Rapor Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            if ($request->has('rapor1pdf')) {
                $request->validate([
                    'rapor1pdf' => 'mimes:pdf'
                ]);

                $filename = date('dmYHi') . $request->rapor1pdf->getClientOriginalName();
                $request->rapor1pdf->move(public_path('raporlar'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('rapors')->insert([
                    'rapor_dosya_yolu' => $filename,
                    'rapor_sayi_turu' => 'Rapor 1 PDF',
                    'rapor_gorulme_durumu' => 'Görülmedi',
                    'rapor_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Rapor Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            if ($request->has('rapor2doc')) {
                $request->validate([
                    'rapor2doc' => 'mimes:doc,docx,obt'
                ]);

                $filename = date('dmYHi') . $request->rapor2doc->getClientOriginalName();
                $request->rapor2doc->move(public_path('raporlar'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('rapors')->insert([
                    'rapor_dosya_yolu' => $filename,
                    'rapor_sayi_turu' => 'Rapor 2 DOC',
                    'rapor_gorulme_durumu' => 'Görülmedi',
                    'rapor_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Rapor Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            if ($request->has('rapor2pdf')) {
                $request->validate([
                    'rapor2pdf' => 'mimes:pdf'
                ]);

                $filename = date('dmYHi') . $request->rapor2pdf->getClientOriginalName();
                $request->rapor2pdf->move(public_path('raporlar'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('rapors')->insert([
                    'rapor_dosya_yolu' => $filename,
                    'rapor_sayi_turu' => 'Rapor 2 PDF',
                    'rapor_gorulme_durumu' => 'Görülmedi',
                    'rapor_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Rapor Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            if ($request->has('rapor3doc')) {
                $request->validate([
                    'rapor3doc' => 'mimes:doc,docx,obt'
                ]);

                $filename = date('dmYHi') . $request->rapor3doc->getClientOriginalName();
                $request->rapor3doc->move(public_path('raporlar'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('rapors')->insert([
                    'rapor_dosya_yolu' => $filename,
                    'rapor_sayi_turu' => 'Rapor 3 DOC',
                    'rapor_gorulme_durumu' => 'Görülmedi',
                    'rapor_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Rapor Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            if ($request->has('rapor3pdf')) {
                $request->validate([
                    'rapor3pdf' => 'mimes:pdf'
                ]);

                $filename = date('dmYHi') . $request->rapor3pdf->getClientOriginalName();
                $request->rapor3pdf->move(public_path('raporlar'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('rapors')->insert([
                    'rapor_dosya_yolu' => $filename,
                    'rapor_sayi_turu' => 'Rapor 3 PDF',
                    'rapor_gorulme_durumu' => 'Görülmedi',
                    'rapor_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Rapor Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }
        return redirect(route('ogrenci.raporlarget'));
    }

    public function tezlerGet()
    {
        $sisteme_dahil = false;
        $tezler = null;
        $konu_onerisi_onay = false;
        $rapor_onay = false;
        $tez_onay = false;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $tezler = DB::table('tezs')->join('users', function ($join) use ($aktif_yil_donem) {
                $join->on('tezs.danisman_id', '=', 'users.id')->where([['tezs.proje_yil', '=', $aktif_yil_donem->yil], ['tezs.proje_donem', '=', $aktif_yil_donem->donem], ['tezs.ogrenci_id', '=', auth()->user()->id]]);
            })->select('tezs.id as tez_id', 'tezs.tez_dosya_yolu as tez_dosya_yolu', 'tezs.tez_turu as tez_turu', 'tezs.tez_gorulme_durumu as tez_gorulme_durumu', 'tezs.tez_onay_durumu as tez_onay_durumu', 'tezs.proje_durumu as proje_durumu', 'tezs.ogrenci_id as tez_ogrenci_id', 'tezs.danisman_id as tez_danisman_id', 'tezs.proje_yil as tez_proje_yil', 'tezs.proje_donem as tez_proje_donem', 'tezs.created_at as tez_created_at', 'tezs.updated_at as tez_updated_at', 'users.name as danisman_ad', 'users.surname as danisman_soyad', 'users.email as danisman_email', 'users.phone_number as danisman_telefon_no', 'users.title as danisman_unvan', 'users.faculty as danisman_fakulte', 'users.department as danisman_bolum')->orderByDesc('tez_updated_at')->get();
            $konu_onerisi_onay = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['konu_onay_durumu', '=', 'Onaylandı']])->exists();
            $rapor_onay = (6 == DB::table('rapors')->whereIn('rapor_sayi_turu', ['Rapor 1 DOC', 'Rapor 2 DOC', 'Rapor 3 DOC', 'Rapor 1 PDF', 'Rapor 2 PDF', 'Rapor 3 PDF'])->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['rapor_onay_durumu', '=', 'Onaylandı']])->count());
            $tez_onay = (2 == DB::table('tezs')->whereIn('tez_turu', ['Tez DOC', 'Tez PDF'])->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['tez_onay_durumu', '=', 'Onaylandı']])->count());
        }

        return view('ogrenci.tezlerim', ['tezler' => $tezler, 'konu_onerisi_onay' => $konu_onerisi_onay, 'sisteme_dahil' => $sisteme_dahil, 'rapor_onay' => $rapor_onay, 'tez_onay' => $tez_onay]);
    }

    public function tezYukleGet()
    {
        $sisteme_dahil = false;
        $konu_onerisi_onay = false;
        $rapor_onay = false;
        $tez_onay = false;
        $tezdoconayveyabekleme = false;
        $tezpdfonayveyabekleme = false;

        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $konu_onerisi_onay = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['konu_onay_durumu', '=', 'Onaylandı']])->exists();
            $rapor_onay = (6 == DB::table('rapors')->whereIn('rapor_sayi_turu', ['Rapor 1 DOC', 'Rapor 2 DOC', 'Rapor 3 DOC', 'Rapor 1 PDF', 'Rapor 2 PDF', 'Rapor 3 PDF'])->where([['rapors.proje_yil', '=', $aktif_yil_donem->yil], ['rapors.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['rapor_onay_durumu', '=', 'Onaylandı']])->count());
            $tez_onay = (2 == DB::table('tezs')->whereIn('tez_turu', ['Tez DOC', 'Tez PDF'])->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id], ['tez_onay_durumu', '=', 'Onaylandı']])->count());
            $tezdoconayveyabekleme = DB::table('tezs')->whereIn('tez_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['tez_turu', '=', 'Tez DOC'], ['tezs.proje_yil', '=', $aktif_yil_donem->yil], ['tezs.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $tezpdfonayveyabekleme = DB::table('tezs')->whereIn('tez_onay_durumu', ['Onaylandı', 'Beklemede'])->where([['tez_turu', '=', 'Tez PDF'], ['tezs.proje_yil', '=', $aktif_yil_donem->yil], ['tezs.proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id],])->exists();
        }

        return view('ogrenci.tezyukle', ['konu_onerisi_onay' => $konu_onerisi_onay, 'sisteme_dahil' => $sisteme_dahil, 'rapor_onay' => $rapor_onay, 'tez_onay' => $tez_onay, 'tezdoconayveyabekleme' => $tezdoconayveyabekleme, 'tezpdfonayveyabekleme' => $tezpdfonayveyabekleme]);
    }

    public function tezYuklePost(Request $request)
    {
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);


            if ($request->has('tezdoc')) {
                $request->validate([
                    'tezdoc' => 'mimetypes:application/vnd.oasis.opendocument.text,application/octet-stream,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword'
                ]);


                $filename = date('dmYHi') . $request->tezdoc->getClientOriginalName();
                $request->tezdoc->move(public_path('tezler'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('tezs')->insert([
                    'tez_dosya_yolu' => $filename,
                    'tez_turu' => 'Tez DOC',
                    'tez_gorulme_durumu' => 'Görülmedi',
                    'tez_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Tez Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }

            if ($request->has('tezpdf')) {
                $request->validate([
                    'tezpdf' => 'mimes:pdf'
                ]);


                $filename = date('dmYHi') . $request->tezpdf->getClientOriginalName();
                $request->tezpdf->move(public_path('tezler'), $filename);

                $danisman_id = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->select('danisman_id')->first();
                DB::table('tezs')->insert([
                    'tez_dosya_yolu' => $filename,
                    'tez_turu' => 'Tez PDF',
                    'tez_gorulme_durumu' => 'Görülmedi',
                    'tez_onay_durumu' => 'Beklemede',
                    'proje_durumu' => 'Tez Onay Aşamasında',
                    'ogrenci_id' => auth()->user()->id,
                    'danisman_id' => $danisman_id->danisman_id,
                    'proje_yil' => $aktif_yil_donem->yil,
                    'proje_donem' => $aktif_yil_donem->donem,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);
            }
        }
        return redirect(route('ogrenci.tezlerget'));
    }

    public function benzerKonuOnerileriGet()
    {
        $sisteme_dahil = false;
        $benzer_konu_onerileri = null;
        if (AktifDonem::where('id', '=', 1)->exists()) {
            $aktif_yil_donem = AktifDonem::find(1);
            $sisteme_dahil = DB::table('konus')->where([['proje_yil', '=', $aktif_yil_donem->yil], ['proje_donem', '=', $aktif_yil_donem->donem], ['ogrenci_id', '=', auth()->user()->id]])->exists();
            $benzer_konu_onerileri = DB::table('benzer_konus')->join('konus as yeni_konus', function ($join) use ($aktif_yil_donem) {
                $join->on('benzer_konus.yeni_proje_id', '=', 'yeni_konus.id')->where([['benzer_konus.yil', '=', $aktif_yil_donem->yil], ['benzer_konus.donem', '=', $aktif_yil_donem->donem], ['benzer_konus.yeni_ogrenci_id', '=', auth()->user()->id]]);
            })->join('konus as eski_konus', function ($join) use ($aktif_yil_donem) {
                $join->on('benzer_konus.eski_proje_id', '=', 'eski_konus.id')->where([['benzer_konus.yil', '=', $aktif_yil_donem->yil], ['benzer_konus.donem', '=', $aktif_yil_donem->donem], ['benzer_konus.yeni_ogrenci_id', '=', auth()->user()->id]]);
            })->join('users as eski_danisman_users', function ($join) use ($aktif_yil_donem) {
                $join->on('benzer_konus.eski_danisman_id', '=', 'eski_danisman_users.id')->where([['benzer_konus.yil', '=', $aktif_yil_donem->yil], ['benzer_konus.donem', '=', $aktif_yil_donem->donem], ['benzer_konus.yeni_ogrenci_id', '=', auth()->user()->id]]);
            })->select('benzer_konus.id as benzer_konu_id', 'yeni_konus.proje_baslik as yeni_konu_proje_baslik', 'yeni_konus.proje_amac as yeni_konu_proje_amac', 'yeni_konus.proje_onem as yeni_konu_proje_onem', 'yeni_konus.proje_kapsam as yeni_konu_proje_kapsam', 'yeni_konus.proje_anahtar_kelimeler as yeni_konu_proje_anahtar_kelimeler', 'yeni_konus.proje_materyal as yeni_konu_proje_materyal', 'yeni_konus.proje_yontem as yeni_konu_proje_yontem', 'yeni_konus.proje_arastirma as yeni_konu_proje_arastirma', 'yeni_konus.konu_onay_durumu as yeni_konu_onay_durumu', 'yeni_konus.red_nedeni as yeni_konu_red_nedeni', 'yeni_konus.proje_durumu as yeni_konu_proje_durumu', 'yeni_konus.ogrenci_id as yeni_konu_ogrenci_id', 'yeni_konus.danisman_id as yeni_konu_danisman_id', 'yeni_konus.proje_yil as yeni_konu_proje_yil', 'yeni_konus.proje_donem as yeni_konu_proje_donem', 'yeni_konus.created_at as yeni_konu_created_at', 'yeni_konus.updated_at as yeni_konu_updated_at', 'eski_konus.proje_baslik as eski_konu_proje_baslik', 'eski_konus.proje_amac as eski_konu_proje_amac', 'eski_konus.proje_onem as eski_konu_proje_onem', 'eski_konus.proje_kapsam as eski_konu_proje_kapsam', 'eski_konus.proje_anahtar_kelimeler as eski_konu_proje_anahtar_kelimeler', 'eski_konus.proje_materyal as eski_konu_proje_materyal', 'eski_konus.proje_yontem as eski_konu_proje_yontem', 'eski_konus.proje_arastirma as eski_konu_proje_arastirma', 'eski_konus.konu_onay_durumu as eski_konu_onay_durumu', 'eski_konus.red_nedeni as eski_konu_red_nedeni', 'eski_konus.proje_durumu as eski_konu_proje_durumu', 'eski_konus.ogrenci_id as eski_konu_ogrenci_id', 'eski_konus.danisman_id as eski_konu_danisman_id', 'eski_konus.proje_yil as eski_konu_proje_yil', 'eski_konus.proje_donem as eski_konu_proje_donem', 'eski_konus.created_at as eski_konu_created_at', 'eski_konus.updated_at as eski_konu_updated_at', 'eski_danisman_users.name as danisman_ad', 'eski_danisman_users.surname as danisman_soyad', 'eski_danisman_users.email as danisman_email', 'eski_danisman_users.phone_number as danisman_telefon_no', 'eski_danisman_users.title as danisman_unvan', 'eski_danisman_users.faculty as danisman_fakulte', 'eski_danisman_users.department as danisman_bolum')->orderByDesc('yeni_konu_updated_at')->get();
        }

        return view('ogrenci.benzerkonular', ['benzer_konu_onerileri' => $benzer_konu_onerileri, 'sisteme_dahil' => $sisteme_dahil]);
    }
}
