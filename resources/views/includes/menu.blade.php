<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <div class="sidebar">
    <div class="user-panel ml-4 pt-4 mt-3 pb-4 mb-4">
      <div class="info align-middle">
        <a href="#" class="text-lg"><b> Poin Plus</b></a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link @if(Route::current()->getName() == 'dashboard') active @endif">
            <i class="nav-icon fa-solid fa-house"></i>
            <p>Beranda</p>
          </a>
        </li>
        @auth
        @if(Auth::user()->level == 'admin')
        <li class="nav-item @if(str_contains(Route::current()->getPrefix(), 'master')) menu-open @endif">
          <a href="#" class="nav-link @if(str_contains(Route::current()->getPrefix(), 'master')) active @endif">
            <i class="nav-icon fa-solid fa-cogs"></i>
            <p>Master<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('master.kategori.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.kategori.index') active @endif">
                <i class="fa-solid fa-tag nav-icon"></i>
                <p>Kategori</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.produk.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.produk.index') active @endif">
                <i class="fa-solid fa-box nav-icon"></i>
                <p>Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.subproduk.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.subproduk.index') active @endif">
                <i class="fa-solid fa-boxes nav-icon"></i>
                <p>Sub Produk</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.lokasi.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.lokasi.index') active @endif">
                <i class="fa-solid fa-location-dot nav-icon"></i>
                <p>Lokasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('master.pembeli.index') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'master.pembeli.index') active @endif">
                <i class="fa-solid fa-users nav-icon"></i>
                <p>Pembeli</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if(Auth::user()->level == 'penjaga_toko' || Auth::user()->level == 'admin')
        <li class="nav-item">
          <a href="{{ route('rec_brg_masuk.index') }}" class="nav-link @if(Route::current()->getName() == 'rec_brg_masuk.index') active @endif">
            <i class="fa-solid fa-boxes nav-icon"></i>
            <p>Barang Masuk</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('penjualan.index') }}" class="nav-link @if(Route::current()->getName() == 'penjualan.index') active @endif">
            <i class="fa-solid fa-cash-register nav-icon"></i>
            <p>Penjualan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('stok.index') }}" class="nav-link @if(Route::current()->getName() == 'stok.index') active @endif">
            <i class="fa-solid fa-cubes nav-icon"></i>
            <p>Stok</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('pemindahan_stok.index') }}" class="nav-link @if(Route::current()->getName() == 'pemindahan_stok.index') active @endif">
            <i class="fa-solid fa-truck-moving nav-icon"></i>
            <p>Pemindahan Stok</p>
          </a>
        </li>

        <!-- <li class="nav-item">
          <a href="{{ route('detailbrgmasuk.index') }}" class="nav-link @if(Route::current()->getName() == 'detailbrgmasuk.index') active @endif">
            <i class="fa-solid fa-box-open nav-icon"></i>
            <p>Detail Barang Masuk</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('detailpenjualan.index') }}" class="nav-link @if(Route::current()->getName() == 'detailpenjualan.index') active @endif">
            <i class="fa-solid fa-receipt nav-icon"></i>
            <p>Detail Penjualan</p>
          </a>
        </li> -->
        @endif
        @if(Auth::user()->level == 'admin' || Auth::user()->level == 'owner')
        <li class="nav-item @if(str_contains(Route::current()->getPrefix(), 'laporan')) menu-open @endif">
          <a href="#" class="nav-link @if(str_contains(Route::current()->getPrefix(), 'laporan')) active @endif">
            <i class="nav-icon fa-solid fa-cogs"></i>
            <p>Laporan<i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('laporan.penjualan') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'laporan.penjualan') active @endif">
                <i class="fa-solid fa-tag nav-icon"></i>
                <p>Penjualan</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('laporan.stok') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'laporan.stok') active @endif">
                <i class="fa-solid fa-tag nav-icon"></i>
                <p>Stok</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('laporan.rec_brg_masuk') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'laporan.rec_brg_masuk') active @endif">
                <i class="fa-solid fa-tag nav-icon"></i>
                <p>Barang Masuk</p>
              </a>
            </li>
          </ul>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('laporan.pemindahan_stok') }}" class="pl-4 nav-link @if(Route::current()->getName() == 'laporan.pemindahan_stok') active @endif">
                <i class="fa-solid fa-tag nav-icon"></i>
                <p>Pemindahan Stok</p>
              </a>
            </li>
          </ul>
        </li>
        @endif
        @if(Auth::user()->level == 'admin')
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link @if(Route::current()->getName() == 'user.index') active @endif">
            <i class="fa-solid fa-users nav-icon"></i>
            <p>User</p>
          </a>
        </li>
        @endif
        @endauth
      </ul>
    </nav>
  </div>
</aside>