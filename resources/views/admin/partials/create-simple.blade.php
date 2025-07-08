<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - Admin Perpustakaan</title>
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
                <a class="nav-link active" href="/admin/books">Kelola Buku</a>
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

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/admin/books">Kelola Buku</a></li>
                        <li class="breadcrumb-item active">Tambah Buku</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-plus me-2"></i>Tambah Buku Baru
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="/admin/books">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="author" class="form-label">Pengarang <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="publisher" class="form-label">Penerbit</label>
                                        <input type="text" class="form-control" id="publisher" name="publisher" value="{{ old('publisher') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="publication_year" class="form-label">Tahun Terbit</label>
                                        <input type="number" class="form-control" id="publication_year" name="publication_year" 
                                               value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', 1) }}" min="1" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="/admin/books" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Buku
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
