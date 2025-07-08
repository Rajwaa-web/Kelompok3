<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - e-perpus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="card-title text-primary">
                                <i class="fas fa-book-open me-2"></i>
                                e-perpus
                            </h3>
                            <p class="text-muted">Silakan masuk ke akun Anda</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Login Type Selection -->
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card border-primary login-type" data-type="user">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-user fa-2x text-primary mb-2"></i>
                                            <h6 class="mb-0">Login User</h6>
                                            <small class="text-muted">Peminjam Buku</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card border-danger login-type" data-type="admin">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-user-shield fa-2x text-danger mb-2"></i>
                                            <h6 class="mb-0">Login Admin</h6>
                                            <small class="text-muted">Pengelola Sistem</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="/login" id="loginForm">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>

                            <!-- Quick Login Buttons -->
                            <div class="mb-3" id="quickLogin" style="display: none;">
                                <div class="alert alert-info">
                                    <strong>Quick Login:</strong>
                                    <div class="mt-2">
                                        <button type="button" class="btn btn-sm btn-outline-primary me-2" onclick="quickLogin('user')">
                                            User Demo (test@example.com)
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="quickLogin('admin')">
                                            Admin Demo (admin@example.com)
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk
                            </button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">Belum punya akun? 
                                <a href="/register" class="text-primary">Daftar di sini</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .login-type {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .login-type:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .login-type.selected {
            background-color: #f8f9fa;
            border-width: 2px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginTypes = document.querySelectorAll('.login-type');
            const quickLogin = document.getElementById('quickLogin');

            loginTypes.forEach(function(card) {
                card.addEventListener('click', function() {
                    // Remove selected class from all cards
                    loginTypes.forEach(c => c.classList.remove('selected'));

                    // Add selected class to clicked card
                    this.classList.add('selected');

                    // Show quick login options
                    quickLogin.style.display = 'block';

                    const type = this.dataset.type;
                    if (type === 'admin') {
                        document.getElementById('email').placeholder = 'admin@example.com';
                    } else {
                        document.getElementById('email').placeholder = 'test@example.com';
                    }
                });
            });
        });

        function quickLogin(type) {
            if (type === 'admin') {
                document.getElementById('email').value = 'admin@example.com';
                document.getElementById('password').value = 'password';
            } else {
                document.getElementById('email').value = 'test@example.com';
                document.getElementById('password').value = 'password';
            }
        }
    </script>
</body>
</html>
