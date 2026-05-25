@extends('layouts.master')

@section('title', 'Data Petugas')

@section('breadcrumb')
    <span>Data Master</span>
    <span class="sep">›</span>
    <span class="current">Data Petugas</span>
@endsection

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <h6 class="fw-bold mb-1" style="font-size:15px;">Data Petugas</h6>
            <p class="mb-0 text-muted" style="font-size:12.5px;">Kelola petugas yang menangani laporan pengaduan</p>
        </div>
        <div class="d-flex gap-2">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" placeholder="Cari petugas..."
                       style="width:220px;" oninput="filterTable(this.value)">
            </div>
            <button class="btn-outline-custom" onclick="location.reload()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
            <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="openAdd()">
                <i class="bi bi-plus-lg"></i> Tambah Petugas
            </button>
        </div>
    </div>

    <div class="table-responsive table-wrapper">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th style="width:50px;">NO</th>
                    <th>NAMA PETUGAS</th>
                    <th>NIP</th>
                    <th>EMAIL</th>
                    <th>UNIT/BAGIAN</th>
                    <th>TELEPON</th>
                    <th>STATUS</th>
                    <th style="width:100px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugas as $i => $p)
                <tr class="data-row">
                    <td class="text-muted">{{ $petugas->firstItem() + $i }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:32px;height:32px;border-radius:50%;background:#F0FDF4;
                                        color:#16A34A;display:flex;align-items:center;justify-content:center;
                                        font-weight:700;font-size:13px;flex-shrink:0;">
                                {{ strtoupper(substr($p->nama, 0, 1)) }}
                            </div>
                            <span class="fw-semibold">{{ $p->nama }}</span>
                        </div>
                    </td>
                    <td><code style="font-size:12px;color:#64748B;">{{ $p->nip }}</code></td>
                    <td class="text-muted">{{ $p->email }}</td>
                    <td>
                        <span style="padding:3px 10px;border-radius:20px;font-size:12px;font-weight:600;
                                     background:#F0F9FF;color:#0284C7;">
                            {{ $p->unit->nama_unit ?? '-' }}
                        </span>
                    </td>
                    <td class="text-muted">{{ $p->telepon ?? '-' }}</td>
                    <td>
                        <span class="badge-status {{ $p->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn-action edit" onclick="openEdit({{ $p->id }})"><i class="bi bi-pencil"></i></button>
                            <button class="btn-action del" onclick="deletePetugas({{ $p->id }}, '{{ addslashes($p->nama) }}')"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8">
                    <div class="empty-state">
                        <div class="icon"><i class="bi bi-person-vcard-fill"></i></div>
                        <h6>Belum ada petugas</h6>
                        <p>Klik tombol Tambah Petugas untuk memulai</p>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex align-items-center justify-content-between px-4 py-3">
        <small class="text-muted">
            Menampilkan {{ $petugas->firstItem() ?? 0 }}–{{ $petugas->lastItem() ?? 0 }}
            dari {{ $petugas->total() }} data
        </small>
        {{-- FIX: ganti custom pagination --}}
        {{ $petugas->links() }}
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modalTitle">Tambah Petugas</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPetugas" novalidate>
                    <input type="hidden" id="editId">

                    {{-- VALIDASI 1: Nama --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama lengkap petugas" maxlength="100">
                        <div class="invalid-feedback" id="err_nama"></div>
                        <div class="form-text">Wajib diisi, minimal 3 karakter.</div>
                    </div>

                    <div class="row">
                        {{-- VALIDASI 2: NIP --}}
                        <div class="col-6 mb-3">
                            <label class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nip" placeholder="Nomor Induk Pegawai" maxlength="50">
                            <div class="invalid-feedback" id="err_nip"></div>
                            <div class="form-text">Wajib diisi, hanya angka.</div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control" id="telepon" placeholder="08xx" maxlength="20">
                            <div class="invalid-feedback" id="err_telepon"></div>
                        </div>
                    </div>

                    {{-- VALIDASI 3: Email --}}
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" placeholder="email@kampus.ac.id">
                        <div class="invalid-feedback" id="err_email"></div>
                        <div class="form-text">Wajib diisi, format email valid.</div>
                    </div>

                    {{-- VALIDASI 4: Unit --}}
                    <div class="mb-3">
                        <label class="form-label">Unit/Bagian <span class="text-danger">*</span></label>
                        <select class="form-select" id="unit_id">
                            <option value="">-- Pilih Unit --</option>
                            @foreach($units as $u)
                            <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="err_unit_id"></div>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="status">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Non-Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline-custom" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-primary-custom" id="btnSave" onclick="savePetugas()">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const BASE_URL = '{{ route("master.petugas.index") }}';

// ══════════════════════════════════════════════════════════
// CLIENT-SIDE VALIDATION
// ══════════════════════════════════════════════════════════
function validateForm() {
    clearErrors();
    let isValid = true;

    // VALIDASI 1: Nama — wajib diisi, minimal 3 karakter
    const nama = document.getElementById('nama').value.trim();
    if (nama === '') {
        setError('nama', 'Nama petugas wajib diisi.');
        isValid = false;
    } else if (nama.length < 3) {
        setError('nama', 'Nama minimal 3 karakter.');
        isValid = false;
    } else {
        setValid('nama');
    }

    // VALIDASI 2: NIP — wajib diisi, hanya angka
    const nip = document.getElementById('nip').value.trim();
    const nipRegex = /^[0-9]+$/;
    if (nip === '') {
        setError('nip', 'NIP wajib diisi.');
        isValid = false;
    } else if (!nipRegex.test(nip)) {
        setError('nip', 'NIP hanya boleh berisi angka.');
        isValid = false;
    } else {
        setValid('nip');
    }

    // VALIDASI 3: Email — wajib diisi, format valid
    const email = document.getElementById('email').value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === '') {
        setError('email', 'Email wajib diisi.');
        isValid = false;
    } else if (!emailRegex.test(email)) {
        setError('email', 'Format email tidak valid.');
        isValid = false;
    } else {
        setValid('email');
    }

    // VALIDASI 4: Unit — wajib dipilih
    const unit_id = document.getElementById('unit_id').value;
    if (unit_id === '') {
        setError('unit_id', 'Unit/Bagian wajib dipilih.');
        isValid = false;
    } else {
        setValid('unit_id');
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

function savePetugas() {
    if (!validateForm()) return;

    const id = document.getElementById('editId').value;
    const payload = {
        nama: document.getElementById('nama').value.trim(),
        nip: document.getElementById('nip').value.trim(),
        email: document.getElementById('email').value.trim(),
        telepon: document.getElementById('telepon').value.trim(),
        unit_id: document.getElementById('unit_id').value,
        status: document.getElementById('status').value,
        _token: '{{ csrf_token() }}'
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
    document.getElementById('modalTitle').textContent = 'Tambah Petugas';
    document.getElementById('editId').value = '';
    document.getElementById('formPetugas').reset();
    clearErrors();
}

function openEdit(id) {
    axios.get(`${BASE_URL}/${id}`)
        .then(res => {
            const d = res.data;
            document.getElementById('modalTitle').textContent = 'Edit Petugas';
            document.getElementById('editId').value = d.id;
            document.getElementById('nama').value = d.nama;
            document.getElementById('nip').value = d.nip;
            document.getElementById('email').value = d.email;
            document.getElementById('telepon').value = d.telepon ?? '';
            document.getElementById('unit_id').value = d.unit_id;
            document.getElementById('status').value = d.status;
            clearErrors();
            new bootstrap.Modal(document.getElementById('modalForm')).show();
        });
}

function deletePetugas(id, nama) {
    Swal.fire({
        title: 'Hapus Petugas?',
        html: `Petugas <strong>${nama}</strong> akan dihapus.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus',
    }).then(r => {
        if (!r.isConfirmed) return;
        axios.delete(`${BASE_URL}/${id}`, { data: { _token: '{{ csrf_token() }}' } })
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
</script>
@endpush