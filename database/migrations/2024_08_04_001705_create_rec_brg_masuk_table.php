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
        Schema::create('rec_brg_masuk', function (Blueprint $table) {
            $table->id('id_rec_brg_masuk');
            $table->foreignId('id_lokasi');
            $table->string('no_nota_garansi');
            $table->timestamp('tgl_brg_masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rec_brg_masuk');
    }
};
