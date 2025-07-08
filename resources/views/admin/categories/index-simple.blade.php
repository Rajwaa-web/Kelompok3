<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori - Admin Perpustakaan</title>
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
                <a class="nav-link" href="/admin/borrowings">Peminjaman</a>
                <a class="nav-link active" href="/admin/categories">Kategori</a>
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
                <h2><i class="fas fa-tags me-2"></i>Kelola Kategori</h2>
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
            <!-- Add Category Form -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-plus me-2"></i>Tambah Kategori
                        </h5>
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

                        <form method="POST" action="/admin/categories">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Simpan Kategori
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories List -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list me-2"></i>Daftar Kategori
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah Buku</th>
                                        <th>Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>
                                            {{ Str::limit($category->description, 50) }}
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $category->books_count }}</span>
                                        </td>
                                        <td>{{ $category->created_at->format('d M Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button class="btn btn-outline-warning" title="Edit" onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Hapus" onclick="confirmDeleteCategory({{ $category->id }}, '{{ $category->name }}', {{ $category->books_count }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($categories->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $categories->links() }}
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
                        <h4>{{ $categories->total() }}</h4>
                        <p class="mb-0">Total Kategori</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>{{ $categories->sum('books_count') }}</h4>
                        <p class="mb-0">Total Buku</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4>{{ $categories->where('books_count', '>', 0)->count() }}</h4>
                        <p class="mb-0">Kategori Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h4>{{ $categories->where('books_count', 0)->count() }}</h4>
                        <p class="mb-0">Kategori Kosong</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus kategori <strong id="categoryName"></strong>?</p>
                    <div id="categoryWarning" class="alert alert-warning" style="display: none;">
                        <strong>Peringatan:</strong> Kategori ini memiliki <span id="bookCount"></span> buku. Hapus atau pindahkan buku terlebih dahulu!
                    </div>
                    <p class="text-danger"><small>Aksi ini tidak dapat dibatalkan!</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" id="deleteButton">Ya, Hapus Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function editCategory(id, name, description) {
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description || '';
            document.getElementById('editForm').action = '/admin/categories/' + id;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        function confirmDeleteCategory(id, name, bookCount) {
            document.getElementById('categoryName').textContent = name;
            document.getElementById('deleteForm').action = '/admin/categories/' + id;

            if (bookCount > 0) {
                document.getElementById('bookCount').textContent = bookCount;
                document.getElementById('categoryWarning').style.display = 'block';
                document.getElementById('deleteButton').disabled = true;
                document.getElementById('deleteButton').textContent = 'Tidak Dapat Dihapus';
            } else {
                document.getElementById('categoryWarning').style.display = 'none';
                document.getElementById('deleteButton').disabled = false;
                document.getElementById('deleteButton').textContent = 'Ya, Hapus Kategori';
            }

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>
</body>
</html>
