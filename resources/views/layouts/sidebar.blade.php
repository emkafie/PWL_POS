@php
$activateMenu = $activateMenu ?? ''; // Berikan nilai default jika $activateMenu tidak didefinisikan
@endphp
<!--begin::Sidebar Wrapper-->
<div class="sidebar-wrapper">
  <!-- SidebarSearch Form -->
  <div class="form-inline mt-2">
    <div class="input-group" data-widget="sidebar-search">
      <input class="form-control form-control-sidebar" type="search"
        placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn h-100 border border-start-0 shadow-none rounded-start-0">
          <i class="nav-icon bi bi-search"></i>
        </button>
      </div>
    </div>
  </div>
  <!-- SideBarEnd Form -->
  <nav class="mt-2">
    <!--begin::Sidebar Menu-->
    <ul
      class="nav sidebar-menu flex-column"
      data-lte-toggle="treeview"
      role="menu"
      data-accordion="false">
      <li class="nav-item">
        <a href="{{ url('/') }}" class="nav-link  {{ ($activateMenu == 'dashboard')? 
'active' : '' }} ">
          <i class="nav-icon bi bi-speedometer2"></i>
          <p>Dashboard</p>
        </a>
      </li>
      <li class="nav-header">Data Pengguna</li>
      <li class="nav-item">
        <a href="{{ url('/level') }}" class="nav-link {{ ($activateMenu == 'level')? 
'active' : '' }} ">
          <i class="nav-icon bi bi-stack"></i>
          <p>Level User</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/user') }}" class="nav-link {{ ($activateMenu == 'user')? 
'active' : '' }}">
          <i class="nav-icon bi bi-person"></i>
          <p>Data User</p>
        </a>
      </li>
      <li class="nav-header">Data Barang</li>
      <li class="nav-item">
        <a href="{{ url('/kategori') }}" class="nav-link {{ ($activateMenu == 
'kategori')? 'active' : '' }} ">
          <i class="nav-icon bi bi-bookmark"></i>
          <p>Kategori Barang</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/barang') }}" class="nav-link {{ ($activateMenu == 
'barang')? 'active' : '' }} ">
          <i class="nav-icon bi bi-folder-fill"></i>
          <p>Data Barang</p>
        </a>
      </li>
      <li class="nav-header">Data Transaksi</li>
      <li class="nav-item">
        <a href="{{ url('/stok') }}" class="nav-link {{ ($activateMenu == 'stok')? 
'active' : '' }} ">
          <i class="nav-icon bi bi-boxes"></i>
          <p>Stok Barang</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ url('/barang') }}" class="nav-link {{ ($activateMenu == 
'penjualan')? 'active' : '' }} ">
          <i class="nav-icon bi bi-bag-fill"></i>
          <p>Transaksi Penjualan</p>
        </a>
      </li>
      <li class="nav-header">Data Supplier</li>
      <li class="nav-item">
        <a href="{{ url('/supplier') }}" class="nav-link {{ ($activateMenu == 'supplier' )? 'active' : '' }}">
          <i class="nav-icon bi bi-building"></i>
          <p>Supplier</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
          <i class="nav-icon bi bi-box-arrow-right"></i>
          <p>Logout</p>
        </a>
      </li>
    </ul>
    <!--end::Sidebar Menu-->
  </nav>
</div>

<!--end::Sidebar Wrapper-->