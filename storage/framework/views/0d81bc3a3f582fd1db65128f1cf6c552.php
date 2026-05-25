<?php $__env->startSection('title', 'Data Pengguna'); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <span>Data Master</span>
    <span class="sep">›</span>
    <span class="current">Data Pengguna</span>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <h6 class="fw-bold mb-1" style="font-size:15px;">Data Pengguna</h6>
            <p class="mb-0 text-muted" style="font-size:12.5px;">Kelola akun pengguna sistem pengaduan</p>
        </div>
        <div class="d-flex gap-2">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="Cari pengguna..."
                       style="width:220px;" oninput="filterTable(this.value)">
            </div>
            <button class="btn-outline-custom" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
            <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="openAdd()">
                <i class="bi bi-plus-lg"></i> Tambah Pengguna
            </button>
        </div>
    </div>

    <div class="table-responsive table-wrapper">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th style="width:50px;">NO</th>
                    <th>NAMA</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th>STATUS</th>
                    <th style="width:100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $penggunas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="data-row">
                    <td class="text-muted"><?php echo e($penggunas->firstItem() + $i); ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:50%;background:#EEF2FF;
                                        color:#3B5BDB;display:flex;align-items:center;justify-content:center;
                                        font-weight:700;font-size:13px;flex-shrink:0;">
                                <?php echo e(strtoupper(substr($p->name, 0, 1))); ?>

                            </div>
                            <span class="fw-semibold"><?php echo e($p->name); ?></span>
                        </div>
                    </td>
                    <td class="text-muted"><?php echo e($p->email); ?></td>
                    <td>
                        <?php
                            $roleColor = ['mahasiswa'=>'#3B82F6','dosen'=>'#8B5CF6','staf'=>'#F59E0B','umum'=>'#6B7280'];
                            $c = $roleColor[$p->role] ?? '#6B7280';
                        ?>
                        <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;
                                     background:<?php echo e($c); ?>18;color:<?php echo e($c); ?>;">
                            <?php echo e(ucfirst($p->role)); ?>

                        </span>
                    </td>
                    <td>
                        <span class="badge-status <?php echo e($p->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif'); ?>">
                            <?php echo e(ucfirst($p->status)); ?>

                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn-action edit" onclick="openEdit(<?php echo e($p->id); ?>)"><i class="bi bi-pencil"></i></button>
                            <button class="btn-action del" onclick="deletePengguna(<?php echo e($p->id); ?>, '<?php echo e(addslashes($p->name)); ?>')"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6">
                    <div class="empty-state">
                        <div class="icon"><i class="bi bi-person-fill"></i></div>
                        <h6>Belum ada pengguna</h6>
                        <p>Klik tombol Tambah Pengguna untuk memulai</p>
                    </div>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex align-items-center justify-content-between px-4 py-3">
        <small class="text-muted">
            Menampilkan <?php echo e($penggunas->firstItem() ?? 0); ?>–<?php echo e($penggunas->lastItem() ?? 0); ?>

            dari <?php echo e($penggunas->total()); ?> data
        </small>
        
        <?php echo e($penggunas->links()); ?>

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modalTitle">Tambah Pengguna</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPengguna" novalidate>
                    <input type="hidden" id="editId">

                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama lengkap pengguna" maxlength="100">
                        <div class="invalid-feedback" id="err_nama"></div>
                        <div class="form-text">Wajib diisi, minimal 3 karakter.</div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" placeholder="email@kampus.ac.id">
                        <div class="invalid-feedback" id="err_email"></div>
                        <div class="form-text">Wajib diisi, format email valid.</div>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger" id="passRequired">*</span></label>
                        <input type="password" class="form-control" id="password" placeholder="Min. 8 karakter">
                        <div class="form-text" id="passHint" style="display:none;">Kosongkan jika tidak ingin mengubah password</div>
                        <div class="invalid-feedback" id="err_password"></div>
                    </div>

                    <div class="row">
                        
                        <div class="col-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" id="role">
                                <option value="">-- Pilih Role --</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="dosen">Dosen</option>
                                <option value="staf">Staf</option>
                                <option value="umum">Umum</option>
                            </select>
                            <div class="invalid-feedback" id="err_role"></div>
                        </div>

                        
                        <div class="col-6 mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status">
                                <option value="">-- Pilih Status --</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Non-Aktif</option>
                            </select>
                            <div class="invalid-feedback" id="err_status"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-primary-custom" id="btnSave" onclick="savePengguna()">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const BASE_URL = '<?php echo e(route("master.pengguna.index")); ?>';

