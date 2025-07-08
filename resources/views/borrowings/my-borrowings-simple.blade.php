<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya - Perpustakaan Kampus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-book-open me-2"></i>Perpustakaan Kampus
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/dashboard">Dashboard</a>
                <a class="nav-link" href="/books">Daftar Buku</a>
                <a class="nav-link active" href="/my-borrowings">Peminjaman Saya</a>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
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
                <h2><i class="fas fa-book-reader me-2"></i>Peminjaman Saya</h2>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Active Borrowings -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>Sedang Dipinjam
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($activeBorrowings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Judul Buku</th>
                                            <th>Pengarang</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Batas Kembali</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeBorrowings as $borrowing)
                                        <tr>
                                            <td>
                                                <strong>{{ $borrowing->book->title }}</strong>
                                            </td>
                                            <td>{{ $borrowing->book->author }}</td>
                                            <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $borrowing->due_date < now() ? 'danger' : 'warning' }}">
                                                    {{ $borrowing->due_date->format('d M Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($borrowing->due_date < now())
                                                    <span class="badge bg-danger">Terlambat</span>
                                                @else
                                                    <span class="badge bg-success">Aktif</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form method="POST" action="/borrowings/{{ $borrowing->id }}/return" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-undo me-1"></i>Kembalikan
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada buku yang sedang dipinjam</h5>
                                <p class="text-muted">Silakan pinjam buku dari <a href="/books">daftar buku</a>.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowing History -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Riwayat Peminjaman
                        </h5>
                    </div>
                    <div class="card-body">
                        @if($history->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Judul Buku</th>
                                            <th>Pengarang</th>
                                            <th>Tanggal Pinjam</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($history as $borrowing)
                                        <tr>
                                            <td>
                                                <strong>{{ $borrowing->book->title }}</strong>
                                            </td>
                                            <td>{{ $borrowing->book->author }}</td>
                                            <td>{{ $borrowing->borrowed_at->format('d M Y') }}</td>
                                            <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('d M Y') : '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $borrowing->status === 'returned' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($borrowing->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if($history->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $history->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada riwayat peminjaman</h5>
                                <p class="text-muted">Riwayat peminjaman akan muncul setelah Anda meminjam buku.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
