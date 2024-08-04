<?php

namespace App\Http\Controllers;

use App\Models\DetailBrgMasuk;
use Illuminate\Http\Request;

class DetailBrgMasukController extends Controller
{
    public function index()
    {
        $detailBrgMasuk = DetailBrgMasuk::all();
        return view('detailBrgMasuk.index', compact('detailBrgMasuk'));
    }

    public function create()
    {
        return view('detailBrgMasuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_rec_brg_masuk' => 'required',
            'id_sub_produk' => 'required',
            'jumlah_barang_masuk' => 'required',
        ]);

        DetailBrgMasuk::create($request->all());

        return redirect()->route('detailBrgMasuk.index')
                         ->with('success', 'Detail Barang Masuk berhasil ditambahkan.');
    }

    public function show(DetailBrgMasuk $detailBrgMasuk)
    {
        return view('detailBrgMasuk.show', compact('detailBrgMasuk'));
    }

    public function edit(DetailBrgMasuk $detailBrgMasuk)
    {
        return view('detailBrgMasuk.edit', compact('detailBrgMasuk'));
    }

    public function update(Request $request, DetailBrgMasuk $detailBrgMasuk)
    {
        $request->validate([
            'id_rec_brg_masuk' => 'required',
            'id_sub_produk' => 'required',
            'jumlah_barang_masuk' => 'required',
        ]);

        $detailBrgMasuk->update($request->all());

        return redirect()->route('detailBrgMasuk.index')
                         ->with('success', 'Detail Barang Masuk berhasil diupdate.');
    }

    public function destroy(DetailBrgMasuk $detailBrgMasuk)
    {
        $detailBrgMasuk->delete();

        return redirect()->route('detailBrgMasuk.index')
                         ->with('success', 'Detail Barang Masuk berhasil dihapus.');
    }
}
