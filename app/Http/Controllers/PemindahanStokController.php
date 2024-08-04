<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PemindahanStok;
use App\Models\Lokasi;
use App\Models\StokLokasi;
use App\Models\SubProduk;
use Illuminate\Support\Facades\DB;

class PemindahanStokController extends Controller
{
    public function index()
    {
        $pemindahanStok = PemindahanStok::with(['subProduk', 'lokasiAsal', 'lokasiTujuan'])->get();
        return view('pemindahan_stok.index', compact('pemindahanStok'));
    }

    public function create()
    {
        $lokasi = Lokasi::all();
        $subProduk = SubProduk::all();
        return view('pemindahan_stok.create', compact('lokasi', 'subProduk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_sub_produk' => 'required|exists:sub_produk,id_sub_produk',
            'id_lokasi_asal' => 'required|exists:lokasi,id_lokasi',
            'id_lokasi_tujuan' => 'required|exists:lokasi,id_lokasi',
            'jumlah_pindah' => 'required|integer|min:1',
        ]);

        $stokAsal = StokLokasi::where('id_sub_produk', $request->id_sub_produk)
                    ->where('id_lokasi', $request->id_lokasi_asal)
                    ->first();

        if (!$stokAsal || $stokAsal->jumlah_stok < $request->jumlah_pindah) {
            return redirect()->back()->withErrors('Stok asal tidak mencukupi atau tidak ada.');
        }

        DB::transaction(function () use ($request, $stokAsal) {
            $stokAsal->jumlah_stok -= $request->jumlah_pindah;
            $stokAsal->save();

            $stokTujuan = StokLokasi::firstOrNew([
                'id_sub_produk' => $request->id_sub_produk,
                'id_lokasi' => $request->id_lokasi_tujuan,
            ]);

            $stokTujuan->jumlah_stok += $request->jumlah_pindah;
            $stokTujuan->save();

            PemindahanStok::create([
                'id_sub_produk' => $request->id_sub_produk,
                'id_lokasi_asal' => $request->id_lokasi_asal,
                'id_lokasi_tujuan' => $request->id_lokasi_tujuan,
                'jumlah_pindah' => $request->jumlah_pindah,
                'waktu_pindah' => now(),
            ]);
        });

        return redirect()->route('pemindahan_stok.index')->with('success', 'Pemindahan stok berhasil.');
    }
}
