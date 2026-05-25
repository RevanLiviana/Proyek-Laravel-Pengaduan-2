<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0">Manajemen Pengguna</h4>
            <small class="text-muted">Kelola akun pengguna sistem pengaduan</small>
        </div>
    </div>

    
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / email..." value="<?php echo e(request('search')); ?>">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="aktif" <?php echo e(request('status')=='aktif'?'selected':''); ?>>Aktif</option>
                <option value="nonaktif" <?php echo e(request('status')=='nonaktif'?'selected':''); ?>>Nonaktif</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
            <a href="<?php echo e(route('pengelolaan.pengguna.index')); ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $penggunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $pengguna): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($penggunas->firstItem() + $i); ?></td>
                        <td><?php echo e($pengguna->name); ?></td>
                        <td><?php echo e($pengguna->email); ?></td>
                        <td><span class="badge bg-secondary"><?php echo e(ucfirst($pengguna->role)); ?></span></td>
                        <td>
                            <span class="badge bg-<?php echo e($pengguna->status == 'aktif' ? 'success' : 'danger'); ?>">
                                <?php echo e(ucfirst($pengguna->status)); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($pengguna->status == 'aktif'): ?>
                            <button class="btn btn-sm btn-outline-warning"
                                onclick="ubahStatus(<?php echo e($pengguna->id); ?>, 'nonaktif')">
                                Nonaktifkan
                            </button>
                            <?php else: ?>
                            <button class="btn btn-sm btn-outline-success"
                                onclick="ubahStatus(<?php echo e($pengguna->id); ?>, 'aktif')">
                                Aktifkan
                            </button>
                            <?php endif; ?>
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="hapusPengguna(<?php echo e($pengguna->id); ?>)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada pengguna.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($penggunas->withQueryString()->links()); ?>

        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function ubahStatus(id, status) {
    if (!confirm(`Yakin ingin mengubah status pengguna menjadi ${status}?`)) return;
    fetch(`/pengelolaan/pengguna/${id}/status`, {
        method: 'PATCH',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'},
        body: JSON.stringify({ status })
    }).then(r => r.json()).then(data => {
        alert(data.message);
        location.reload();
    });
}

function hapusPengguna(id) {
    if (!confirm('Yakin ingin menghapus pengguna ini?')) return;
    fetch(`/pengelolaan/pengguna/${id}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN':'<?php echo e(csrf_token()); ?>'}
    }).then(r => r.json()).then(data => {
        alert(data.message);
        if (data.message.includes('berhasil')) location.reload();
    });
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/holykun/Documents/File PHP Laravel/belajar_php/Layanan Pengaduan/pengaduan-app/resources/views/pengelolaan/pengguna/index.blade.php ENDPATH**/ ?>