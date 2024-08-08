@extends('layouts.default')

@section('page')
<h1 class="mb-4">Tambah Penjualan</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="tgl_penjualan">Tanggal Penjualan</label>
                <input type="date" name="tgl_penjualan" id="tgl_penjualan" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="id_lokasi">Lokasi</label>
                <select name="id_lokasi" id="id_lokasi" class="form-control" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasi as $item)
                    <option value="{{ $item->id_lokasi }}">{{ $item->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_pembeli">Pembeli</label>
                <select name="id_pembeli" id="id_pembeli" class="form-control">
                    <option value="">Pilih Pembeli</option>
                    @foreach($pembeli as $item)
                    <option value="{{ $item->id_pembeli }}">{{ $item->nama_pembeli }}</option>
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
        <th>Total</th> <!-- Kolom Total -->
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>
            <select name="details[0][id_sub_produk]" class="form-control sub-produk-select" required>
                <option value="">Pilih Sub Produk</option>
                @foreach($subProduk as $item)
                <option value="{{ $item->id_sub_produk }}" data-harga="{{ $item->harga_produk }}">
                    {{ $item->produk->nama_produk }} {{ $item->produk->kategori->nama_kategori }} {{ $item->warna_produk }} {{ $item->size_produk }}
                </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="number" name="details[0][jumlah_brg]" class="form-control jumlah-input" required>
        </td>
        <td>
            <input type="number" name="details[0][harga_penjualan]" class="form-control harga-input" required>
        </td>
        <td>
            <input type="number" class="form-control total-input" readonly> <!-- Kolom Total -->
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-detail">Hapus</button>
        </td>
    </tr>
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
    let detailIndex = 1;

    function updateTotal(row) {
        const jumlah = parseFloat(row.querySelector('.jumlah-input').value) || 0;
        const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
        const total = jumlah * harga;
        row.querySelector('.total-input').value = total.toFixed(2);
    }

    // Fungsi untuk memuat sub produk berdasarkan lokasi
    function loadSubProduk(idLokasi, selectElement) {
        fetch(`/sub-produk-by-lokasi/${idLokasi}`)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">Pilih Sub Produk</option>';
                data.forEach(subProduk => {
                    options += `<option value="${subProduk.id_sub_produk}" data-harga="${subProduk.harga_produk}">${subProduk.produk.nama_produk} ${subProduk.produk.kategori.nama_kategori} ${subProduk.warna_produk} ${subProduk.size_produk}</option>`;
                });
                selectElement.innerHTML = options;
            });
    }

    // Update harga dan total saat sub produk dipilih
    function updateHarga(e) {
        const selectedOption = e.target.options[e.target.selectedIndex];
        const hargaInput = e.target.closest('tr').querySelector('.harga-input');
        hargaInput.value = selectedOption.getAttribute('data-harga') || '';
        updateTotal(e.target.closest('tr'));
    }

    // Update total saat jumlah atau harga diubah
    document.querySelector('#details').addEventListener('input', function (e) {
        if (e.target.classList.contains('jumlah-input') || e.target.classList.contains('harga-input')) {
            updateTotal(e.target.closest('tr'));
        }
    });

    // Tambah detail baru
    document.getElementById('add-detail').addEventListener('click', function () {
        let newDetail = document.querySelector('#details tbody tr').cloneNode(true);
        newDetail.querySelectorAll('select, input').forEach(function (element) {
            let name = element.getAttribute('name');
            if (name) { // Periksa apakah atribut 'name' ada
                element.setAttribute('name', name.replace(/\d+/, detailIndex));
            }
            element.value = ''; // Clear the value
        });
        newDetail.querySelector('.remove-detail').addEventListener('click', function () {
            this.closest('tr').remove();
        });
        newDetail.querySelector('.sub-produk-select').addEventListener('change', updateHarga);
        document.querySelector('#details tbody').appendChild(newDetail);
        detailIndex++;
    });

    // Inisialisasi update harga dan total untuk detail yang sudah ada
    document.querySelectorAll('.sub-produk-select').forEach(select => select.addEventListener('change', updateHarga));

    document.querySelectorAll('.remove-detail').forEach(function (button) {
        button.addEventListener('click', function () {
            this.closest('tr').remove();
        });
    });
});


</script>

@stop