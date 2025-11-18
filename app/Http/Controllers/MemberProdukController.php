<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\Kategori;
use App\Models\GambarProduk;

class MemberProdukController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware(function ($request, $next) {
    //         if (Auth::check() && Auth::user()->role !== 'member') {
    //             abort(403, 'Unauthorized');
    //         }
    //         return $next($request);
    //     });
    // }

    public function index()
    {
        $user = Auth::user();
        $produk = Produk::whereHas('toko', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->with(['toko', 'kategori', 'gambarProduk'])->get();

        return view('member.produk.index', compact('produk'));
    }

    public function create()
    {
        $user = Auth::user();
        $toko = Toko::where('id_user', $user->id_user)->get();
        $kategori = Kategori::all();

        return view('member.produk.create', compact('toko', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
            'deskripsi'     => 'nullable|string',
            'id_toko'       => 'required|exists:toko,id_toko',
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'gambar.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Pastikan toko milik user
        $toko = Toko::where('id_user', $user->id_user)
            ->findOrFail($request->id_toko);

        // Simpan produk
        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'id_toko'     => $toko->id_toko,
            'id_kategori' => $request->id_kategori,
        ]);

        // Upload multiple gambar
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('storage/assets'), $filename);

                GambarProduk::create([
                    'id_produk'   => $produk->id_produk,
                    'nama_gambar' => $filename,
                ]);
            }
        }

        return redirect()->route('member.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show($id)
    {
        $user = Auth::user();

        $produk = Produk::whereHas('toko', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->with(['toko', 'kategori', 'gambarProduk'])
          ->findOrFail($id);

        return view('member.produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $user = Auth::user();

        $produk = Produk::whereHas('toko', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->with(['toko', 'kategori', 'gambarProduk'])
          ->findOrFail($id);

        $toko = Toko::where('id_user', $user->id_user)->get();
        $kategori = Kategori::all();

        return view('member.produk.edit', compact('produk', 'toko', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $produk = Produk::whereHas('toko', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->findOrFail($id);

        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'harga'         => 'required|numeric|min:0',
            'stok'          => 'required|integer|min:0',
            'deskripsi'     => 'nullable|string',
            'id_toko'       => 'required|exists:toko,id_toko',
            'id_kategori'   => 'required|exists:kategori,id_kategori',
            'gambar.*'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $toko = Toko::where('id_user', $user->id_user)
            ->findOrFail($request->id_toko);

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'deskripsi'   => $request->deskripsi,
            'id_toko'     => $toko->id_toko,
            'id_kategori' => $request->id_kategori,
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('storage/assets'), $filename);

                GambarProduk::create([
                    'id_produk'   => $produk->id_produk,
                    'nama_gambar' => $filename,
                ]);
            }
        }

        return redirect()->route('member.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        $produk = Produk::whereHas('toko', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->with('gambarProduk')->findOrFail($id);

        // Hapus semua gambar
        foreach ($produk->gambarProduk as $gambar) {
            $path = storage_path('app/public/assets/' . $gambar->nama_gambar);
            if (file_exists($path)) {
                unlink($path);
            }
            $gambar->delete();
        }

        $produk->delete();

        return redirect()->route('member.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function deleteGambar($id)
    {
        $user = Auth::user();

        $gambar = GambarProduk::whereHas('produk.toko', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->findOrFail($id);

        $path = storage_path('app/public/assets/' . $gambar->nama_gambar);
        if (file_exists($path)) {
            unlink($path);
        }

        $gambar->delete();

        return response()->json(['success' => true]);
    }
}
