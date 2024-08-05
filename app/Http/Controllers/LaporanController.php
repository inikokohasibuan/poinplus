<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan; // Sesuaikan dengan model Anda
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
}
