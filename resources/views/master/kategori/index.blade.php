@extends('layouts.master')

@section('title', 'Kategori Pengaduan')

@section('breadcrumb')
    <span>Data Master</span>
    <span class="sep">›</span>
    <span class="current">Kategori Pengaduan</span>
@endsection

@section('content')

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <h6 class="fw-bold mb-1" style="font-size:15px;">Kategori Pengaduan</h6>
            <p class="mb-0 text-muted" style="font-size:12.5px;">Kelola kategori agar laporan terstruktur</p>
        </div>
        <div class="d-flex gap-2">
            <div class="search-wrap">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari kategori..."
                       style="width:220px;" oninput="filterTable(this.value)">
            </div>
            <button class="btn-outline-custom" onclick="loadTable()">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
            <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="openAdd()">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <div id="tableContainer">
        <div class="table-responsive table-wrapper" id="dataTableWrap">
    <table class="table" id="dataTable">
        <thead>
            <tr>
                <th style="width:50px;">NO</th>
                <th>NAMA KATEGORI</th>
                <th>IKON</th>
                <th>DESKRIPSI</th>
                <th>LAPORAN</th>
                <th>STATUS</th>
                <th style="width:100px;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategoris as $i => $k)
            <tr class="data-row">
                <td class="text-muted">{{ $kategoris->firstItem() + $i }}</td>
                <td class="fw-semibold">{{ $k->nama_kategori }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded"
                              style="width:32px;height:32px;background:#EEF2FF;color:#3B5BDB;font-size:16px;">
                            <i class="bi bi-{{ $k->ikon ?? 'tag' }}"></i>
                        </span>
                        <code style="font-size:11px;color:#64748B;">{{ $k->ikon ?? 'tag' }}</code>
                    </div>
                </td>
                <td class="text-muted">{{ $k->deskripsi ?? '-' }}</td>
                <td>
                    <span class="fw-semibold">{{ $k->laporan_count }}</span>
                    <span class="text-muted" style="font-size:12px;"> laporan</span>
                </td>
                <td>
                    <span class="badge-status {{ $k->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                        {{ ucfirst($k->status) }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn-action edit" onclick="openEdit({{ $k->id }})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-action del" onclick="deleteKategori({{ $k->id }}, '{{ addslashes($k->nama_kategori) }}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="icon"><i class="bi bi-tag-fill"></i></div>
                        <h6>Belum ada kategori</h6>
                        <p>Klik tombol Tambah Kategori untuk memulai</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-between px-4 py-3">
    <small class="text-muted">
        Menampilkan {{ $kategoris->firstItem() ?? 0 }}–{{ $kategoris->lastItem() ?? 0 }}
        dari {{ $kategoris->total() }} data
    </small>
    {{ $kategoris->links() }}
</div>
    </div>
</div>

<!-- ══ MODAL FORM ══ -->
<div class="modal fade" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title fw-bold" id="modalTitle">Tambah Kategori</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formKategori" novalidate>
                    <input type="hidden" id="editId">

                    {{-- VALIDASI 1: Nama Kategori --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori"
                               placeholder="Contoh: Fasilitas, Akademik..." required
                               maxlength="100">
                        <div class="invalid-feedback" id="err_nama_kategori"></div>
                        {{-- Petunjuk validasi untuk user --}}
                        <div class="form-text" id="hint_nama_kategori">
                            <i class="bi bi-info-circle"></i> Wajib diisi, minimal 3 karakter, maksimal 100 karakter.
                        </div>
                    </div>

                    {{-- VALIDASI 2: Ikon --}}
                    <div class="mb-3">
                        <label class="form-label">Ikon <small class="text-muted fw-normal">(Bootstrap Icons)</small></label>
                        <div class="input-group">
                            <span class="input-group-text" style="border-radius:8px 0 0 8px;">
                                <i id="iconPreview" class="bi bi-tag fs-5"></i>
                            </span>
                            <input type="text" class="form-control" id="ikon"
                                   placeholder="tag, house, gear ..."
                                   style="border-radius:0 8px 8px 0;"
                                   oninput="previewIcon(this.value)"
                                   maxlength="50">
                        </div>
                        <div class="invalid-feedback d-block" id="err_ikon"></div>
                        <div class="form-text">Nama icon Bootstrap Icons, contoh: <code>tag</code>, <code>gear</code>, <code>house</code></div>
                    </div>

                    {{-- VALIDASI 3: Deskripsi --}}
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" rows="3"
                                  placeholder="Keterangan kategori..."
                                  maxlength="255"></textarea>
                        <div class="invalid-feedback" id="err_deskripsi"></div>
                        <div class="form-text" id="charCount_deskripsi">0 / 255 karakter</div>
                    </div>

                    {{-- Status --}}
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
                <button type="button" class="btn-primary-custom" id="btnSave" onclick="saveKategori()">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const BASE_URL = '{{ route("master.kategori.index") }}';

// ══════════════════════════════════════════════════════════
// CLIENT-SIDE VALIDATION
// Fungsi utama validasi sebelum data dikirim ke server
// ══════════════════════════════════════════════════════════
function validateForm() {
    clearErrors();
    let isValid = true;

    // ── VALIDASI 1: Nama Kategori ──────────────────────────
    // Aturan: wajib diisi, minimal 3 karakter, maksimal 100 karakter
    const namaKategori = document.getElementById('nama_kategori').value.trim();
    if (namaKategori === '') {
        setError('nama_kategori', 'Nama kategori wajib diisi.');
        isValid = false;
    } else if (namaKategori.length < 3) {
        setError('nama_kategori', 'Nama kategori minimal 3 karakter.');
        isValid = false;
    } else if (namaKategori.length > 100) {
        setError('nama_kategori', 'Nama kategori maksimal 100 karakter.');
        isValid = false;
    } else {
        setValid('nama_kategori');
    }

    // ── VALIDASI 2: Ikon ───────────────────────────────────
    // Aturan: jika diisi, hanya boleh huruf, angka, dan tanda hubung (-)
    // Format Bootstrap Icons: kata-kata, contoh: house-fill, arrow-up
    const ikon = document.getElementById('ikon').value.trim();
    const ikonRegex = /^[a-z0-9\-]+$/;
    if (ikon !== '' && !ikonRegex.test(ikon)) {
        setError('ikon', 'Format ikon tidak valid. Gunakan huruf kecil, angka, dan tanda hubung. Contoh: house-fill');
        isValid = false;
    } else if (ikon.length > 50) {
        setError('ikon', 'Nama ikon maksimal 50 karakter.');
        isValid = false;
    } else {
        setValid('ikon');
    }

    // ── VALIDASI 3: Deskripsi ──────────────────────────────
    // Aturan: jika diisi, maksimal 255 karakter
    const deskripsi = document.getElementById('deskripsi').value.trim();
    if (deskripsi.length > 255) {
        setError('deskripsi', 'Deskripsi maksimal 255 karakter.');
        isValid = false;
    } else {
        setValid('deskripsi');
    }

    // ── VALIDASI 4: Status ─────────────────────────────────
    // Aturan: wajib dipilih
    const status = document.getElementById('status').value;
    if (status === '' || status === null) {
        setError('status', 'Status wajib dipilih.');
        isValid = false;
    } else {
        setValid('status');
    }

    return isValid;
}

// ── Helper: set field error ────────────────────────────────
function setError(fieldId, message) {
    const el = document.getElementById(fieldId);
    const errEl = document.getElementById('err_' + fieldId);
    if (el) el.classList.add('is-invalid');
    if (errEl) errEl.textContent = message;
}

// ── Helper: set field valid ────────────────────────────────
function setValid(fieldId) {
    const el = document.getElementById(fieldId);
    if (el) {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
    }
}

// ══════════════════════════════════════════════════════════
// FUNGSI UTAMA SIMPAN — validasi client dulu, baru kirim
// ══════════════════════════════════════════════════════════
function saveKategori() {
    // Jalankan validasi client-side dulu
    if (!validateForm()) {
        // Jika ada error, hentikan proses — jangan kirim ke server
        return;
    }

    // Jika lolos validasi client-side, baru kirim ke server
    const id = document.getElementById('editId').value;
    const payload = {
        nama_kategori: document.getElementById('nama_kategori').value.trim(),
        ikon: document.getElementById('ikon').value.trim(),
        deskripsi: document.getElementById('deskripsi').value.trim(),
        status: document.getElementById('status').value,
        _token: '{{ csrf_token() }}'
    };

    const url  = id ? `${BASE_URL}/${id}` : BASE_URL;
    const meth = id ? 'put' : 'post';

    // Nonaktifkan tombol saat proses kirim
    const btnSave = document.getElementById('btnSave');
    btnSave.disabled = true;
    btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';

    axios[meth](url, payload)
        .then(res => {
            bootstrap.Modal.getInstance(document.getElementById('modalForm')).hide();
            toast('success', res.data.message);
            loadTable();
        })
        .catch(err => {
            // Validasi server-side (422) — tampilkan error dari Laravel
            if (err.response?.status === 422) {
                showErrors(err.response.data.errors);
            } else {
                toast('error', 'Terjadi kesalahan server.');
            }
        })
        .finally(() => {
            btnSave.disabled = false;
            btnSave.innerHTML = '<i class="bi bi-check-lg"></i> Simpan';
        });
}

// ══════════════════════════════════════════════════════════
// FUNGSI LAINNYA (tidak diubah dari versi sebelumnya)
// ══════════════════════════════════════════════════════════
function openAdd() {
    document.getElementById('modalTitle').textContent = 'Tambah Kategori';
    document.getElementById('editId').value = '';
    document.getElementById('formKategori').reset();
    previewIcon('tag');
    clearErrors();
    // Reset status ke placeholder
    document.getElementById('status').value = '';
}

function openEdit(id) {
    axios.get(`${BASE_URL}/${id}`)
        .then(res => {
            const d = res.data;
            document.getElementById('modalTitle').textContent = 'Edit Kategori';
            document.getElementById('editId').value = d.id;
            document.getElementById('nama_kategori').value = d.nama_kategori;
            document.getElementById('ikon').value = d.ikon ?? '';
            document.getElementById('deskripsi').value = d.deskripsi ?? '';
            document.getElementById('status').value = d.status;
            previewIcon(d.ikon ?? 'tag');
            clearErrors();
            new bootstrap.Modal(document.getElementById('modalForm')).show();
        });
}

function deleteKategori(id, nama) {
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Kategori <strong>${nama}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya, Hapus',
    }).then(r => {
        if (!r.isConfirmed) return;
        axios.delete(`${BASE_URL}/${id}`, { data: { _token: '{{ csrf_token() }}' } })
            .then(res => { toast('success', res.data.message); loadTable(); })
            .catch(err => toast('error', err.response?.data?.message ?? 'Gagal menghapus.'));
    });
}

function loadTable() {
    fetch(window.location.href)
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            document.getElementById('tableContainer').innerHTML =
                doc.getElementById('tableContainer').innerHTML;
        });
}

