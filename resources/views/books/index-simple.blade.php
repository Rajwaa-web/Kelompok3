<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Perpustakaan Kampus</title>
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
                <a class="nav-link active" href="/books">Daftar Buku</a>
                <a class="nav-link" href="/my-borrowings">Peminjaman Saya</a>
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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-book me-2"></i>Daftar Buku</h2>
                </div>
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

        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" action="/books">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Cari judul buku, pengarang..." 
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <form method="GET" action="/books">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select class="form-select" name="category" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="row">
            @if($books->count() > 0)
                @foreach($books as $book)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">
                                <strong>Pengarang:</strong> {{ $book->author }}<br>
                                <strong>Kategori:</strong> {{ $book->category->name }}<br>
                                <strong>Tahun Terbit:</strong> {{ $book->publication_year }}<br>
                                <strong>Stok:</strong> 
                                <span class="badge bg-{{ $book->available_stock > 0 ? 'success' : 'danger' }}">
                                    {{ $book->available_stock }} tersedia
                                </span>
                            </p>
                            @if($book->description)
                                <p class="card-text">
                                    {{ Str::limit($book->description, 100) }}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="/books/{{ $book->id }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                                @if($book->available_stock > 0)
                                    <form method="POST" action="/books/{{ $book->id }}/borrow" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-book me-1"></i>Pinjam
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        <i class="fas fa-times me-1"></i>Tidak Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak ada buku ditemukan</h4>
                        <p class="text-muted">Coba ubah kata kunci pencarian atau filter kategori.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($books->hasPages())
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $books->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
