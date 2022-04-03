<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SistemYoneticisiKullaniciController extends Controller
{
    public function index()
    {

        return view('sistemyoneticisi.kullanicilar', ['kullanicilar' => User::where('role', '<>', "Sistem Yöneticisi")->orderByDesc('updated_at')->get()]);
    }

    public function edit(User $user)
    {

        return view('sistemyoneticisi.kullaniciduzenle', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'image' => 'image'
        ]);

        $path=null;
        $imagename = null;
        if ($request->has('image')) {
            if (File::exists(public_path('images/profile_photos/' . $user->profile_photo))) {
                File::delete(public_path('images/profile_photos/' . $user->profile_photo));
            }
            $imagename = date('dmYHi') . $request->image->getClientOriginalName();
            //$request->image->move(public_path('images/profile_photos'), $imagename);
            $path = $request->file('avatar')->storeAs(
                'images/profile_photos/',
                $imagename,
                's3'
            );
        } else {
            $path = $user->profile_photo;
        }

        if ($request->role == "Öğrenci") {
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->profile_photo = $path;
            $user->phone_number = $request->phone_number;
            $user->faculty = $request->faculty;
            $user->department = $request->department;
            $user->year = $request->year;
            $user->student_id = $request->student_id;
            $user->updated_at = Carbon::now()->toDateTimeString();
        } else {
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->profile_photo = $path;
            $user->phone_number = $request->phone_number;
            $user->faculty = $request->faculty;
            $user->department = $request->department;
            $user->title = $request->title;
            $user->updated_at = Carbon::now()->toDateTimeString();
        }



        $user->save();

        return redirect(route('sistemyoneticisi.kullanicilarget'));
    }
}
