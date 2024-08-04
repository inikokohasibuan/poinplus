<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_produk', function (Blueprint $table) {
            $table->id('id_sub_produk');
            $table->string('warna_produk');
            $table->string('size_produk');
            $table->decimal('harga_produk', 10, 2);
            $table->foreignId('id_produk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_produk');
    }
};
