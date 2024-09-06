<?php

namespace App\Http\Controllers;

use App\Models\RecBrgMasuk;
use App\Models\DetailBrgMasuk;
use App\Models\Lokasi;
use App\Models\SubProduk;
use App\Models\StokLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecBrgMasukController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->level === 'penjaga_toko') {
            $recBrgMasuk = RecBrgMasuk::where('id_lokasi', $user->id_lokasi)->with('lokasi')->get();
        } else {
            $recBrgMasuk = RecBrgMasuk::with('lokasi')->get();
        }

        return view('rec_brg_masuk.index', compact('recBrgMasuk'));
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->level === 'penjaga_toko') {
            $lokasi = Lokasi::where('id_lokasi', $user->id_lokasi)->get();
        } else {
            $lokasi = Lokasi::all();
        }
        $subProduk = SubProduk::all();
        return view('rec_brg_masuk.create', compact('lokasi', 'subProduk'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
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
                    $stokLokasi->save();
                } else {
                    StokLokasi::create([
                        'id_sub_produk' => $detail['id_sub_produk'],
                        'id_lokasi' => $recBrgMasuk->id_lokasi,
                        'jumlah_stok' => $detail['jumlah_brg_masuk'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('rec_brg_masuk.index')->with('success', 'Record Barang Masuk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show(RecBrgMasuk $recBrgMasuk)
    {
        $recBrgMasuk->load('lokasi', 'detailBrgMasuk.subProduk');
        return view('rec_brg_masuk.show', compact('recBrgMasuk'));
    }

    public function edit(RecBrgMasuk $recBrgMasuk)
    {
        $user = auth()->user();
        if ($user->level === 'penjaga_toko') {
            $lokasi = Lokasi::where('id_lokasi', $user->id_lokasi)->get();
        } else {
            $lokasi = Lokasi::all();
        }
        $subProduk = SubProduk::all();
        $recBrgMasuk->load('detailBrgMasuk');
        return view('rec_brg_masuk.edit', compact('recBrgMasuk', 'lokasi', 'subProduk'));
    }

    public function update(Request $request, RecBrgMasuk $recBrgMasuk)
    {

        DB::beginTransaction();
        try {
            // Update RecBrgMasuk
            $recBrgMasuk->update($request->all());
            $details = $request->details;

            $oldDetail = DetailBrgMasuk::where('id_rec_brg_masuk', $recBrgMasuk['id_rec_brg_masuk'])
                ->pluck('id_detail_brg_masuk')
                ->toArray();

            foreach ($details as $detail) {
                $existingDetail = DetailBrgMasuk::where('id_rec_brg_masuk', $recBrgMasuk['id_rec_brg_masuk'])->where('id_sub_produk', $detail['id_sub_produk'])->first();
                if ($existingDetail) {
                    $key = array_search($existingDetail['id_detail_brg_masuk'], $oldDetail);
                    if ($key !== false) {
                        unset($oldDetail[$key]);
                    }

                    // Re-index array to avoid gaps in the keys
                    $oldDetail = array_values($oldDetail);

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
                    // Tambah detail barus
                    DetailBrgMasuk::create([
                        'id_rec_brg_masuk' => $recBrgMasuk['id_rec_brg_masuk'],
                        'id_sub_produk' => $detail['id_sub_produk'],
                        'jumlah_brg_masuk' => $detail['jumlah_brg_masuk'],
                    ]);

                    // Tambah stok baru
                    $stokLokasi = StokLokasi::where('id_sub_produk', $detail['id_sub_produk'])
                        ->where('id_lokasi', $recBrgMasuk->id_lokasi)
                        ->first();

                    if ($stokLokasi) {
                        $stokLokasi->jumlah_stok += $detail['jumlah_brg_masuk'];
                        $stokLokasi->save();
                    } else {
                        StokLokasi::create([
                            'id_sub_produk' => $detail['id_sub_produk'],
                            'id_lokasi' => $recBrgMasuk->id_lokasi,
                            'jumlah_stok' => $detail['jumlah_brg_masuk'],
                        ]);
                    }
                }
            }
            
            foreach ($oldDetail as $key => $value) {
                $detailForDelete = DetailBrgMasuk::where('id_detail_brg_masuk', $value)->first();
                $stokLokasi = StokLokasi::where('id_sub_produk', $detailForDelete['id_sub_produk'])
                        ->where('id_lokasi', $recBrgMasuk->id_lokasi)
                        ->first();
                        $stokLokasi->jumlah_stok -= $detail['jumlah_brg_masuk'];
                        $stokLokasi->save();
                $detailForDelete->delete();
            }

            DB::commit();
            return redirect()->route('rec_brg_masuk.index')->with('success', 'Record Barang Masuk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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
