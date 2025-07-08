<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin Perpustakaan</title>
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
                <a class="nav-link active" href="/admin/users">Kelola User</a>
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
                <h2><i class="fas fa-users me-2"></i>Kelola User</h2>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Users Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Bergabung</th>
                                        <th>Total Peminjaman</th>
                                        <th>Sedang Pinjam</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $user->borrowings()->count() }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">
                                                {{ $user->borrowings()->where('status', 'borrowed')->count() }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $overdue = $user->borrowings()
                                                    ->where('status', 'borrowed')
                                                    ->where('due_date', '<', now())
                                                    ->count();
                                            @endphp
                                            @if($overdue > 0)
                                                <span class="badge bg-danger">Terlambat ({{ $overdue }})</span>
                                            @else
                                                <span class="badge bg-success">Normal</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($users->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $users->links() }}
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
                        <h4>{{ $users->total() }}</h4>
                        <p class="mb-0">Total User</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h4>{{ $users->where('role', 'admin')->count() }}</h4>
                        <p class="mb-0">Admin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4>{{ $users->where('role', 'user')->count() }}</h4>
                        <p class="mb-0">User Biasa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h4>{{ $users->filter(function($user) { return $user->borrowings()->where('status', 'borrowed')->count() > 0; })->count() }}</h4>
                        <p class="mb-0">Sedang Pinjam</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
