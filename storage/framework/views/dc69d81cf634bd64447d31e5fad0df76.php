<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>SIMPADU – <?php echo $__env->yieldContent('title', 'Sistem Pengaduan Kampus'); ?></title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --sidebar-w: 260px;
            --primary: #3B5BDB;
            --primary-dark: #2F4AC0;
            --primary-light: #EEF2FF;
            --sidebar-bg: #0F172A;
            --sidebar-hover: #1E293B;
            --sidebar-text: #94A3B8;
            --sidebar-active: #fff;
            --topbar-h: 60px;
            --radius: 10px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F1F5F9;
            color: #1E293B;
            margin: 0;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-w);
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            transition: transform .3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid #1E293B;
        }

        .brand-icon {
            width: 40px; height: 40px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 18px;
            flex-shrink: 0;
        }

        .brand-text .name {
            font-weight: 700;
            color: #fff;
            font-size: 15px;
            line-height: 1.2;
        }

        .brand-text .sub {
            font-size: 11px;
            color: var(--sidebar-text);
        }

        .nav-section {
            padding: 16px 12px 4px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            color: #475569;
            text-transform: uppercase;
        }

        .sidebar-nav { padding: 0 8px; list-style: none; margin: 0; }

        .sidebar-nav li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
        }

        .sidebar-nav li a:hover {
            background: var(--sidebar-hover);
            color: #CBD5E1;
        }

        .sidebar-nav li a.active,
        .sidebar-nav li.active > a {
            background: var(--primary);
            color: #fff;
        }

        .sidebar-nav li a i { font-size: 16px; width: 20px; flex-shrink: 0; }

        /* Submenu */
        .has-sub > a .arrow {
            margin-left: auto;
            transition: transform .25s;
        }

        .has-sub.open > a .arrow { transform: rotate(90deg); }

        .submenu {
            list-style: none;
            padding: 0 0 0 20px;
            margin: 0;
            overflow: hidden;
            max-height: 0;
            transition: max-height .3s ease;
        }

        .has-sub.open .submenu { max-height: 300px; }

        .submenu li a {
            padding: 7px 12px;
            font-size: 13px;
            color: #64748B;
            position: relative;
        }

        .submenu li a::before {
            content: '';
            position: absolute;
            left: -4px; top: 50%;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #334155;
            transform: translateY(-50%);
        }

        .submenu li a.active::before,
        .submenu li a:hover::before { background: var(--primary); }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px 12px;
            border-top: 1px solid #1E293B;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 8px;
            background: #1E293B;
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-info .uname {
            font-size: 13px;
            font-weight: 600;
            color: #E2E8F0;
            line-height: 1.2;
        }

        .user-info .urole {
            font-size: 11px;
            color: #64748B;
        }

        /* ── MAIN ── */
        #main {
            margin-left: var(--sidebar-w);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── TOPBAR ── */
        .topbar {
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid #E2E8F0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #64748B;
        }

        .breadcrumb-custom .sep { color: #CBD5E1; }
        .breadcrumb-custom .current { color: #1E293B; font-weight: 600; }

        .topbar-actions { display: flex; align-items: center; gap: 8px; }

        .btn-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            color: #64748B;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-icon:hover { background: var(--primary-light); color: var(--primary); border-color: var(--primary); }

        /* ── PAGE CONTENT ── */
        .page-content { padding: 24px; flex: 1; }

        /* ── CARDS ── */
        .card {
            border: 1px solid #E2E8F0;
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #F1F5F9;
            padding: 16px 20px;
        }

        /* ── INFO BANNER ── */
        .info-banner {
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: var(--radius);
            padding: 12px 16px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13.5px;
            color: #1D4ED8;
            margin-bottom: 20px;
        }

        .info-banner i { font-size: 16px; flex-shrink: 0; margin-top: 1px; }

        /* ── PAGE TABS ── */
        .page-tabs {
            display: flex;
            gap: 4px;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: var(--radius);
            padding: 4px;
            margin-bottom: 20px;
        }

        .page-tab {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 7px;
            font-size: 13.5px;
            font-weight: 500;
            color: #64748B;
            text-decoration: none;
            transition: all .15s;
            border: none;
            background: transparent;
        }

        .page-tab:hover { background: #fff; color: #1E293B; }

        .page-tab.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 6px rgba(59,91,219,.35);
        }

        .page-tab i { font-size: 15px; }

        /* ── TABLE ── */
        .table-wrapper {
            border-radius: var(--radius);
            overflow: hidden;
        }

        .table { margin: 0; font-size: 13.5px; }

        .table thead th {
            background: #F8FAFC;
            border-bottom: 1px solid #E2E8F0;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #64748B;
            padding: 12px 16px;
            white-space: nowrap;
        }

        .table tbody td { padding: 13px 16px; vertical-align: middle; border-color: #F1F5F9; }

        .table tbody tr:last-child td { border-bottom: none; }

        .table tbody tr:hover td { background: #FAFBFF; }

        /* ── BADGES ── */
        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-aktif { background: #DCFCE7; color: #15803D; }
        .badge-nonaktif { background: #FEE2E2; color: #DC2626; }

        /* ── BUTTONS ── */
        .btn-primary-custom {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 13.5px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: background .15s, box-shadow .15s;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(59,91,219,.3);
        }

        .btn-outline-custom {
            background: transparent;
            color: #64748B;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13.5px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-outline-custom:hover { background: #F8FAFC; color: #1E293B; }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state .icon {
            font-size: 52px;
            color: #CBD5E1;
            margin-bottom: 12px;
        }

        .empty-state h6 { font-weight: 700; color: #475569; margin-bottom: 6px; }
        .empty-state p { font-size: 13px; color: #94A3B8; }

        /* ── MODAL ── */
        .modal-content { border-radius: 12px; border: none; }
        .modal-header { border-bottom: 1px solid #F1F5F9; padding: 18px 20px; }
        .modal-footer { border-top: 1px solid #F1F5F9; padding: 14px 20px; }

        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }

        .form-control, .form-select {
            border-radius: 8px;
            border-color: #E2E8F0;
            font-size: 13.5px;
            padding: 9px 12px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59,91,219,.12);
        }

        .invalid-feedback { font-size: 12px; }

        /* ── SEARCH INPUT ── */
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94A3B8; font-size: 14px; }
        .search-wrap input { padding-left: 36px; }

        /* ── ACTION BUTTONS ── */
        .btn-action {
            width: 32px; height: 32px;
            border-radius: 7px;
            border: 1px solid #E2E8F0;
            background: transparent;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 14px;
            cursor: pointer;
            transition: all .15s;
        }

        .btn-action.edit { color: #3B82F6; }
        .btn-action.edit:hover { background: #EFF6FF; border-color: #3B82F6; }
        .btn-action.del { color: #EF4444; }
        .btn-action.del:hover { background: #FEF2F2; border-color: #EF4444; }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>

<!-- ══════════ SIDEBAR ══════════ -->
<nav id="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-megaphone-fill"></i></div>
        <div class="brand-text">
            <div class="name">SIMPADU</div>
            <div class="sub">Sistem Pengaduan Kampus</div>
        </div>
    </div>

    <!-- UTAMA -->
    <div class="nav-section">Utama</div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?php echo e(route('laporan.index')); ?>" class="<?php echo e(request()->routeIs('laporan.*') ? 'active' : ''); ?>">
                <i class="bi bi-file-earmark-text"></i> Laporan Pengaduan
            </a>
        </li>
        <li>
            <a href="<?php echo e(route('riwayat.index')); ?>" class="<?php echo e(request()->routeIs('riwayat.*') ? 'active' : ''); ?>">
                <i class="bi bi-clock-history"></i> Riwayat Laporan
            </a>
        </li>
    </ul>

    <!-- DATA MASTER -->
    <div class="nav-section">Data Master</div>
    <ul class="sidebar-nav">
        <li class="has-sub <?php echo e(request()->routeIs('master.*') ? 'open' : ''); ?>">
            <a href="#">
                <i class="bi bi-database"></i>
                Data Master
                <i class="bi bi-chevron-right arrow"></i>
            </a>
            <ul class="submenu">
                <li>
                    <a href="<?php echo e(route('master.kategori.index')); ?>"
                       class="<?php echo e(request()->routeIs('master.kategori.*') ? 'active' : ''); ?>">
                        Kategori Pengaduan
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('master.pengguna.index')); ?>"
                       class="<?php echo e(request()->routeIs('master.pengguna.*') ? 'active' : ''); ?>">
                        Data Pengguna
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('master.petugas.index')); ?>"
                       class="<?php echo e(request()->routeIs('master.petugas.*') ? 'active' : ''); ?>">
                        Data Petugas
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('master.unit.index')); ?>"
                       class="<?php echo e(request()->routeIs('master.unit.*') ? 'active' : ''); ?>">
                        Unit/Bagian
                    </a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- PENGELOLAAN -->
    <div class="nav-section">Pengelolaan</div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?php echo e(route('pengelolaan.laporan.index')); ?>" class="<?php echo e(request()->routeIs('pengelolaan.laporan*') ? 'active' : ''); ?>"><i class="bi bi-kanban"></i> Manajemen Laporan</a>
        </li>
        <li>
            <a href="<?php echo e(route('pengelolaan.pengguna.index')); ?>" class="<?php echo e(request()->routeIs('pengelolaan.pengguna*') ? 'active' : ''); ?>"><i class="bi bi-people"></i> Manajemen Pengguna</a>
        </li>
    </ul>

    <!-- LAPORAN -->
    <div class="nav-section">Laporan</div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?php echo e(route('rekapitulasi.index')); ?>" class="<?php echo e(request()->routeIs('rekapitulasi.*') ? 'active' : ''); ?>"><i class="bi bi-bar-chart-line"></i> Rekapitulasi</a>
        </li>
        <li>
            <a href="<?php echo e(route('export.data')); ?>"><i class="bi bi-download"></i> Export Data</a>
        </li>
    </ul>

    <!-- User Footer -->
    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">AD</div>
            <div class="user-info">
                <div class="uname">Admin Sistem</div>
                <div class="urole">Super Admin</div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn p-0 ms-auto text-secondary" style="font-size:16px;" title="Logout"><i class="bi bi-box-arrow-right"></i></button>
            </form>
        </div>
    </div>

</nav>

<!-- ══════════ MAIN AREA ══════════ -->
<div id="main">

    <!-- TOPBAR -->
    <header class="topbar">
        <div class="breadcrumb-custom">
            <i class="bi bi-house"></i>
            <span>Beranda</span>
            <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                <span class="sep">›</span>
                <?php echo $__env->yieldContent('breadcrumb'); ?>
            <?php endif; ?>
        </div>
        <div class="topbar-actions">
            <button class="btn-icon"><i class="bi bi-bell"></i></button>
            <button class="btn-icon"><i class="bi bi-gear"></i></button>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <div class="page-content">

        <!-- Info Banner -->
        <div class="info-banner">
            <i class="bi bi-info-circle-fill"></i>
            <span>Data Master adalah data dasar yang harus diisi agar proses bisnis Sistem Pengaduan dapat berjalan dengan baik. Pastikan semua data lengkap sebelum sistem digunakan.</span>
        </div>

        <!-- Page Tabs (Data Master Navigation) -->
        <?php if(request()->routeIs('master.*')): ?>
        <div class="page-tabs">
            <a href="<?php echo e(route('master.kategori.index')); ?>"
               class="page-tab <?php echo e(request()->routeIs('master.kategori.*') ? 'active' : ''); ?>">
                <i class="bi bi-tag"></i> Kategori Pengaduan
            </a>
            <a href="<?php echo e(route('master.pengguna.index')); ?>"
               class="page-tab <?php echo e(request()->routeIs('master.pengguna.*') ? 'active' : ''); ?>">
                <i class="bi bi-person-badge"></i> Data Pengguna
            </a>
            <a href="<?php echo e(route('master.petugas.index')); ?>"
               class="page-tab <?php echo e(request()->routeIs('master.petugas.*') ? 'active' : ''); ?>">
                <i class="bi bi-person-check"></i> Data Petugas
            </a>
            <a href="<?php echo e(route('master.unit.index')); ?>"
               class="page-tab <?php echo e(request()->routeIs('master.unit.*') ? 'active' : ''); ?>">
                <i class="bi bi-building"></i> Unit/Bagian
            </a>
        </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // CSRF untuk Axios
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

    // Toggle submenu sidebar
    document.querySelectorAll('.has-sub > a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            this.parentElement.classList.toggle('open');
        });
    });

    // Toast helper
    function toast(icon, title) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        });
    }
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html><?php /**PATH /Users/holykun/Documents/File PHP Laravel/belajar_php/Layanan Pengaduan/pengaduan-app/resources/views/layouts/master.blade.php ENDPATH**/ ?>