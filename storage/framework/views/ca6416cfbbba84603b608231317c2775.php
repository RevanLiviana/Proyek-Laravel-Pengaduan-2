<?php $__env->startSection('title', 'Riwayat Laporan'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Laporan</h4>
            <p class="text-muted mb-0">Laporan yang pernah Anda kirimkan</p>
        </div>
        <a href="<?php echo e(route('laporan.index')); ?>" class="btn btn-primary">+ Buat Laporan</a>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th><th>Judul</th><th>Kategori</th>
                        <th>Tanggal</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $laporans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($laporans->firstItem() + $i); ?></td>
                        <td><?php echo e($l->judul); ?></td>
                        <td><?php echo e($l->kategori); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($l->tanggal)->format('d/m/Y')); ?></td>
                        <td>
                            <?php
                                $badge = match($l->status) {
                                    'Dikirim'  => 'primary',
                                    'Diproses' => 'info',
                                    'Selesai'  => 'success',
                                    'Ditolak'  => 'danger',
                                    default    => 'secondary',
                                };
                            ?>
                            <span class="badge bg-<?php echo e($badge); ?>"><?php echo e($l->status); ?></span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada laporan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer"><?php echo e($laporans->links()); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/holykun/Documents/File PHP Laravel/belajar_php/Layanan Pengaduan/pengaduan-app/resources/views/laporan/riwayat.blade.php ENDPATH**/ ?>