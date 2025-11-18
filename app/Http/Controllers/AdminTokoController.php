<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Toko;
use App\Models\User;

class AdminTokoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $toko = Toko::with('user')->paginate(10);
        } else {
            $toko = Toko::where('id_user', $user->id_user)->with('user')->paginate(10);
        }

        return view('admin.toko.index', compact('toko', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        $users = User::where('role', 'member')->get(); // Only show members for admin

        return view('admin.toko.create', compact('user', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kontak_toko' => 'nullable|string|max:13',
            'alamat' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('assets', 'public');
            $data['gambar'] = basename($gambarPath);
        }

        $user = Auth::user();
        if ($user->role === 'admin') {
            $data['id_user'] = $request->id_user;
        } else {
            $data['id_user'] = $user->id_user;
        }

        Toko::create($data);

        return redirect()->route('admin.toko.index')->with('success', 'Toko berhasil ditambahkan');
    }

    public function show(Toko $toko)
    {
        $user = Auth::user();

        // Check if user can view this toko
        if ($user->role !== 'admin' && $toko->id_user !== $user->id_user) {
            abort(403);
        }

        $toko->load('user', 'produk.kategori');

        return view('admin.toko.show', compact('toko', 'user'));
    }

    public function edit(Toko $toko)
    {
        $user = Auth::user();

        // Check if user can edit this toko
        if ($user->role !== 'admin' && $toko->id_user !== $user->id_user) {
            abort(403);
        }

        $users = User::where('role', 'member')->get();

        return view('admin.toko.edit', compact('toko', 'user', 'users'));
    }

    public function update(Request $request, Toko $toko)
    {
        $user = Auth::user();

        // Check if user can update this toko
        if ($user->role !== 'admin' && $toko->id_user !== $user->id_user) {
            abort(403);
        }

        $request->validate([
            'nama_toko' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kontak_toko' => 'nullable|string|max:13',
            'alamat' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($toko->gambar && Storage::disk('public')->exists('assets/' . $toko->gambar)) {
                Storage::disk('public')->delete('assets/' . $toko->gambar);
            }

            $gambarPath = $request->file('gambar')->store('assets', 'public');
            $data['gambar'] = basename($gambarPath);
        }

        if ($user->role === 'admin') {
            $data['id_user'] = $request->id_user;
        }

        $toko->update($data);

        return redirect()->route('admin.toko.index')->with('success', 'Toko berhasil diperbarui');
    }

    public function destroy(Toko $toko)
    {
        $user = Auth::user();

        // Check if user can delete this toko
        if ($user->role !== 'admin' && $toko->id_user !== $user->id_user) {
            abort(403);
        }

        // Delete image if exists
        if ($toko->gambar && Storage::disk('public')->exists('assets/' . $toko->gambar)) {
            Storage::disk('public')->delete('assets/' . $toko->gambar);
        }

        $toko->delete();

        return redirect()->route('admin.toko.index')->with('success', 'Toko berhasil dihapus');
    }
}
