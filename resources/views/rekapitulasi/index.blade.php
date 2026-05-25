@extends('layouts.master')
@section('title', 'Rekapitulasi')
@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-4">Rekapitulasi Laporan</h4>

    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-primary">{{ $total }}</div>
                    <div class="text-muted small">Total</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-info">{{ $dikirim }}</div>
                    <div class="text-muted small">Dikirim</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-warning">{{ $diproses }}</div>
                    <div class="text-muted small">Diproses</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-success">{{ $selesai }}</div>
                    <div class="text-muted small">Selesai</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="fs-2 fw-bold text-danger">{{ $ditolak }}</div>
                    <div class="text-muted small">Ditolak</div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <a href="{{ route('export.data') }}" class="text-white text-decoration-none">
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
                    @forelse($perKategori as $k)
                    <tr><td>{{ $k->kategori }}</td><td>{{ $k->total }}</td></tr>
                    @empty
                    <tr><td colspan="2" class="text-center py-3 text-muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
