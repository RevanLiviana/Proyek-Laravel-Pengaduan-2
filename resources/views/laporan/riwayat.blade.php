@extends('layouts.master')
@section('title', 'Riwayat Laporan')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Laporan</h4>
            <p class="text-muted mb-0">Laporan yang pernah Anda kirimkan</p>
        </div>
        <a href="{{ route('laporan.index') }}" class="btn btn-primary">+ Buat Laporan</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
                    @forelse($laporans as $i => $l)
                    <tr>
                        <td>{{ $laporans->firstItem() + $i }}</td>
                        <td>{{ $l->judul }}</td>
                        <td>{{ $l->kategori }}</td>
                        <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $badge = match($l->status) {
                                    'Dikirim'  => 'primary',
                                    'Diproses' => 'info',
                                    'Selesai'  => 'success',
                                    'Ditolak'  => 'danger',
                                    default    => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ $l->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada laporan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">{{ $laporans->links() }}</div>
    </div>
</div>
@endsection
