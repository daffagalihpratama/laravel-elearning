<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // TAMPILKAN DATA
    public function index()
    {
        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('admin.users.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/admin/users')
            ->with('success', 'User berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect('/admin/users')
            ->with('success', 'User berhasil diupdate');
    }

    // DELETE
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('/admin/users')
            ->with('success', 'User berhasil dihapus');
    }
}
