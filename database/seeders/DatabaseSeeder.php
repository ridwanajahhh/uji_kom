<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            [
                'nama' => 'Administrator',
                'kontak' => '081234567890',
                'username' => 'admin',
                'password' => Hash::make('123456'), // Password: 123456
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ridwan',
                'kontak' => '081298765432',
                'username' => 'ridwan',
                'password' => Hash::make('123456'),
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('kategori')->insert([
            [
                'nama_kategori' => 'Makanan & Minuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Alat Tulis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kerajinan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('toko')->insert([
            [
                'nama_toko' => 'Toko Ridwan',
                'deskripsi' => 'Toko yang menyediakan berbagai produk makanan dan minuman berkualitas',
                'kontak_toko' => '081298765432',
                'alamat' => 'Jl. Raya Tasikmalaya No. 123',
                'id_user' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('produk')->insert([
            [
                'nama_produk' => 'Chiki Twist',
                'harga' => 5000,
                'stok' => 100,
                'id_kategori' => 1,
                'id_toko' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Jetz Sweet Stick',
                'harga' => 3000,
                'stok' => 150,
                'id_kategori' => 1,
                'id_toko' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Teh Pucuk Harum',
                'harga' => 4000,
                'stok' => 200,
                'id_kategori' => 1,
                'id_toko' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_produk' => 'Pulpen Gel',
                'harga' => 2500,
                'stok' => 80,
                'id_kategori' => 2,
                'id_toko' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('gambar_produk')->insert([
            [
                'id_produk' => 1,
                'nama_gambar' => 'chiki.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => 2,
                'nama_gambar' => 'jetz.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => 3,
                'nama_gambar' => 'pucuk.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_produk' => 4,
                'nama_gambar' => 'pulpen.webp',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
