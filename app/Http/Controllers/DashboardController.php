<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;
use App\Models\Produk;
use App\Models\Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Jika user adalah admin, tampilkan semua data
        if ($user->role === 'admin') {
            $totalToko = Toko::count();
            $totalProduk = Produk::count();
            $totalKategori = Kategori::count();
            $toko = Toko::with('user')->get();
            $produk = Produk::with(['toko', 'kategori'])->get();
        } else {
            // Jika user adalah member, tampilkan data toko dan produk miliknya
            $toko = Toko::where('id_user', $user->id_user)->get();
            $produk = Produk::whereHas('toko', function($query) use ($user) {
                $query->where('id_user', $user->id_user);
            })->with(['toko', 'kategori'])->get();
            $totalToko = $toko->count();
            $totalProduk = $produk->count();
            $totalKategori = Kategori::count();
        }

        $kategori = Kategori::all();

        return view('dashboard', compact('user', 'totalToko', 'totalProduk', 'totalKategori', 'toko', 'produk', 'kategori'));
    }
}
