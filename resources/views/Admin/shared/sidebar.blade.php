<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ request()->routeIs('admin') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin') }}">
        <i class="fa fa-tachometer-alt menu-icon"></i> <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('kategori.index') }}">
        <i class="fa fa-tags menu-icon"></i> <span class="menu-title">Categories</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('produk.index') ? 'active' : '' }} ">
      <a class="nav-link" href="{{ route('produk.index') }}">
        <i class="fa fa-boxes menu-icon"></i> <span class="menu-title">Products</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('user.index') }}">
        <i class="fa fa-cash-register menu-icon"></i> <span class="menu-title">Cashiers</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('pembelian.index','pembelian_detail.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('pembelian.index') }}">
        <i class="fa fa-shopping-cart menu-icon"></i> <span class="menu-title">Pembelian</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('penjualan.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('penjualan.index') }}">
        <i class="fa fa-money-bill-wave menu-icon"></i> <span class="menu-title">Penjualan</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('transaksi.index') }}">
        <i class="fa fa-history menu-icon"></i> <span class="menu-title">Transaksi Lama</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('transaksi.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{  route('transaksi.index')  }}">
        <i class="fa-solid fa-cart-plus menu-icon"></i> <span class="menu-title">Transaksi Baru</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('member.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('member.index') }}">
        <i class="fa fa-users menu-icon"></i> <span class="menu-title">Member</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('supplier.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('supplier.index') }}">
        <i class="fa fa-truck menu-icon"></i> <span class="menu-title">Supplier</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('laporan.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('laporan.index') }}">
        <i class="fa fa-chart-bar menu-icon"></i> <span class="menu-title">Report</span>
      </a>
    </li>
  </ul>
</nav>
