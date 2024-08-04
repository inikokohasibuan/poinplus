<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\SubProduk;
use Illuminate\Http\Request;

class SubProdukController extends Controller
{
    public function index(Request $request)
    {
        $produkList = Produk::all();
        $kategoriList = Kategori::all();
        $subproduk = SubProduk::query();

        if ($request->filled('produk')) {
            $subproduk->where('id_produk', $request->produk);
        }

        if ($request->filled('kategori')) {
            $subproduk->whereHas('produk', function ($query) use ($request) {
                $query->where('kategori_produk', $request->kategori);
            });
        }

        $subproduk = $subproduk->get();

        return view('subproduk.index', compact('subproduk', 'produkList', 'kategoriList'));
    }


    public function create()
    {
        $produk = Produk::all();
        return view('subproduk.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required',
            'warna_produk' => 'required',
            'size_produk' => 'required',
            'harga_produk' => 'required|numeric',
        ]);

        SubProduk::create($request->all());
        return redirect()->route('master.subproduk.index')->with('success', 'Sub Produk berhasil ditambahkan.');
    }

    public function copy($id)
    {
        $produk = Produk::all();
        $subproduk = SubProduk::findOrFail($id);
        return view('subproduk.create', compact('produk', 'subproduk'));
    }

    public function edit(SubProduk $subproduk)
    {
        $produk = Produk::all();
        return view('subproduk.edit', compact('subproduk', 'produk'));
    }

    public function update(Request $request, SubProduk $subproduk)
    {
        $request->validate([
            'id_produk' => 'required',
            'warna_produk' => 'required',
            'size_produk' => 'required',
            'harga_produk' => 'required|numeric',
        ]);

        $subproduk->update($request->all());
        return redirect()->route('master.subproduk.index')->with('success', 'Sub Produk berhasil diperbarui.');
    }

    public function destroy(SubProduk $subproduk)
    {
        $subproduk->delete();
        return redirect()->route('master.subproduk.index')->with('success', 'Sub Produk berhasil dihapus.');
    }
}
