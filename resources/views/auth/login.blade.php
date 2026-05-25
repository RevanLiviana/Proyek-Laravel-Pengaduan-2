<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – SIMPADU</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #F1F5F9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.08); padding: 40px; width: 100%; max-width: 420px; }
        .brand-icon { width: 52px; height: 52px; background: #3B5BDB; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 24px; margin: 0 auto 12px; }
        .btn-login { background: #3B5BDB; color: #fff; border: none; border-radius: 8px; padding: 11px; font-weight: 600; width: 100%; font-size: 15px; }
        .btn-login:hover { background: #2F4AC0; color: #fff; }
        .form-control { border-radius: 8px; padding: 10px 12px; border-color: #E2E8F0; }
        .form-control:focus { border-color: #3B5BDB; box-shadow: 0 0 0 3px rgba(59,91,219,.12); }
        .form-label { font-size: 13px; font-weight: 600; color: #374151; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="text-center mb-4">
        <div class="brand-icon"><i class="bi bi-megaphone-fill"></i></div>
        <h5 class="fw-700 mb-1">SIMPADU</h5>
        <p class="text-muted" style="font-size:13px;">Sistem Pengaduan Kampus</p>
    </div>

    @if($errors->any())
    <div class="alert alert-danger py-2 px-3" style="font-size:13px;">
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="email@kampus.ac.id" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">Masuk</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
