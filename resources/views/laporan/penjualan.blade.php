@extends('layouts.default')

@section('page')
<h1 class="mb-4">Laporan Penjualan</h1>
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

    .table th, .table td {
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
                    <th>ID</th>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualans as $penjualan)
                    @foreach($penjualan->detailPenjualan as $detail)
                        <tr>
                            <td>{{ $penjualan->id_penjualan }}</td>
                            <td> {{ $detail->subProduk->produk->nama_produk }} {{ $detail->subProduk->produk->kategori->nama_kategori }} {{ $detail->subProduk->warna_produk }} {{ $detail->subProduk->size_produk }}</td>
                            <td>{{ $detail->jumlah_brg }}</td>
                            <td>{{ number_format($detail->harga_penjualan, 2) }}</td>
                            <td>{{ Carbon\Carbon::parse($penjualan->tgl_penjualan)->format('d F Y') }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5">Data tidak tersedia</td>
                    </tr>
                @endforelse
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
