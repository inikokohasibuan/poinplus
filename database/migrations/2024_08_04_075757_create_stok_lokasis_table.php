<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stok_lokasi', function (Blueprint $table) {
            $table->id('id_stok_lokasi');
            $table->foreignId('id_sub_produk');
            $table->foreignId('id_lokasi');
            $table->integer('jumlah_stok')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_lokasi');
    }
};
