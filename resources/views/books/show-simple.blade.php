<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book->title }} - Perpustakaan Kampus</title>
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
                <a class="nav-link" href="/books">Buku</a>
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

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/books">Buku</a></li>
                        <li class="breadcrumb-item active">{{ $book->title }}</li>
                    </ol>
                </nav>
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

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if($book->cover_image)
                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="img-fluid mb-3" style="max-height: 300px;">
                        @else
                            <div class="bg-light p-5 mb-3" style="height: 300px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-book fa-4x text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="d-grid gap-2">
                            @if($book->available_stock > 0)
                                <form method="POST" action="/books/{{ $book->id }}/borrow">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-book me-2"></i>Pinjam Buku
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="fas fa-times me-2"></i>Tidak Tersedia
                                </button>
                            @endif
                            <a href="/books" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ $book->title }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Pengarang:</strong></div>
                            <div class="col-sm-9">{{ $book->author }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>ISBN:</strong></div>
                            <div class="col-sm-9">{{ $book->isbn }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Kategori:</strong></div>
                            <div class="col-sm-9">
                                <span class="badge bg-primary">{{ $book->category->name }}</span>
                            </div>
                        </div>
                        
                        @if($book->publisher)
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Penerbit:</strong></div>
                            <div class="col-sm-9">{{ $book->publisher }}</div>
                        </div>
                        @endif
                        
                        @if($book->publication_year)
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Tahun Terbit:</strong></div>
                            <div class="col-sm-9">{{ $book->publication_year }}</div>
                        </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-sm-3"><strong>Stok:</strong></div>
                            <div class="col-sm-9">
                                <span class="badge bg-{{ $book->available_stock > 0 ? 'success' : 'danger' }}">
                                    {{ $book->available_stock }} dari {{ $book->stock }} tersedia
                                </span>
                            </div>
                        </div>
                        
                        @if($book->description)
                        <div class="row">
                            <div class="col-12">
                                <h5>Deskripsi</h5>
                                <p class="text-muted">{{ $book->description }}</p>
                            </div>
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
