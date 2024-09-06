@extends('layouts.default')

@section('page')
<h1 class="mb-4">Laporan Barang Masuk</h1>
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
                    <th>No Nota Garansi</th>
                    <th>Tanggal Barang Masuk</th>
                    <th>Lokasi</th>
                    <th>Sub Produk</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recBrgMasuk as $item)
                @php
                $detailCount = count($item->detailBrgMasuk);
                @endphp
                @foreach($item->detailBrgMasuk as $index => $detail)
                <tr>
                    @if($index === 0)
                    <td rowspan="{{ $detailCount }}">{{ $item->no_nota_garansi }}</td>
                    <td rowspan="{{ $detailCount }}">{{ \Carbon\Carbon::parse($item->tgl_brg_masuk)->translatedFormat('d F Y') }}</td>
                    <td rowspan="{{ $detailCount }}">{{ $item->lokasi->nama_lokasi }}</td>
                    @endif
                    <td>{{ $detail->subProduk->produk->nama_produk }} {{ $detail->subProduk->produk->kategori->nama_kategori }} {{ $detail->subProduk->warna_produk }} {{ $detail->subProduk->size_produk }}</td>
                    <td>{{ $detail->jumlah_brg_masuk }}</td>
                </tr>
                @endforeach
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