// ══════════════════════════════════════════════════════════
// CLIENT-SIDE VALIDATION
// ══════════════════════════════════════════════════════════
function validateForm() {
    clearErrors();
    let isValid = true;
    const isEdit = document.getElementById('editId').value !== '';

    // VALIDASI 1: Nama — wajib diisi, minimal 3 karakter
    const nama = document.getElementById('nama').value.trim();
    if (nama === '') {
        setError('nama', 'Nama lengkap wajib diisi.');
        isValid = false;
    } else if (nama.length < 3) {
        setError('nama', 'Nama minimal 3 karakter.');
        isValid = false;
    } else if (nama.length > 100) {
        setError('nama', 'Nama maksimal 100 karakter.');
        isValid = false;
    } else {
        setValid('nama');
    }

    // VALIDASI 2: Email — wajib diisi, format valid
    const email = document.getElementById('email').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        setError('email', 'Email wajib diisi.');
        isValid = false;
    } else if (!emailRegex.test(email)) {
        setError('email', 'Format email tidak valid. Contoh: nama@kampus.ac.id');
        isValid = false;
    } else {
        setValid('email');
    }

    // VALIDASI 3: Password — wajib saat tambah, minimal 8 karakter
    const password = document.getElementById('password').value;
    if (!isEdit && password === '') {
        setError('password', 'Password wajib diisi.');
        isValid = false;
    } else if (password !== '' && password.length < 8) {
        setError('password', 'Password minimal 8 karakter.');
        isValid = false;
    } else {
        setValid('password');
    }

    // VALIDASI 4: Role — wajib dipilih
    const role = document.getElementById('role').value;
    if (role === '') {
        setError('role', 'Role wajib dipilih.');
        isValid = false;
    } else {
        setValid('role');
    }

    // VALIDASI 5: Status — wajib dipilih
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
    if (el) {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
    }
}

// ══════════════════════════════════════════════════════════
// FUNGSI UTAMA SIMPAN
// ══════════════════════════════════════════════════════════
function savePengguna() {
    if (!validateForm()) return; // Stop jika client-side validation gagal

    const id = document.getElementById('editId').value;
    const payload = {
        nama: document.getElementById('nama').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value,
        role: document.getElementById('role').value,
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
    document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
    document.getElementById('editId').value = '';
    document.getElementById('formPengguna').reset();
    document.getElementById('passRequired').style.display = '';
    document.getElementById('passHint').style.display = 'none';
    document.getElementById('role').value = '';
    document.getElementById('status').value = '';
    clearErrors();
}

function openEdit(id) {
    axios.get(`${BASE_URL}/${id}`)
        .then(res => {
            const d = res.data;
            document.getElementById('modalTitle').textContent = 'Edit Pengguna';
            document.getElementById('editId').value = d.id;
            document.getElementById('nama').value = d.nama;
            document.getElementById('email').value = d.email;
            document.getElementById('password').value = '';
            document.getElementById('role').value = d.role;
            document.getElementById('status').value = d.status;
            document.getElementById('passRequired').style.display = 'none';
            document.getElementById('passHint').style.display = '';
            clearErrors();
            new bootstrap.Modal(document.getElementById('modalForm')).show();
        });
}

function deletePengguna(id, nama) {
    Swal.fire({
        title: 'Hapus Pengguna?',
        html: `Pengguna <strong>${nama}</strong> akan dihapus permanen.`,
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
    document.querySelectorAll('.form-control, .form-select').forEach(el => {
        el.classList.remove('is-invalid', 'is-valid');
    });
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

// Reset is-invalid saat user mengetik
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#formPengguna .form-control, #formPengguna .form-select').forEach(el => {
        el.addEventListener('input', function () {
            this.classList.remove('is-invalid');
            const errEl = document.getElementById('err_' + this.id);
            if (errEl) errEl.textContent = '';
        });
        el.addEventListener('change', function () {
            this.classList.remove('is-invalid');
            const errEl = document.getElementById('err_' + this.id);
            if (errEl) errEl.textContent = '';
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/holykun/Documents/File PHP Laravel/belajar_php/Layanan Pengaduan/pengaduan-app/resources/views/master/pengguna/index.blade.php ENDPATH**/ ?>