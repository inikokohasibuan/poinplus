@extends('layouts.default')

@section('page')
<h1 class="mb-4">Edit Record Barang Masuk</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('rec_brg_masuk.update', $recBrgMasuk->id_rec_brg_masuk) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="no_nota_garansi">No Nota Garansi</label>
                <input type="text" name="no_nota_garansi" id="no_nota_garansi" class="form-control" value="{{ $recBrgMasuk->no_nota_garansi }}" required>
            </div>
            <div class="form-group">
                <label for="tgl_brg_masuk">Tanggal Barang Masuk</label>
                <input type="date" name="tgl_brg_masuk" id="tgl_brg_masuk" class="form-control" value="{{date('Y-m-d', strtotime($recBrgMasuk->tgl_brg_masuk))}}" required>
            </div>
            <div class="form-group">
                <label for="id_lokasi">Lokasi</label>
                <select name="id_lokasi" id="id_lokasi" class="form-control" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasi as $item)
                        <option value="{{ $item->id_lokasi }}" {{ $item->id_lokasi == $recBrgMasuk->id_lokasi ? 'selected' : '' }}>{{ $item->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="details">Detail Barang Masuk</label>
                <table class="table table-bordered" id="details">
                    <thead>
                        <tr>
                            <th>Sub Produk</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recBrgMasuk->detailBrgMasuk as $index => $detail)
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
                                <input type="number" name="details[{{ $index }}][jumlah_brg_masuk]" class="form-control" value="{{ $detail->jumlah_brg_masuk }}" required>
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
    let detailIndex = '{{ $recBrgMasuk->detailBrgMasuk->count() }}';
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
