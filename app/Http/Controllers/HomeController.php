<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Kategori;

class HomeController extends Controller
{
    public function index()
    {
        $search = request('search');
        $kategori = Kategori::withCount('produk')->get();
        $toko = Toko::with('user')->get();

        if ($search) {
            $produk = Produk::with(['toko', 'kategori', 'gambarProduk'])
                ->where('nama_produk', 'LIKE', '%' . $search . '%')
                ->get();
        } else {
            $produk = Produk::with(['toko', 'kategori', 'gambarProduk'])->get();
        }

        return view('welcome', compact('kategori', 'toko', 'produk', 'search'));
    }

    public function produk()
    {
        $search = request('search');
        $kategori = Kategori::withCount('produk')->get();

        if ($search) {
            $produk = Produk::with(['toko', 'kategori', 'gambarProduk'])
                ->where('nama_produk', 'LIKE', '%' . $search . '%')
                ->paginate(12);
        } else {
            $produk = Produk::with(['toko', 'kategori', 'gambarProduk'])->paginate(12);
        }

        return view('produk', compact('produk', 'kategori', 'search'));
    }
}
