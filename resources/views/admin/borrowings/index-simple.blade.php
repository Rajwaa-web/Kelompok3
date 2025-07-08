<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Peminjaman - Admin Perpustakaan</title>
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
                <a class="nav-link" href="/dashboard">Dashboard</a>
                <a class="nav-link" href="/admin/books">Kelola Buku</a>
                <a class="nav-link" href="/admin/users">Kelola User</a>
                <a class="nav-link active" href="/admin/borrowings">Peminjaman</a>
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
                <h2><i class="fas fa-book-reader me-2"></i>Kelola Peminjaman</h2>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="row mb-3">
            <div class="col-12">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link active" href="#all" data-bs-toggle="pill">Semua</a>
                </ul>
            </div>
        </div>

        <!-- Borrowings Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Batas Kembali</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($borrowings as $borrowing)
                                    <tr class="{{ $borrowing->isOverdue() ? 'table-warning' : '' }}">
                                        <td>{{ $borrowing->id }}</td>
                                        <td>
                                            <strong>{{ $borrowing->user->name }}</strong>
                                            <br><small class="text-muted">{{ $borrowing->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $borrowing->book->title }}</strong>
                                            <br><small class="text-muted">{{ $borrowing->book->author }}</small>
                                        </td>
                                        <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $borrowing->due_date < now() && $borrowing->status === 'borrowed' ? 'danger' : 'info' }}">
                                                {{ $borrowing->due_date->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $borrowing->returned_at ? $borrowing->returned_at->format('d M Y') : '-' }}
                                        </td>
                                        <td>
                                            @if($borrowing->status === 'borrowed')
                                                @if($borrowing->due_date < now())
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-warning">Dipinjam</span>
                                                @endif
                                            @else
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($borrowing->fine_amount > 0)
                                                <span class="text-danger">Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($borrowings->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $borrowings->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4>{{ $borrowings->total() }}</h4>
                        <p class="mb-0">Total Peminjaman</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h4>{{ $borrowings->where('status', 'borrowed')->count() }}</h4>
                        <p class="mb-0">Sedang Dipinjam</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h4>{{ $borrowings->filter(function($b) { return $b->isOverdue(); })->count() }}</h4>
                        <p class="mb-0">Terlambat</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>{{ $borrowings->where('status', 'returned')->count() }}</h4>
                        <p class="mb-0">Dikembalikan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
