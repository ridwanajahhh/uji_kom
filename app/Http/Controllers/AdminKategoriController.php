<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;

class AdminKategoriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $kategori = Kategori::paginate(10);

        return view('admin.kategori.index', compact('kategori', 'user'));
    }

    public function create()
    {
        $user = Auth::user();

        return view('admin.kategori.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
        ]);

        Kategori::create($request->only(['nama_kategori']));

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show(Kategori $kategori)
    {
        $user = Auth::user();
        $kategori->load('produk.toko');

        return view('admin.kategori.show', compact('kategori', 'user'));
    }

    public function edit(Kategori $kategori)
    {
        $user = Auth::user();

        return view('admin.kategori.edit', compact('kategori', 'user'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $kategori->id_kategori . ',id_kategori',
        ]);

        $kategori->update($request->only(['nama_kategori']));

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Kategori $kategori)
    {
        // Check if kategori has products
        if ($kategori->produk()->count() > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
