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
        Schema::create('pemindahan_stok', function (Blueprint $table) {
            $table->id('id_pemindahan_stok');
            $table->foreignId('id_sub_produk');
            $table->foreignId('id_lokasi_asal');
            $table->foreignId('id_lokasi_tujuan');
            $table->integer('jumlah_pindah')->default(0);
            $table->timestamp('waktu_pindah');
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
        Schema::dropIfExists('pemindahan_stok');
    }
};