function filterTable(q) {
    const rows = document.querySelectorAll('#dataTable tbody tr.data-row');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
}

function previewIcon(val) {
    const el = document.getElementById('iconPreview');
    el.className = `bi bi-${val || 'tag'} fs-5`;
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
        if (el) {
            el.classList.remove('is-valid');
            el.classList.add('is-invalid');
        }
        if (errEl) errEl.textContent = errors[field][0];
    });
}

// ── Counter karakter untuk deskripsi ─────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const deskripsiEl = document.getElementById('deskripsi');
    const charCountEl = document.getElementById('charCount_deskripsi');
    if (deskripsiEl && charCountEl) {
        deskripsiEl.addEventListener('input', function () {
            const len = this.value.length;
            charCountEl.textContent = `${len} / 255 karakter`;
            charCountEl.style.color = len > 230 ? '#EF4444' : '';
        });
    }

    // Reset is-invalid saat user mulai mengetik
    document.querySelectorAll('#formKategori .form-control, #formKategori .form-select').forEach(el => {
        el.addEventListener('input', function () {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const errEl = document.getElementById('err_' + this.id);
                if (errEl) errEl.textContent = '';
            }
        });
        el.addEventListener('change', function () {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                const errEl = document.getElementById('err_' + this.id);
                if (errEl) errEl.textContent = '';
            }
        });
    });
});
</script>
@endpush