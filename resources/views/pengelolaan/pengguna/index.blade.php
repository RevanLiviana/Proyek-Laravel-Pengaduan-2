@extends('layouts.master')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0">Manajemen Pengguna</h4>
            <small class="text-muted">Kelola akun pengguna sistem pengaduan</small>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama / email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="aktif" {{ request('status')=='aktif'?'selected':'' }}>Aktif</option>
                <option value="nonaktif" {{ request('status')=='nonaktif'?'selected':'' }}>Nonaktif</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('pengelolaan.pengguna.index') }}" class="btn btn-secondary">Reset</a>
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
                    @forelse($penggunas as $i => $pengguna)
                    <tr>
                        <td>{{ $penggunas->firstItem() + $i }}</td>
                        <td>{{ $pengguna->name }}</td>
                        <td>{{ $pengguna->email }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($pengguna->role) }}</span></td>
                        <td>
                            <span class="badge bg-{{ $pengguna->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($pengguna->status) }}
                            </span>
                        </td>
                        <td>
                            @if($pengguna->status == 'aktif')
                            <button class="btn btn-sm btn-outline-warning"
                                onclick="ubahStatus({{ $pengguna->id }}, 'nonaktif')">
                                Nonaktifkan
                            </button>
                            @else
                            <button class="btn btn-sm btn-outline-success"
                                onclick="ubahStatus({{ $pengguna->id }}, 'aktif')">
                                Aktifkan
                            </button>
                            @endif
                            <button class="btn btn-sm btn-outline-danger"
                                onclick="hapusPengguna({{ $pengguna->id }})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada pengguna.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $penggunas->withQueryString()->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function ubahStatus(id, status) {
    if (!confirm(`Yakin ingin mengubah status pengguna menjadi ${status}?`)) return;
    fetch(`/pengelolaan/pengguna/${id}/status`, {
        method: 'PATCH',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
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
        headers: {'X-CSRF-TOKEN':'{{ csrf_token() }}'}
    }).then(r => r.json()).then(data => {
        alert(data.message);
        if (data.message.includes('berhasil')) location.reload();
    });
}
</script>
@endpush
@endsection