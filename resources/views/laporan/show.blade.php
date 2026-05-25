<!DOCTYPE html>
<html>
<head>
    <title>Detail Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Detail Laporan</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $laporan->judul }}</h4>
            <p><b>Deskripsi:</b> {{ $laporan->deskripsi }}</p>
            <p><b>Kategori:</b> {{ $laporan->kategori }}</p>
            <p><b>Lokasi:</b> {{ $laporan->lokasi }}</p>
            <p><b>Tanggal:</b> {{ $laporan->tanggal }}</p>
            <p><b>Status:</b> {{ $laporan->status }}</p>
        </div>
    </div>

    <br>
    <a href="/laporan" class="btn btn-secondary">Kembali</a>

</body>
</html>