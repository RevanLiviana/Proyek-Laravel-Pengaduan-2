<?php $__env->startSection('title', 'Unit/Bagian'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <span>Data Master</span>
    <span class="sep">›</span>
    <span class="current">Unit/Bagian</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <h6 class="fw-bold mb-1" style="font-size:15px;">Unit/Bagian</h6>
            <p class="mb-0 text-muted" style="font-size:12.5px;">Kelola unit atau bagian yang ada di kampus</p>
        </div>
        <div class="d-flex gap-2">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="Cari unit..."
                       style="width:220px;" oninput="filterTable(this.value)">
            </div>
            <button class="btn-outline-custom" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
            <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="openAdd()">
                <i class="bi bi-plus-lg"></i> Tambah Unit
            </button>
        </div>
    </div>

    <div class="table-responsive table-wrapper">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th style="width:50px;">NO</th>
                    <th>NAMA UNIT/BAGIAN</th>
                    <th>DESKRIPSI</th>
                    <th>JML PETUGAS</th>
                    <th>STATUS</th>
                    <th style="width:100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="data-row">
                    <td class="text-muted"><?php echo e($units->firstItem() + $i); ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:8px;background:#FEF3C7;
                                        color:#D97706;display:flex;align-items:center;justify-content:center;
                                        font-size:16px;flex-shrink:0;">
                                <i class="bi bi-building"></i>
                            </div>
                            <span class="fw-semibold"><?php echo e($u->nama_unit); ?></span>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo e($u->deskripsi ?? '-'); ?></td>
                    <td>
                        <span class="fw-semibold"><?php echo e($u->petugas_count); ?></span>
                        <span class="text-muted" style="font-size:12px;"> petugas</span>
                    </td>
                    <td>
                        <span class="badge-status <?php echo e($u->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif'); ?>">
                            <?php echo e(ucfirst($u->status)); ?>

                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn-action edit" onclick="openEdit(<?php echo e($u->id); ?>)"><i class="bi bi-pencil"></i></button>
                            <button class="btn-action del" onclick="deleteUnit(<?php echo e($u->id); ?>, '<?php echo e(addslashes($u->nama_unit)); ?>')"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6">
                    <div class="empty-state">
                        <div class="icon"><i class="bi bi-building-fill"></i></div>
                        <h6>Belum ada unit/bagian</h6>
                        <p>Klik tombol Tambah Unit untuk memulai</p>
                    </div>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex align-items-center justify-content-between px-4 py-3">
        <small class="text-muted">
            Menampilkan <?php echo e($units->firstItem() ?? 0); ?>–<?php echo e($units->lastItem() ?? 0); ?>

            dari <?php echo e($units->total()); ?> data
        </small>
        
        <?php echo e($units->links()); ?>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modalTitle">Tambah Unit/Bagian</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formUnit" novalidate>
                    <input type="hidden" id="editId">

                    
                    <div class="mb-3">
                        <label class="form-label">Nama Unit/Bagian <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_unit"
                               placeholder="Contoh: BAAK, Kemahasiswaan..." maxlength="100">
                        <div class="invalid-feedback" id="err_nama_unit"></div>
                        <div class="form-text">Wajib diisi, minimal 3 karakter, maksimal 100 karakter.</div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="3"
                                  placeholder="Keterangan unit..." maxlength="255"></textarea>
                        <div class="invalid-feedback" id="err_deskripsi"></div>
                        <div class="form-text" id="charCount">0 / 255 karakter</div>
                    </div>

                    
                    <div class="mb-1">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status">
                            <option value="">-- Pilih Status --</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                        <div class="invalid-feedback" id="err_status"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-primary-custom" id="btnSave" onclick="saveUnit()">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const BASE_URL = '<?php echo e(route("master.unit.index")); ?>';

// ══════════════════════════════════════════════════════════
// CLIENT-SIDE VALIDATION
// ══════════════════════════════════════════════════════════
function validateForm() {
    clearErrors();
    let isValid = true;

    // VALIDASI 1: Nama Unit — wajib diisi, minimal 3 karakter
    const namaUnit = document.getElementById('nama_unit').value.trim();
    if (namaUnit === '') {
        setError('nama_unit', 'Nama unit/bagian wajib diisi.');
        isValid = false;
    } else if (namaUnit.length < 3) {
        setError('nama_unit', 'Nama unit minimal 3 karakter.');
        isValid = false;
    } else if (namaUnit.length > 100) {
        setError('nama_unit', 'Nama unit maksimal 100 karakter.');
        isValid = false;
    } else {
        setValid('nama_unit');
    }

    // VALIDASI 2: Deskripsi — maksimal 255 karakter
    const deskripsi = document.getElementById('deskripsi').value.trim();
    if (deskripsi.length > 255) {
        setError('deskripsi', 'Deskripsi maksimal 255 karakter.');
        isValid = false;
    } else {
        setValid('deskripsi');
    }

    // VALIDASI 3: Status — wajib dipilih
    const status = document.getElementById('status').value;
    if (status === '') {
        setError('status', 'Status wajib dipilih.');
        isValid = false;
    } else {
        setValid('status');
    }

    return isValid;
}

function setError(fieldId, message) {
    const el = document.getElementById(fieldId);
    const errEl = document.getElementById('err_' + fieldId);
    if (el) el.classList.add('is-invalid');
    if (errEl) errEl.textContent = message;
}

function setValid(fieldId) {
    const el = document.getElementById(fieldId);
    if (el) { el.classList.remove('is-invalid'); el.classList.add('is-valid'); }
}

function saveUnit() {
    if (!validateForm()) return;

    const id = document.getElementById('editId').value;
    const payload = {
        nama_unit: document.getElementById('nama_unit').value.trim(),
        deskripsi: document.getElementById('deskripsi').value.trim(),
        status: document.getElementById('status').value,
        _token: '<?php echo e(csrf_token()); ?>'
    };

    const url  = id ? `${BASE_URL}/${id}` : BASE_URL;
    const meth = id ? 'put' : 'post';

    const btnSave = document.getElementById('btnSave');
    btnSave.disabled = true;
    btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

    axios[meth](url, payload)
        .then(res => {
            bootstrap.Modal.getInstance(document.getElementById('modalForm')).hide();
            toast('success', res.data.message);
            setTimeout(() => location.reload(), 800);
        })
        .catch(err => {
            if (err.response?.status === 422) showErrors(err.response.data.errors);
            else toast('error', 'Terjadi kesalahan.');
        })
        .finally(() => {
            btnSave.disabled = false;
            btnSave.innerHTML = '<i class="bi bi-check-lg"></i> Simpan';
        });
}

function openAdd() {
    document.getElementById('modalTitle').textContent = 'Tambah Unit/Bagian';
    document.getElementById('editId').value = '';
    document.getElementById('formUnit').reset();
    document.getElementById('status').value = '';
    clearErrors();
}

function openEdit(id) {
    axios.get(`${BASE_URL}/${id}`)
        .then(res => {
            const d = res.data;
            document.getElementById('modalTitle').textContent = 'Edit Unit/Bagian';
            document.getElementById('editId').value = d.id;
            document.getElementById('nama_unit').value = d.nama_unit;
            document.getElementById('deskripsi').value = d.deskripsi ?? '';
            document.getElementById('status').value = d.status;
            clearErrors();
            new bootstrap.Modal(document.getElementById('modalForm')).show();
        });
}

function deleteUnit(id, nama) {
    Swal.fire({
        title: 'Hapus Unit?',
        html: `Unit <strong>${nama}</strong> akan dihapus.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus',
    }).then(r => {
        if (!r.isConfirmed) return;
        axios.delete(`${BASE_URL}/${id}`, { data: { _token: '<?php echo e(csrf_token()); ?>' } })
            .then(res => { toast('success', res.data.message); setTimeout(() => location.reload(), 800); })
            .catch(err => toast('error', err.response?.data?.message ?? 'Gagal menghapus.'));
    });
}

function filterTable(q) {
    document.querySelectorAll('#dataTable tbody tr.data-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
}

function clearErrors() {
    document.querySelectorAll('.form-control,.form-select').forEach(el => el.classList.remove('is-invalid', 'is-valid'));
    document.querySelectorAll('[id^="err_"]').forEach(el => el.textContent = '');
}

function showErrors(errors) {
    Object.keys(errors).forEach(field => {
        const el = document.getElementById(field);
        const errEl = document.getElementById('err_' + field);
        if (el) { el.classList.remove('is-valid'); el.classList.add('is-invalid'); }
        if (errEl) errEl.textContent = errors[field][0];
    });
}

// Counter karakter deskripsi
document.addEventListener('DOMContentLoaded', function () {
    const desk = document.getElementById('deskripsi');
    const count = document.getElementById('charCount');
    if (desk && count) {
        desk.addEventListener('input', function () {
            const len = this.value.length;
            count.textContent = `${len} / 255 karakter`;
            count.style.color = len > 230 ? '#EF4444' : '';
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/holykun/Documents/File PHP Laravel/belajar_php/Layanan Pengaduan/pengaduan-app/resources/views/master/unit/index.blade.php ENDPATH**/ ?>