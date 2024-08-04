<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Pembeli;
use App\Models\SubProduk;
use App\Models\Lokasi;
use App\Models\StokLokasi;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['pembeli', 'lokasi'])->get();
        return view('penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $pembeli = Pembeli::all();
        $subProduk = SubProduk::all();
        $lokasi = Lokasi::all();
        return view('penjualan.create', compact('pembeli', 'subProduk', 'lokasi'));
    }

    public function store(Request $request)
    {
        $penjualan = Penjualan::create($request->all());
        $details = $request->details;

        foreach ($details as $detail) {
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id_penjualan,
                'id_sub_produk' => $detail['id_sub_produk'],
                'harga_penjualan' => $detail['harga_penjualan'],
            ]);

            // Update stok lokasi
            $stokLokasi = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                ->where('id_lokasi', $penjualan->id_lokasi)
                ->first();

            if ($stokLokasi) {
                $stokLokasi->jumlah_stok -= 1; // Asumsi jumlah penjualan hanya 1 per item
            } else {
                // Handle case if stok lokasi not found, maybe throw an error or ignore
            }
        }

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['pembeli', 'lokasi', 'detailPenjualan.subProduk'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with('detailPenjualan')->findOrFail($id);
        $pembeli = Pembeli::all();
        $subProduk = SubProduk::all();
        $lokasi = Lokasi::all();
        return view('penjualan.edit', compact('penjualan', 'pembeli', 'subProduk', 'lokasi'));
    }

    public function update(Request $request, Penjualan $penjualan)
    {
        $penjualan->update($request->all());
        $details = $request->details;

        foreach ($details as $detail) {
            $existingDetail = DetailPenjualan::find($detail['id_detail_penjualan']);
            if ($existingDetail) {
                // Update stok lokasi
                $stokLokasi = StokLokasi::where('id_sub_produk', $existingDetail->id_sub_produk)
                    ->where('id_lokasi', $penjualan->id_lokasi)
                    ->first();

                if ($stokLokasi) {
                    $stokLokasi->jumlah_stok += 1; // Tambah stok lama
                    $stokLokasi->jumlah_stok -= 1; // Kurangi stok baru
                    $stokLokasi->save();
                }

                // Update detail
                $existingDetail->update($detail);
            } else {
                // Tambah detail baru
                DetailPenjualan::create([
                    'id_penjualan' => $penjualan->id_penjualan,
                    'id_sub_produk' => $detail['id_sub_produk'],
                    'harga_penjualan' => $detail['harga_penjualan'],
                ]);

                // Kurangi stok baru
                $stokLokasi = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                    ->where('id_lokasi', $penjualan->id_lokasi)
                    ->first();

                if ($stokLokasi) {
                    $stokLokasi->jumlah_stok -= 1;
                } else {
                    // Handle case if stok lokasi not found, maybe throw an error or ignore
                }
            }
        }

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui.');
    }


    public function destroy(Penjualan $penjualan)
    {
        foreach ($penjualan->detailPenjualan as $detail) {
            // Tambah stok lokasi
            $stokLokasi = StokLokasi::where('id_sub_produk', $detail->id_sub_produk)
                ->where('id_lokasi', $penjualan->id_lokasi)
                ->first();

            if ($stokLokasi) {
                $stokLokasi->jumlah_stok += 1;
                $stokLokasi->save();
            }

            $detail->delete();
        }

        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus.');
    }
}
