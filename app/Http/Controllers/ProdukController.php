<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        // Mengambil semua kategori untuk ditampilkan di dropdown
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    // Menyimpan produk baru ke database
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kategori_produk' => 'required|exists:kategori,id_kategori',
            'nama_produk' => 'required|string|max:255',
        ]);

        // Menyimpan produk baru
        Produk::create([
            'kategori_produk' => $request->kategori_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('master.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        // Mengambil produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Mengambil semua kategori untuk ditampilkan di dropdown
        $kategori = Kategori::all();

        return view('produk.edit', compact('produk', 'kategori'));
    }

    // Memperbarui produk yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kategori_produk' => 'required|exists:kategori,id_kategori',
            'nama_produk' => 'required|string|max:255',
        ]);

        // Mencari produk berdasarkan ID
        $produk = Produk::findOrFail($id);

        // Memperbarui data produk
        $produk->update([
            'kategori_produk' => $request->kategori_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        // Redirect ke halaman daftar produk dengan pesan sukses
        return redirect()->route('master.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('master.produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
