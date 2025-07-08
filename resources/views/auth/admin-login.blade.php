<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - e-perpus</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 border-danger">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-shield fa-2x"></i>
                            </div>
                            <h3 class="card-title text-danger">
                                Admin Login
                            </h3>
                            <p class="text-muted">Akses khusus untuk administrator sistem</p>
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

                        <form method="POST" action="/admin/login">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Admin</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control border-danger" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control border-danger" id="password" name="password" required>
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>

                            <!-- Demo Login -->
                            <div class="alert alert-warning">
                                <strong>Demo Login:</strong><br>
                                Email: <code>admin@example.com</code><br>
                                Password: <code>password</code>
                                <button type="button" class="btn btn-sm btn-outline-warning float-end" onclick="fillDemo()">
                                    <i class="fas fa-magic me-1"></i>Isi Otomatis
                                </button>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk sebagai Admin
                            </button>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">Bukan admin? 
                                <a href="/login" class="text-primary">Login sebagai User</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function fillDemo() {
            document.getElementById('email').value = 'admin@example.com';
            document.getElementById('password').value = 'password';
        }
    </script>
</body>
</html>
