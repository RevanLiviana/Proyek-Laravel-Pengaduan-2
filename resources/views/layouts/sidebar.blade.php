<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="ti ti-shield-check"></i></div>
        <div>
            <div class="brand-name">SIMPADU</div>
            <div class="brand-sub">Sistem Pengaduan Kampus</div>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-section-label">Utama</div>
        <div class="nav-item">
            <a class="nav-link" href="/"><i class="ti ti-layout-dashboard"></i>Dashboard</a>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-section-label">Data Master</div>
        <div class="nav-item {{ request()->routeIs('master.*') ? 'open' : '' }}" id="dm-nav">
            <div class="nav-link {{ request()->routeIs('master.*') ? 'active' : '' }}"
                 onclick="toggleSub('dm-sub', this.closest('.nav-item'))">
                <i class="ti ti-database"></i>Data Master
                <i class="ti ti-chevron-down nav-caret"></i>
            </div>
            <div class="nav-submenu" id="dm-sub">
                <a class="nav-link {{ request()->routeIs('master.kategori*') ? 'active' : '' }}"
                   href="{{ route('master.kategori.index') }}">Kategori Pengaduan</a>
                <a class="nav-link {{ request()->routeIs('master.pengguna*') ? 'active' : '' }}"
                   href="{{ route('master.pengguna.index') }}">Data Pengguna</a>
                <a class="nav-link {{ request()->routeIs('master.petugas*') ? 'active' : '' }}"
                   href="{{ route('master.petugas.index') }}">Data Petugas</a>
                <a class="nav-link {{ request()->routeIs('master.unit*') ? 'active' : '' }}"
                   href="{{ route('master.unit.index') }}">Unit/Bagian</a>
            </div>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-section-label">Pengelolaan</div>
        <div class="nav-item">
            <a class="nav-link {{ request()->routeIs('pengelolaan.laporan*') ? 'active' : '' }}"
               href="{{ route('pengelolaan.laporan.index') }}">
                <i class="ti ti-clipboard-list"></i>Manajemen Laporan
            </a>
        </div>
        <div class="nav-item">
            <a class="nav-link {{ request()->routeIs('pengelolaan.pengguna*') ? 'active' : '' }}"
               href="{{ route('pengelolaan.pengguna.index') }}">
                <i class="ti ti-users"></i>Manajemen Pengguna
            </a>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-section-label">Laporan</div>
        <div class="nav-item">
            <a class="nav-link" href="#"><i class="ti ti-chart-bar"></i>Rekapitulasi</a>
        </div>
        <div class="nav-item">
            <a class="nav-link" href="#"><i class="ti ti-file-download"></i>Export Data</a>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">AD</div>
            <div class="user-info">
                <div class="user-name">Admin Sistem</div>
                <div class="user-role">Super Admin</div>
            </div>
            <i class="ti ti-logout"></i>
        </div>
    </div>
</aside>