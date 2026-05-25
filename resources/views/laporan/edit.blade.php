<!DOCTYPE html>
<html>
<head>
    <title>Edit Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Edit Laporan</h2>

    <form method="POST" action="/laporan/{{ $laporan->id }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ $laporan->judul }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $laporan->deskripsi }}</textarea>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="kategori" value="{{ $laporan->kategori }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" name="lokasi" value="{{ $laporan->lokasi }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="{{ $laporan->tanggal }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option {{ $laporan->status == 'Dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option {{ $laporan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/laporan" class="btn btn-secondary">Kembali</a>
    </form>

</body>
</html>