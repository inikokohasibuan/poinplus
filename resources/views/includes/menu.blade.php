<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel ml-4 pt-4 mt-3 pb-4 mb-4">
      <div class="info align-middle">
        <a href="#" class="text-lg"><b> Poin Plus</b></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{route('beranda')}}" class="nav-link @if(Route::current()->getName() == 'beranda') active @endif">
            <i class="nav-icon fas fa-home"></i>
            <p>Beranda</p>
          </a>
        </li>
        <li class="nav-item @if(str_contains(Route::current()->getPrefix(), 'master')) menu-open @endif">
          <a href="#" class="nav-link @if(str_contains(Route::current()->getPrefix(), 'master')) active @endif">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Master
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('master.kategori.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.kategori.index') active @endif">
                <i class="fas fa-tags nav-icon"></i>
                <p>Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.produk.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.produk.index') active @endif">
                <i class="fas fa-box nav-icon"></i>
                <p>Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.subproduk.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.subproduk.index') active @endif">
                <i class="fas fa-box-open nav-icon"></i>
                <p>Sub Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.lokasi.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.lokasi.index') active @endif">
                <i class="fas fa-map-marker-alt nav-icon"></i>
                <p>Lokasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.pembeli.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.pembeli.index') active @endif">
                <i class="fas fa-users nav-icon"></i>
                <p>Pembeli</p>
              </a>
            </li>
          </ul>
          <li class="nav-item">
              <a href="{{ route('rec_brg_masuk.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'rec_brg_masuk.index') active @endif">
                <i class="fas fa-truck-loading nav-icon"></i>
                <p>Barang Masuk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('penjualan.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'penjualan.index') active @endif">
                <i class="fas fa-shopping-cart nav-icon"></i>
                <p>Penjualan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('stok.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'stok.index') active @endif">
                <i class="fas fa-boxes nav-icon"></i>
                <p>Stok</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pemindahan_stok.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'pemindahan_stok.index') active @endif">
                <i class="fa-solid fa-exchange-alt nav-icon"></i>
                <p>Pemindahan Stok</p>
              </a>
            </li>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>