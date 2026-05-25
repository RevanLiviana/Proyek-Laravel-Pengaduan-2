@extends('layouts.master')
@section('title', 'Laporan Pengaduan')
@section('content')
<div class="container-fluid px-4">
    <h4 class="fw-bold mb-1">Laporan Pengaduan</h4>
    <p class="text-muted mb-4">Sampaikan pengaduan Anda</p>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('laporan.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Laporan <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Judul singkat pengaduan">
                    @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                            <option value="{{ $k->nama_kategori }}" {{ old('kategori')==$k->nama_kategori?'selected':'' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Kejadian <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}">
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" placeholder="Lokasi kejadian">
                    @error('lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Jelaskan pengaduan secara detail...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary px-4">Kirim Laporan</button>
            </form>
        </div>
    </div>
</div>
@endsection
