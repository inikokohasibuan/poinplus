@extends('layouts.default')

@section('page')
<h1 class="mb-4">Edit Penjualan</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('penjualan.update', $penjualan->id_penjualan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="tgl_penjualan">Tanggal Penjualan</label>
                <input type="date" name="tgl_penjualan" id="tgl_penjualan" class="form-control" value="{{ date('Y-m-d', strtotime($penjualan->tgl_penjualan)) }}" required>
            </div>
            <div class="form-group">
                <label for="id_lokasi">Lokasi</label>
                <select name="id_lokasi" id="id_lokasi" class="form-control" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasi as $item)
                        <option value="{{ $item->id_lokasi }}" {{ $item->id_lokasi == $penjualan->id_lokasi ? 'selected' : '' }}>{{ $item->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_pembeli">Pembeli</label>
                <select name="id_pembeli" id="id_pembeli" class="form-control">
                    <option value="">Pilih Pembeli</option>
                    @foreach($pembeli as $item)
                        <option value="{{ $item->id_pembeli }}" {{ $item->id_pembeli == $penjualan->id_pembeli ? 'selected' : '' }}>{{ $item->nama_pembeli }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="details">Detail Penjualan</label>
                <table class="table table-bordered" id="details">
                    <thead>
                        <tr>
                            <th>Sub Produk</th>
                            <th>Jumlah</th>
                            <th>Harga Pembelian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan->detailPenjualan as $index => $detail)
                            <tr>
                                <td>
                                    <select name="details[{{ $index }}][id_sub_produk]" class="form-control" required>
                                        <option value="">Pilih Sub Produk</option>
                                        @foreach($subProduk as $item)
                                            <option value="{{ $item->id_sub_produk }}" {{ $item->id_sub_produk == $detail->id_sub_produk ? 'selected' : '' }}>{{ $item->produk->nama_produk }} {{ $item->produk->kategori->nama_kategori }} {{ $item->warna_produk }} {{ $item->size_produk }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $index }}][jumlah_brg]" class="form-control" value="{{ $detail->jumlah_brg }}" required>
                                </td>
                                <td>
                                    <input type="number" name="details[{{ $index }}][harga_penjualan]" class="form-control" value="{{ $detail->harga_penjualan }}" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="button" class="btn btn-success btn-sm" id="add-detail">Tambah Detail</button>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let detailIndex = '{{ $penjualan->detailPenjualan->count() }}';
    document.getElementById('add-detail').addEventListener('click', function () {
        let newDetail = document.querySelector('#details tbody tr').cloneNode(true);
        newDetail.querySelectorAll('select, input').forEach(function (element) {
            let name = element.getAttribute('name');
            element.setAttribute('name', name.replace(/\d+/, detailIndex));
            element.value = ''; // Clear the value
        });
        newDetail.querySelector('.remove-detail').addEventListener('click', function () {
            this.closest('tr').remove();
        });
        document.querySelector('#details tbody').appendChild(newDetail);
        detailIndex++;
    });

    document.querySelectorAll('.remove-detail').forEach(function (button) {
        button.addEventListener('click', function () {
            this.closest('tr').remove();
        });
    });
});
</script>
@stop
