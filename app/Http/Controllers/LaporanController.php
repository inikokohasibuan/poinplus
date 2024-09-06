<?php

namespace App\Http\Controllers;

use App\Models\PemindahanStok;
use Illuminate\Http\Request;
use App\Models\Penjualan; // Sesuaikan dengan model Anda
use App\Models\RecBrgMasuk;
use App\Models\Stok;
use App\Models\StokLokasi;

class LaporanController extends Controller
{
    public function penjualan()
    {
        $penjualans = Penjualan::all(); // Ambil data penjualan
        return view('laporan.penjualan', compact('penjualans'));
    }

    public function stok()
    {
        $stoks = StokLokasi::all(); // Ambil data stok
        return view('laporan.stok', compact('stoks'));
    }

    public function rec_brg_masuk()
    {
        $recBrgMasuk = RecBrgMasuk::with('lokasi')->get();
        return view('laporan.rec_brg_masuk', compact('recBrgMasuk'));
    }
    
    public function pemindahan_stok()
    {
        $pemindahanStok = PemindahanStok::all(); // Ambil data stok
        return view('laporan.pemindahan_stok', compact('pemindahanStok'));
    }
}
