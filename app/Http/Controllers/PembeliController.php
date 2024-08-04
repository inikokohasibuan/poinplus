<?php

namespace App\Http\Controllers;

use App\Models\Pembeli;
use Illuminate\Http\Request;

class PembeliController extends Controller
{
    public function index()
    {
        $pembeli = Pembeli::all();
        return view('pembeli.index', compact('pembeli'));
    }

    public function create()
    {
        return view('pembeli.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'alamat_pembeli' => 'required|string',
        ]);

        Pembeli::create($request->all());

        return redirect()->route('master.pembeli.index')->with('success', 'Pembeli berhasil ditambahkan.');
    }

    public function edit(Pembeli $pembeli)
    {
        return view('pembeli.edit', compact('pembeli'));
    }

    public function update(Request $request, Pembeli $pembeli)
    {
        $request->validate([
            'nama_pembeli' => 'required|string|max:255',
            'alamat_pembeli' => 'required|string',
        ]);

        $pembeli->update($request->all());

        return redirect()->route('master.pembeli.index')->with('success', 'Pembeli berhasil diperbarui.');
    }

    public function destroy(Pembeli $pembeli)
    {
        $pembeli->delete();
        return redirect()->route('master.pembeli.index')->with('success', 'Pembeli berhasil dihapus.');
    }
}
