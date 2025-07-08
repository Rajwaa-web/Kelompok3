<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Darane Library</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-book-open me-2"></i>The Darane Library
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown">
                        Login
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/login">
                            <i class="fas fa-user me-2"></i>Login User
                        </a></li>
                        <li><a class="dropdown-item" href="/admin/login">
                            <i class="fas fa-user-shield me-2"></i>Login Admin
                        </a></li>
                    </ul>
                </div>
                <a class="nav-link" href="/register">Register</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="d-flex align-items-center justify-content-center text-center text-white" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2070&auto=format&fit=crop'); background-size: cover; min-height: calc(100vh - 56px);">
            <div>
                <h1 class="display-3 fw-bold">The Darane Library Digital</h1>
                <p class="lead col-lg-8 mx-auto">Temukan dunia pengetahuan di ujung jari Anda. Pinjam, baca, dan kembalikan buku dengan mudah melalui platform digital kami.</p>
                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                    @guest
                        <a href="/login-selection" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Sistem
                        </a>
                        <a href="/register" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i>Daftar Akun
                        </a>
                    @else
                        <a href="/dashboard" class="btn btn-primary btn-lg px-4 gap-3">Dashboard</a>
                        <a href="/books" class="btn btn-outline-light btn-lg px-4">Lihat Buku</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
