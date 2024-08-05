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
    // Update informasi penjualan
    $penjualan->update([
        'tgl_penjualan' => $request->tgl_penjualan,
        'id_lokasi' => $request->id_lokasi,
        'id_pembeli' => $request->id_pembeli,
    ]);

    // Ambil detail penjualan dari request
    $details = $request->details;

    // Hapus detail penjualan yang ada
    $penjualan->detailPenjualan()->delete();

    foreach ($details as $detail) {
        // Pastikan key id_detail_penjualan ada
        $idDetailPenjualan = isset($detail['id_detail_penjualan']) ? $detail['id_detail_penjualan'] : null;

        if ($idDetailPenjualan) {
            // Cek jika detail penjualan sudah ada
            $existingDetail = DetailPenjualan::find($idDetailPenjualan);
            
            if ($existingDetail) {
                // Update stok lokasi untuk detail yang diupdate
                $stokLokasiOld = StokLokasi::where('id_sub_produk', $existingDetail->id_sub_produk)
                    ->where('id_lokasi', $penjualan->id_lokasi)
                    ->first();

                if ($stokLokasiOld) {
                    // Tambah stok lama untuk produk lama
                    $stokLokasiOld->jumlah_stok += $existingDetail->jumlah_brg;
                    $stokLokasiOld->save();
                }

                // Kurangi stok untuk produk baru
                $stokLokasiNew = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                    ->where('id_lokasi', $penjualan->id_lokasi)
                    ->first();

                if ($stokLokasiNew) {
                    $stokLokasiNew->jumlah_stok -= $detail['jumlah_brg'];
                    $stokLokasiNew->save();
                } else {
                    // Handle jika stok lokasi tidak ditemukan
                    // Misalnya, log atau tampilkan pesan kesalahan
                }

                // Update detail penjualan
                $existingDetail->update([
                    'id_sub_produk' => $detail['id_sub_produk'],
                    'jumlah_brg' => $detail['jumlah_brg'],
                    'harga_penjualan' => $detail['harga_penjualan'],
                ]);
            }
        } else {
            // Tambah detail baru
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id_penjualan,
                'id_sub_produk' => $detail['id_sub_produk'],
                'jumlah_brg' => $detail['jumlah_brg'],
                'harga_penjualan' => $detail['harga_penjualan'],
            ]);

            // Kurangi stok baru
            $stokLokasi = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                ->where('id_lokasi', $penjualan->id_lokasi)
                ->first();

            if ($stokLokasi) {
                $stokLokasi->jumlah_stok -= $detail['jumlah_brg'];
                $stokLokasi->save();
            } else {
                // Handle jika stok lokasi tidak ditemukan
                // Misalnya, log atau tampilkan pesan kesalahan
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
