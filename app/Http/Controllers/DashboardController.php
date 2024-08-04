<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\StokLokasi;
use App\Models\Pembeli;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalProducts = Produk::count();
        $totalSales = Penjualan::count();
        $totalStock = StokLokasi::sum('jumlah_stok');
        $totalPembeli = Pembeli::count();

        return view('dashboard', compact('totalProducts', 'totalSales', 'totalStock', 'totalPembeli'));
    }
}
