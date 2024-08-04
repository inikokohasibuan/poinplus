<?php

namespace App\Http\Controllers;

use App\Models\StokLokasi;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index()
    {
        // Ambil semua data stok lokasi
        $stokLokasi = StokLokasi::with(['subProduk', 'lokasi'])->get();

        // Kirim data ke view
        return view('stok.index', compact('stokLokasi'));
    }
}
