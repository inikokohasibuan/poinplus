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
        Schema::create('detail_brg_masuk', function (Blueprint $table) {
            $table->id('id_detail_brg_masuk');
            $table->foreignId('id_rec_brg_masuk');
            $table->foreignId('id_sub_produk');
            $table->integer('jumlah_brg_masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_brg_masuk');
    }
};
