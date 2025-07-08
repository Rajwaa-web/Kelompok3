<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Login - e-perpus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-10">
                <div class="text-center mb-5">
                    <h1 class="text-white mb-3">
                        <i class="fas fa-book-open me-3"></i>
                        Perpustakaan Digital Kampus
                    </h1>
                    <p class="text-white-50 lead">Silakan pilih jenis akun untuk masuk ke sistem</p>
                </div>

                <div class="row">
                    <!-- User Login -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-lg login-card" style="transition: all 0.3s ease;">
                            <div class="card-body text-center p-5">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                                <h3 class="card-title text-primary mb-3">Login User</h3>
                                <p class="text-muted mb-4">
                                    Akses untuk mahasiswa dan dosen yang ingin meminjam buku dari perpustakaan digital.
                                </p>
                                
                                <div class="mb-4">
                                    <h6 class="text-muted">Fitur yang tersedia:</h6>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Mencari dan melihat koleksi buku</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Meminjam buku yang tersedia</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Melihat riwayat peminjaman</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Mengembalikan buku</li>
                                    </ul>
                                </div>

                                <div class="alert alert-info">
                                    <strong>Demo Account:</strong><br>
                                    Email: <code>test@example.com</code><br>
                                    Password: <code>password</code>
                                </div>

                                <a href="/login" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Masuk sebagai User
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Login -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-lg login-card" style="transition: all 0.3s ease;">
                            <div class="card-body text-center p-5">
                                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                                    <i class="fas fa-user-shield fa-3x"></i>
                                </div>
                                <h3 class="card-title text-danger mb-3">Login Admin</h3>
                                <p class="text-muted mb-4">
                                    Akses khusus untuk administrator yang mengelola sistem perpustakaan digital.
                                </p>
                                
                                <div class="mb-4">
                                    <h6 class="text-muted">Fitur yang tersedia:</h6>
                                    <ul class="list-unstyled text-start">
                                        <li><i class="fas fa-check text-success me-2"></i>Mengelola koleksi buku</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Mengelola user dan peminjaman</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Melihat laporan dan statistik</li>
                                        <li><i class="fas fa-check text-success me-2"></i>Mengelola kategori buku</li>
                                    </ul>
                                </div>

                                <div class="alert alert-warning">
                                    <strong>Demo Account:</strong><br>
                                    Email: <code>admin@example.com</code><br>
                                    Password: <code>password</code>
                                </div>

                                <a href="/admin/login" class="btn btn-danger btn-lg w-100">
                                    <i class="fas fa-shield-alt me-2"></i>Masuk sebagai Admin
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Register Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body text-center p-4">
                                <h5 class="card-title">Belum punya akun?</h5>
                                <p class="text-muted mb-3">Daftar sekarang untuk mengakses perpustakaan digital</p>
                                <a href="/register" class="btn btn-success btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Akun Baru
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-4">
                    <a href="/" class="text-white text-decoration-none">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        .login-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
        }
    </style>
</body>
</html>
