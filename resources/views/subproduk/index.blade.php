@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Sub Produk</h1>
<a href="{{ route('master.subproduk.create') }}" class="btn btn-primary mb-3">Tambah Sub Produk</a>

<form method="GET" action="{{ route('master.subproduk.index') }}" class="mb-4">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="produk">Produk</label>
            <select name="produk" id="produk" class="form-control">
                <option value="">Semua Produk</option>
                @foreach($produkList as $produkItem)
                    <option value="{{ $produkItem->id_produk }}" {{ request()->get('produk') == $produkItem->id_produk ? 'selected' : '' }}>{{ $produkItem->nama_produk }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="kategori">Kategori</label>
            <select name="kategori" id="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kategoriItem)
                    <option value="{{ $kategoriItem->id_kategori }}" {{ request()->get('kategori') == $kategoriItem->id_kategori ? 'selected' : '' }}>{{ $kategoriItem->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Warna</th>
                    <th>Size</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subproduk as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>{{ $item->warna_produk }}</td>
                    <td>{{ $item->size_produk }}</td>
                    <td>Rp{{ number_format($item->harga_produk, 2) }}</td>
                    <td>
                        <a href="{{ route('master.subproduk.edit', $item->id_sub_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('master.subproduk.copy', $item->id_sub_produk) }}" class="btn btn-info btn-sm">Copy</a>
                        <form action="{{ route('master.subproduk.destroy', $item->id_sub_produk) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus sub produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data sub produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
