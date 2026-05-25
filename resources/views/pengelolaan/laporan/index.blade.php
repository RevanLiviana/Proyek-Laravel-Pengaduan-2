@extends('layouts.master')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0">Manajemen Laporan</h4>
            <small class="text-muted">Kelola semua laporan pengaduan masuk</small>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari judul laporan..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="Dikirim" {{ request('status')=='menunggu'?'selected':'' }}>Menunggu</option>
                <option value="Diproses" {{ request('status')=='diproses'?'selected':'' }}>Diproses</option>
                <option value="Selesai" {{ request('status')=='selesai'?'selected':'' }}>Selesai</option>
                <option value="Ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('pengelolaan.laporan.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporans as $i => $laporan)
                    <tr>
                        <td>{{ $laporans->firstItem() + $i }}</td>
                        <td>{{ $laporan->judul }}</td>
                        <td>{{ $laporan->kategori?->nama ?? $laporan->kategori }}</td>
                        <td>{{ $laporan->lokasi ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $badge = match($laporan->status) {
                                    'Dikirim' => 'primary',
                                    'Diproses' => 'info',
                                    'Selesai'  => 'success',
                                    'Ditolak'  => 'danger',
                                    default    => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($laporan->status) }}</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" onclick="lihatLaporan({{ $laporan->id }})">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="hapusLaporan({{ $laporan->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $laporans->withQueryString()->links() }}
        </div>
    </div>
</div>

{{-- Modal Detail --}}
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Laporan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailBody">Loading...</div>
            <div class="modal-footer">
                <select id="statusSelect" class="form-select w-auto">
                    <option value="Dikirim">Menunggu</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
                <button class="btn btn-primary" onclick="simpanStatus()">Simpan Status</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentId = null;

function lihatLaporan(id) {
    currentId = id;
    fetch(`/pengelolaan/laporan/${id}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('detailBody').innerHTML = `
                <p><strong>Judul:</strong> ${data.judul}</p>
                <p><strong>Deskripsi:</strong> ${data.deskripsi}</p>
                <p><strong>Kategori:</strong> ${data.kategori?.nama ?? data.kategori ?? '-'}</p>
                <p><strong>Lokasi:</strong> ${data.lokasi ?? '-'}</p>
                <p><strong>Tanggal:</strong> ${data.tanggal}</p>
                <p><strong>Status:</strong> ${data.status}</p>
            `;
            document.getElementById('statusSelect').value = data.status;
            new bootstrap.Modal(document.getElementById('modalDetail')).show();
        });
}

function simpanStatus() {
    const status = document.getElementById('statusSelect').value;
    fetch(`/pengelolaan/laporan/${currentId}/status`, {
        method: 'PATCH',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN': '{{ csrf_token() }}'},
        body: JSON.stringify({ status })
    }).then(r => r.json()).then(data => {
        alert(data.message);
        location.reload();
    });
}

function hapusLaporan(id) {
    if (!confirm('Yakin ingin menghapus laporan ini?')) return;
    fetch(`/pengelolaan/laporan/${id}`, {
        method: 'DELETE',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    }).then(r => r.json()).then(data => {
        alert(data.message);
        location.reload();
    });
}
</script>
@endpush
@endsection