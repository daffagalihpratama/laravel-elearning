<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    // ✅ INI YANG KURANG
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalExtension();

        $file->move(public_path('uploads'), $filename);

        $user->photo = $filename;
        $user->save();

        return back()->with('success', 'Foto berhasil diupdate');
    }
}
