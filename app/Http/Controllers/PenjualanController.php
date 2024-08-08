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
        // Validasi input jika perlu
        $request->validate([
            'tgl_penjualan' => 'required|date',
            'id_lokasi' => 'required|exists:lokasi,id_lokasi',
            'id_pembeli' => 'nullable|exists:pembeli,id_pembeli',
            'details' => 'required|array',
            'details.*.id_sub_produk' => 'required|exists:sub_produk,id_sub_produk',
            'details.*.jumlah_brg' => 'required|integer|min:1',
            'details.*.harga_penjualan' => 'required|numeric|min:0',
        ]);

        // Simpan penjualan baru
        $penjualan = Penjualan::create($request->only(['tgl_penjualan', 'id_lokasi', 'id_pembeli']));

        // Ambil detail penjualan dari request
        $details = $request->details;

        foreach ($details as $detail) {
            // Tambah detail penjualan
            DetailPenjualan::create([
                'id_penjualan' => $penjualan->id_penjualan,
                'id_sub_produk' => $detail['id_sub_produk'],
                'jumlah_brg' => $detail['jumlah_brg'],
                'harga_penjualan' => $detail['harga_penjualan'],
            ]);

            // Update stok lokasi
            $stokLokasi = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                ->where('id_lokasi', $penjualan->id_lokasi)
                ->first();

            if ($stokLokasi) {
                $stokLokasi->jumlah_stok -= $detail['jumlah_brg'];
                $stokLokasi->save();
            } else {
                // Handle jika stok lokasi tidak ditemukan
                // Misalnya, buat stok lokasi baru atau log kesalahan
                // $stokLokasi = new StokLokasi([
                //     'id_sub_produk' => $detail['id_sub_produk'],
                //     'id_lokasi' => $penjualan->id_lokasi,
                //     'jumlah_stok' => -$detail['jumlah_brg'], // Inisialisasi dengan nilai negatif
                // ]);
                // $stokLokasi->save();
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

    public function update(Request $request, $id)
{
    $penjualan = Penjualan::findOrFail($id);
    $lokasiLama = $penjualan->id_lokasi; // Lokasi sebelum perubahan
    $lokasiBaru = $request->id_lokasi;

    // Loop through each detail
    foreach ($request->details as $detail) {
        $idSubProduk = $detail['id_sub_produk'];
        $jumlahBrg = $detail['jumlah_brg'];

        $detailPenjualan = DetailPenjualan::where('id_penjualan', $id)
                                          ->where('id_sub_produk', $idSubProduk)
                                          ->first();

        if ($detailPenjualan) {
            // Update stock di lokasi lama
            $stokLama = StokLokasi::where('id_lokasi', $lokasiLama)
                            ->where('id_sub_produk', $idSubProduk)
                            ->first();

            $stokBaru = StokLokasi::where('id_lokasi', $lokasiBaru)
                            ->where('id_sub_produk', $idSubProduk)
                            ->first();

            // Tambahkan kembali stok lama ke lokasi lama
            $stokLama->jumlah_stok += $detailPenjualan->jumlah_brg;
            $stokLama->save();

            // Kurangi stok dari lokasi baru
            $stokBaru->jumlah_stok -= $jumlahBrg;
            $stokBaru->save();

            // Update detail penjualan
            $detailPenjualan->jumlah_brg = $jumlahBrg;
            $detailPenjualan->harga_penjualan = $detail['harga_penjualan'];
            $detailPenjualan->save();
        } else {
            // Tambahkan stok di lokasi baru
            $stokBaru = StokLokasi::where('id_lokasi', $lokasiBaru)
                            ->where('id_sub_produk', $idSubProduk)
                            ->first();

            if ($stokBaru) {
                $stokBaru->jumlah_stok -= $jumlahBrg;
                $stokBaru->save();
            }

            // Tambahkan detail penjualan baru
            DetailPenjualan::create([
                'id_penjualan' => $id,
                'id_sub_produk' => $idSubProduk,
                'jumlah_brg' => $jumlahBrg,
                'harga_penjualan' => $detail['harga_penjualan'],
            ]);
        }
    }

    // Handle penghapusan detail penjualan yang tidak ada di request
    $existingDetails = DetailPenjualan::where('id_penjualan', $id)->get();

    foreach ($existingDetails as $existingDetail) {
        $found = false;

        foreach ($request->details as $detail) {
            if ($existingDetail->id_sub_produk == $detail['id_sub_produk']) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            // Kembalikan stok ke lokasi baru sebelum menghapus
            $stokBaru = StokLokasi::where('id_lokasi', $lokasiBaru)
                            ->where('id_sub_produk', $existingDetail->id_sub_produk)
                            ->first();

            if ($stokBaru) {
                $stokBaru->jumlah_stok += $existingDetail->jumlah_brg;
                $stokBaru->save();
            }

            // Hapus detail penjualan
            $existingDetail->delete();
        }
    }

    $penjualan->update($request->all());

    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui');
}


    public function destroy(Penjualan $penjualan)
    {
        foreach ($penjualan->detailPenjualan as $detail) {
            // Tambah stok lokasi sesuai dengan jumlah yang dijual
            $stokLokasi = StokLokasi::where('id_sub_produk', $detail->id_sub_produk)
                ->where('id_lokasi', $penjualan->id_lokasi)
                ->first();

            if ($stokLokasi) {
                $stokLokasi->jumlah_stok += $detail->jumlah_brg; // Update jumlah sesuai dengan jumlah barang
                $stokLokasi->save();
            } else {
                // Handle jika stok lokasi tidak ditemukan
                // Misalnya, log atau tampilkan pesan kesalahan
            }

            // Hapus detail penjualan
            $detail->delete();
        }

        // Hapus penjualan utama
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dihapus.');
    }


    // app/Http/Controllers/PenjualanController.php
    public function getSubProdukByLokasi($id_lokasi)
    {
        $subProduk = StokLokasi::where('id_lokasi', $id_lokasi)
            ->with(['subProduk.produk.kategori']) // Eager load kategori produk
            ->get()
            ->pluck('subProduk'); // Ambil subProduk dari stok lokasi

        return response()->json($subProduk);
    }
}
