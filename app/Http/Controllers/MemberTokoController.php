<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;

class MemberTokoController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware(function ($request, $next) {
    //         $user = Auth::user();
    //         if (!$user || $user->role !== 'member') {
    //             abort(403, 'Unauthorized');
    //         }
    //         return $next($request);
    //     });
    // }

    public function index()
    {
        $user = Auth::user();
        $toko = Toko::where('id_user', $user->id_user)->with('produk')->get();

        return view('member.toko.index', compact('toko'));
    }

    public function create()
    {
        return view('member.toko.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kontak_toko' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $data = [
            'nama_toko' => $request->nama_toko,
            'deskripsi' => $request->deskripsi,
            'kontak_toko' => $request->kontak_toko,
            'alamat' => $request->alamat,
            'id_user' => $user->id_user,
        ];

        if ($request->hasFile('gambar')) {
            $gambarName = time() . '_' . uniqid() . '.' . $request->file('gambar')->extension();
            $request->file('gambar')->move(public_path('storage/assets'), $gambarName);
            $data['gambar'] = $gambarName;
        }

        Toko::create($data);

        return redirect()->route('member.toko.index')->with('success', 'Toko berhasil ditambahkan!');
    }

    public function show($id)
    {
        $user = Auth::user();
        $toko = Toko::where('id_user', $user->id_user)->with('produk')->findOrFail($id);

        return view('member.toko.show', compact('toko'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $toko = Toko::where('id_user', $user->id_user)->findOrFail($id);

        return view('member.toko.edit', compact('toko'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $toko = Toko::where('id_user', $user->id_user)->findOrFail($id);

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kontak_toko' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama_toko' => $request->nama_toko,
            'deskripsi' => $request->deskripsi,
            'kontak_toko' => $request->kontak_toko,
            'alamat' => $request->alamat,
        ];

        // Upload dan hapus gambar lama jika ada
        if ($request->hasFile('gambar')) {
            if ($toko->gambar && file_exists(public_path('storage/assets/' . $toko->gambar))) {
                unlink(public_path('storage/assets/' . $toko->gambar));
            }

            $gambarName = time() . '_' . uniqid() . '.' . $request->file('gambar')->extension();
            $request->file('gambar')->move(public_path('storage/assets'), $gambarName);
            $data['gambar'] = $gambarName;
        }

        $toko->update($data);

        return redirect()->route('member.toko.index')->with('success', 'Toko berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $toko = Toko::where('id_user', $user->id_user)->findOrFail($id);

        // Hapus gambar jika ada
        if ($toko->gambar && file_exists(public_path('storage/assets/' . $toko->gambar))) {
            unlink(public_path('storage/assets/' . $toko->gambar));
        }

        $toko->delete();

        return redirect()->route('member.toko.index')->with('success', 'Toko berhasil dihapus!');
    }
}
