<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use Illuminate\Http\Request;

class DetailPenjualanController extends Controller
{
    public function index()
    {
        $detailPenjualan = DetailPenjualan::all();
        return view('detailPenjualan.index', compact('detailPenjualan'));
    }

    public function create()
    {
        return view('detailPenjualan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required',
            'id_sub_produk' => 'required',
            'harga_penjualan' => 'required',
        ]);

        DetailPenjualan::create($request->all());

        return redirect()->route('detailPenjualan.index')
                         ->with('success', 'Detail Penjualan berhasil ditambahkan.');
    }

    public function show(DetailPenjualan $detailPenjualan)
    {
        return view('detailPenjualan.show', compact('detailPenjualan'));
    }

    public function edit(DetailPenjualan $detailPenjualan)
    {
        return view('detailPenjualan.edit', compact('detailPenjualan'));
    }

    public function update(Request $request, DetailPenjualan $detailPenjualan)
    {
        $request->validate([
            'id_penjualan' => 'required',
            'id_sub_produk' => 'required',
            'harga_penjualan' => 'required',
        ]);

        $detailPenjualan->update($request->all());

        return redirect()->route('detailPenjualan.index')
                         ->with('success', 'Detail Penjualan berhasil diupdate.');
    }

    public function destroy(DetailPenjualan $detailPenjualan)
    {
        $detailPenjualan->delete();

        return redirect()->route('detailPenjualan.index')
                         ->with('success', 'Detail Penjualan berhasil dihapus.');
    }
}
