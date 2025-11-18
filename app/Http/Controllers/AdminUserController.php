<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id_user', 'desc')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'kontak' => 'required|string|max:13',
            'username' => 'required|string|max:20|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,member',
        ]);

        User::create([
            'nama'      => $request->nama,
            'kontak'    => $request->kontak,
            'username'  => $request->username,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'kontak'    => 'required|string|max:13',
            'username'  => 'required|string|max:20|unique:users,username,' . $user->id_user . ',id_user',
            'password'  => 'nullable|string|min:6',
            'role'      => 'required|in:admin,member',
        ]);

        $data = [
            'nama'      => $request->nama,
            'kontak'    => $request->kontak,
            'username'  => $request->username,
            'role'      => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id_user)
    {
        $user = User::findOrFail($id_user);

        // pastikan ada user login
        if (!auth()->check()) {
            return back()->with('error', 'Anda harus login untuk menghapus user');
        }

        // cegah hapus diri sendiri
        if ($user->id_user == auth()->user()->id_user) {
            return back()->with('error', 'Tidak dapat menghapus user yang sedang login');
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
