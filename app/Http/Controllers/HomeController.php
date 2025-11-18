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
        $kategori = Kategori::withCount('produk')->get();
        $toko = Toko::with('user')->get();
        $produk = Produk::with(['toko', 'kategori', 'gambarProduk'])->get();

        return view('welcome', compact('kategori', 'toko', 'produk'));
    }
}
