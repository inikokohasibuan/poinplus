<?php

namespace App\Http\Controllers;

use App\Models\RecBrgMasuk;
use App\Models\DetailBrgMasuk;
use App\Models\Lokasi;
use App\Models\SubProduk;
use App\Models\StokLokasi;
use Illuminate\Http\Request;

class RecBrgMasukController extends Controller
{
    public function index()
    {
        $recBrgMasuk = RecBrgMasuk::with('lokasi')->get();
        return view('rec_brg_masuk.index', compact('recBrgMasuk'));
    }

    public function create()
    {
        $lokasi = Lokasi::all();
        $subProduk = SubProduk::all();
        return view('rec_brg_masuk.create', compact('lokasi', 'subProduk'));
    }

    public function store(Request $request)
    {
        $recBrgMasuk = RecBrgMasuk::create($request->all());
        $details = $request->details;

        foreach ($details as $detail) {
            DetailBrgMasuk::create([
                'id_rec_brg_masuk' => $recBrgMasuk->id_rec_brg_masuk,
                'id_sub_produk' => $detail['id_sub_produk'],
                'jumlah_brg_masuk' => $detail['jumlah_brg_masuk'],
            ]);

            // Update stok lokasi
            $stokLokasi = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                ->where('id_lokasi', $recBrgMasuk->id_lokasi)
                ->first();

            if ($stokLokasi) {
                $stokLokasi->jumlah_stok += $detail['jumlah_brg_masuk'];
            } else {
                StokLokasi::create([
                    'id_sub_produk' => $detail['id_sub_produk'],
                    'id_lokasi' => $recBrgMasuk->id_lokasi,
                    'jumlah_stok' => $detail['jumlah_brg_masuk'],
                ]);
            }
        }

        return redirect()->route('rec_brg_masuk.index')->with('success', 'Record Barang Masuk berhasil ditambahkan.');
    }

    public function show(RecBrgMasuk $recBrgMasuk)
    {
        $recBrgMasuk->load('lokasi', 'detailBrgMasuk.subProduk');
        return view('rec_brg_masuk.show', compact('recBrgMasuk'));
    }

    public function edit(RecBrgMasuk $recBrgMasuk)
    {
        $lokasi = Lokasi::all();
        $subProduk = SubProduk::all();
        $recBrgMasuk->load('detailBrgMasuk');
        return view('rec_brg_masuk.edit', compact('recBrgMasuk', 'lokasi', 'subProduk'));
    }

    public function update(Request $request, RecBrgMasuk $recBrgMasuk)
    {
        $recBrgMasuk->update($request->all());
        $details = $request->details;

        foreach ($details as $detail) {
            $existingDetail = DetailBrgMasuk::find($detail['id_detail_brg_masuk']);
            if ($existingDetail) {
                // Update stok lokasi
                $stokLokasi = StokLokasi::where('id_sub_produk', $existingDetail->id_sub_produk)
                    ->where('id_lokasi', $recBrgMasuk->id_lokasi)
                    ->first();

                if ($stokLokasi) {
                    $stokLokasi->jumlah_stok -= $existingDetail->jumlah_brg_masuk; // Kurangi stok lama
                    $stokLokasi->jumlah_stok += $detail['jumlah_brg_masuk']; // Tambah stok baru
                    $stokLokasi->save();
                }

                // Update detail
                $existingDetail->update($detail);
            } else {
                // Tambah detail baru
                DetailBrgMasuk::create([
                    'id_rec_brg_masuk' => $recBrgMasuk->id_rec_brg_masuk,
                    'id_sub_produk' => $detail['id_sub_produk'],
                    'jumlah_brg_masuk' => $detail['jumlah_brg_masuk'],
                ]);

                // Tambah stok baru
                $stokLokasi = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                    ->where('id_lokasi', $recBrgMasuk->id_lokasi)
                    ->first();

                if ($stokLokasi) {
                    $stokLokasi->jumlah_stok += $detail['jumlah_brg_masuk'];
                } else {
                    StokLokasi::create([
                        'id_sub_produk' => $detail['id_sub_produk'],
                        'id_lokasi' => $recBrgMasuk->id_lokasi,
                        'jumlah_stok' => $detail['jumlah_brg_masuk'],
                    ]);
                }
            }
        }

        return redirect()->route('rec_brg_masuk.index')->with('success', 'Record Barang Masuk berhasil diperbarui.');
    }


    public function destroy(RecBrgMasuk $recBrgMasuk)
    {
        foreach ($recBrgMasuk->detailBrgMasuk as $detail) {
            // Kurangi stok lokasi
            $stokLokasi = StokLokasi::where('id_sub_produk', $detail->id_sub_produk)
                ->where('id_lokasi', $recBrgMasuk->id_lokasi)
                ->first();

            if ($stokLokasi) {
                $stokLokasi->jumlah_stok -= $detail->jumlah_brg_masuk;
                $stokLokasi->save();
            }

            $detail->delete();
        }

        $recBrgMasuk->delete();

        return redirect()->route('rec_brg_masuk.index')->with('success', 'Record Barang Masuk berhasil dihapus.');
    }
}
