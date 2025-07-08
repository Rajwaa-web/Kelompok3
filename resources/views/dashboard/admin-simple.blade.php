<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Perpustakaan Kampus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-book-open me-2"></i>Perpustakaan Kampus - Admin
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="/dashboard">Dashboard</a>
                <a class="nav-link" href="/admin/books">Kelola Buku</a>
                <a class="nav-link" href="/admin/users">Kelola User</a>
                <a class="nav-link" href="/admin/borrowings">Peminjaman</a>
                <a class="nav-link" href="/admin/categories">Kategori</a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-shield me-1"></i>{{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
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
                    Admin Dashboard
                </h2>
                <p class="text-muted">Selamat datang, {{ auth()->user()->name }}! Kelola perpustakaan dengan mudah.</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Total Buku</h5>
                                <h3 class="mb-0">{{ $totalBooks }}</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-book fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Total Pengguna</h5>
                                <h3 class="mb-0">{{ $totalUsers }}</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Sedang Dipinjam</h5>
                                <h3 class="mb-0">{{ $activeBorrowings }}</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-book-reader fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="card-title">Terlambat</h5>
                                <h3 class="mb-0">{{ $overdueBorrowings }}</h3>
                            </div>
                            <div class="ms-3">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity and Popular Books -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Peminjaman Terbaru
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($recentBorrowings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Pengguna</th>
                                            <th>Buku</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Batas Kembali</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBorrowings as $borrowing)
                                        <tr>
                                            <td>{{ $borrowing->user->name }}</td>
                                            <td>{{ $borrowing->book->title }}</td>
                                            <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                            <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $borrowing->status === 'borrowed' ? 'warning' : 'success' }}">
                                                    {{ ucfirst($borrowing->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Belum ada peminjaman.</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-star me-2"></i>
                            Buku Populer
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($popularBooks->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($popularBooks as $book)
                                <div class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ $book->title }}</div>
                                        <small class="text-muted">{{ $book->author }}</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">{{ $book->borrowings_count }}</span>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">Tidak ada data buku populer.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-tools me-2"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="d-grid">
                                    <a href="/admin/books" class="btn btn-outline-primary">
                                        <i class="fas fa-book me-2"></i>Kelola Buku
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="d-grid">
                                    <a href="/admin/users" class="btn btn-outline-success">
                                        <i class="fas fa-users me-2"></i>Kelola Pengguna
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="d-grid">
                                    <a href="/admin/borrowings" class="btn btn-outline-warning">
                                        <i class="fas fa-book-reader me-2"></i>Kelola Peminjaman
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="d-grid">
                                    <a href="/admin/categories" class="btn btn-outline-info">
                                        <i class="fas fa-tags me-2"></i>Kelola Kategori
                                    </a>
                                </div>
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
