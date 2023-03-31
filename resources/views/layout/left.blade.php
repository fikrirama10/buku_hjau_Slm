<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo py-3 px-4 ms-2">
        <a href="index.html" class="d-block w-100">
            <img src="{{ asset('storage/BIRUPUTIH.png') }}" alt="" class="app-brand-img w-px-100">
            <img src="{{ asset('storage/BIRUPUTIH.png') }}" alt="" class="app-brand-img-collapsed w-px-30">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti ti-menu-2 d-none d-lg-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-lg-none ti-sm align-middle"></i>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        <li class="menu-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <a href="index.html" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('transaksi') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-receipt"></i>
                <div data-i18n="Transaksi">Transaksi</div>
            </a>
        </li>
        <li class="menu-item ">
            <a href="{{ route('tarif') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-receipt"></i>
                <div data-i18n="Tarif">Tarif</div>
            </a>
        </li>
        @if (auth()->user()->role_id == 1)
        <li class="menu-item ">
            <a href="{{ route('laporan') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-receipt"></i>
                <div data-i18n="Laporan">Laporan</div>
            </a>
        </li>
        @endif       
    </ul>
</aside>
