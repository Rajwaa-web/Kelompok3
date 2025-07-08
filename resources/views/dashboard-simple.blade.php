<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - The Darane Library</title>
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
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="/logout" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </h2>
                <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="card-title">
                                    <i class="fas fa-book-open me-2"></i>
                                    Selamat Datang di The Darane Library Digital
                                </h4>
                                <p class="card-text mb-0">
                                    Jelajahi koleksi buku digital kami dan nikmati kemudahan meminjam buku secara online.
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="fas fa-graduation-cap fa-4x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistik Peminjaman
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1">{{ $borrowedBooks ?? 0 }}</h4>
                                    <small class="text-muted">Sedang Dipinjam</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success mb-1">{{ $totalBorrowings ?? 0 }}</h4>
                                <small class="text-muted">Total Peminjaman</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Informasi Akun
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Email:</strong>
                            </div>
                            <div class="col-sm-6">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Bergabung:</strong>
                            </div>
                            <div class="col-sm-6">
                                {{ auth()->user()->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>