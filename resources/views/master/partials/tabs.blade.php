<div class="master-tabs">
    <a href="{{ route('master.kategori.index') }}"
       class="tab-btn {{ ($active ?? '') === 'kategori' ? 'active' : '' }}">
        <i class="ti ti-tag"></i>Kategori Pengaduan
    </a>
    <a href="#"
       class="tab-btn {{ ($active ?? '') === 'pengguna' ? 'active' : '' }}">
        <i class="ti ti-users"></i>Data Pengguna
    </a>
    <a href="#"
       class="tab-btn {{ ($active ?? '') === 'petugas' ? 'active' : '' }}">
        <i class="ti ti-user-shield"></i>Data Petugas
    </a>
    <a href="#"
       class="tab-btn {{ ($active ?? '') === 'unit' ? 'active' : '' }}">
        <i class="ti ti-building"></i>Unit/Bagian
    </a>
</div>