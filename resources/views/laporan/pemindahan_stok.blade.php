@extends('layouts.default')

@section('page')
<h1 class="mb-4">Laporan Stok</h1>
@stop

@section('content')
<style>
    /* Tambahkan ini di file CSS Anda */
    @media print {

        /* Sembunyikan elemen yang tidak perlu di cetak */
        .btn {
            display: none;
        }

        /* Atur margin dan padding agar tampilan lebih rapi */
        body {
            margin: 0;
            padding: 0;
        }

        .card {
            border: none;
        }

        .card-body {
            padding: 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
        }
    }
</style>
<div class="card">
    <div class="card-body">
        <button onclick="printReport()" class="btn btn-primary mb-3">Cetak Laporan</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sub Produk</th>
                    <th>Lokasi Asal</th>
                    <th>Lokasi Tujuan</th>
                    <th>Jumlah Pindah</th>
                    <th>Waktu Pindah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pemindahanStok as $pindah)
                <tr>
                    <td>{{ $pindah->subProduk->produk->nama_produk }} {{ $pindah->subProduk->warna_produk }} {{ $pindah->subProduk->size_produk }}</td>
                    <td>{{ $pindah->lokasiAsal->nama_lokasi }}</td>
                    <td>{{ $pindah->lokasiTujuan->nama_lokasi }}</td>
                    <td>{{ $pindah->jumlah_pindah }}</td>
                    <td>{{ Carbon\Carbon::parse($pindah->waktu_pindah)->format('d F Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function printReport() {
        window.print();
    }
</script>
@stop