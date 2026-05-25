<?php $__env->startSection('title', 'Rekapitulasi'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">Rekapitulasi Laporan</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-primary"><?php echo e($total); ?></div>
                    <div class="text-muted small">Total</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-info"><?php echo e($dikirim); ?></div>
                    <div class="text-muted small">Dikirim</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-warning"><?php echo e($diproses); ?></div>
                    <div class="text-muted small">Diproses</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-success"><?php echo e($selesai); ?></div>
                    <div class="text-muted small">Selesai</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-danger"><?php echo e($ditolak); ?></div>
                    <div class="text-muted small">Ditolak</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <a href="<?php echo e(route('export.data')); ?>" class="text-white text-decoration-none">
                        <div class="fs-4"><i class="bi bi-download"></i></div>
                        <div class="small fw-semibold">Export CSV</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-semibold">Laporan per Kategori</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr><th>Kategori</th><th>Jumlah</th></tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $perKategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr><td><?php echo e($k->kategori); ?></td><td><?php echo e($k->total); ?></td></tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="2" class="text-center py-3 text-muted">Belum ada data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/holykun/Documents/File PHP Laravel/belajar_php/Layanan Pengaduan/pengaduan-app/resources/views/rekapitulasi/index.blade.php ENDPATH**/ ?>