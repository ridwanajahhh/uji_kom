<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('toko', function (Blueprint $table) {
            $table->id('id_toko');
            $table->string('nama_toko', 100);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->foreignId('id_user')
                ->constrained('users', 'id_user')
                ->onDelete('cascade');
            $table->string('kontak_toko', 13)->nullable();
            $table->text('alamat')->nullable();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};
