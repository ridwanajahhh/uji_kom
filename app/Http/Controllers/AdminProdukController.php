<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\Kategori;
use App\Models\GambarProduk;

class AdminProdukController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $produk = Produk::with(['toko', 'kategori', 'gambarProduk'])->paginate(12);
        } else {
            $produk = Produk::whereHas('toko', function($query) use ($user) {
                $query->where('id_user', $user->id_user);
            })->with(['toko', 'kategori', 'gambarProduk'])->paginate(12);
        }

        return view('admin.produk.index', compact('produk', 'user'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $toko = Toko::with('user')->get();
        } else {
            $toko = Toko::where('id_user', $user->id_user)->get();
        }

        $kategori = Kategori::all();

        return view('admin.produk.create', compact('user', 'toko', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'id_toko' => 'required|exists:toko,id_toko',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Check if user owns the toko (if not admin)
        if ($user->role !== 'admin') {
            $toko = Toko::find($request->id_toko);
            if ($toko->id_user !== $user->id_user) {
                abort(403);
            }
        }

        $produk = Produk::create($request->only(['nama_produk', 'harga', 'stok', 'deskripsi', 'id_toko', 'id_kategori']));

        // Handle multiple images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $gambarPath = $file->store('assets', 'public');
                GambarProduk::create([
                    'id_produk' => $produk->id_produk,
                    'nama_gambar' => basename($gambarPath),
                ]);
            }
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(Produk $produk)
    {
        $user = Auth::user();

        // Check if user can view this produk
        if ($user->role !== 'admin' && $produk->toko->id_user !== $user->id_user) {
            abort(403);
        }

        $produk->load('toko', 'kategori', 'gambarProduk');

        return view('admin.produk.show', compact('produk', 'user'));
    }

    public function edit(Produk $produk)
    {
        $user = Auth::user();

        // Check if user can edit this produk
        if ($user->role !== 'admin' && $produk->toko->id_user !== $user->id_user) {
            abort(403);
        }

        if ($user->role === 'admin') {
            $toko = Toko::with('user')->get();
        } else {
            $toko = Toko::where('id_user', $user->id_user)->get();
        }

        $kategori = Kategori::all();

        return view('admin.produk.edit', compact('produk', 'user', 'toko', 'kategori'));
    }

    public function update(Request $request, Produk $produk)
    {
        $user = Auth::user();

        // Check if user can update this produk
        if ($user->role !== 'admin' && $produk->toko->id_user !== $user->id_user) {
            abort(403);
        }

        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'id_toko' => 'required|exists:toko,id_toko',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if user owns the toko (if not admin)
        if ($user->role !== 'admin') {
            $toko = Toko::find($request->id_toko);
            if ($toko->id_user !== $user->id_user) {
                abort(403);
            }
        }

        $produk->update($request->only(['nama_produk', 'harga', 'stok', 'deskripsi', 'id_toko', 'id_kategori']));

        // Handle new images
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $gambarPath = $file->store('assets', 'public');
                GambarProduk::create([
                    'id_produk' => $produk->id_produk,
                    'nama_gambar' => basename($gambarPath),
                ]);
            }
        }

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Produk $produk)
    {
        $user = Auth::user();

        // Check if user can delete this produk
        if ($user->role !== 'admin' && $produk->toko->id_user !== $user->id_user) {
            abort(403);
        }

        // Delete images
        foreach ($produk->gambarProduk as $gambar) {
            if (Storage::disk('public')->exists('assets/' . $gambar->nama_gambar)) {
                Storage::disk('public')->delete('assets/' . $gambar->nama_gambar);
            }
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
    }

    public function deleteImage(GambarProduk $gambar)
    {
        $user = Auth::user();

        // Check if user can delete this image
        if ($user->role !== 'admin' && $gambar->produk->toko->id_user !== $user->id_user) {
            abort(403);
        }

        if (Storage::disk('public')->exists('assets/' . $gambar->nama_gambar)) {
            Storage::disk('public')->delete('assets/' . $gambar->nama_gambar);
        }

        $gambar->delete();

        return back()->with('success', 'Gambar berhasil dihapus');
    }
}
