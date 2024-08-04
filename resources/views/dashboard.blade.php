@extends('layouts.default')

@section('page')
<h1 class="mb-4">Dashboard</h1>
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Total Produk</p>
                </div>
                <div class="icon">
                    <i class="fa fa-box"></i>
                </div>
                <a href="{{ route('master.produk.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalSales }}</h3>
                    <p>Total Penjualan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="{{ route('penjualan.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalStock }}</h3>
                    <p>Total Stok</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cube"></i>
                </div>
                <a href="{{ route('stok.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalPembeli }}</h3>
                    <p>Total Pembeli</p>
                </div>
                <div class="icon">
                    <i class="fa fa-truck"></i>
                </div>
                <a href="{{ route('master.pembeli.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
    </div>
</div>
@stop
