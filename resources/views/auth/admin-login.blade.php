<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Travels & Tour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, rgba(24,29,46,0.85) 0%, rgba(60,69,62,0.7) 100%),
                        url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover no-repeat fixed;
            min-height: 100vh; display: flex; align-items: center;
        }
        .admin-card { border: none; border-radius: 16px; overflow: hidden; }
        .admin-header {
            background: linear-gradient(135deg, #3c453e, #181d2e);
            padding: 2rem; text-align: center; color: white;
        }
        .btn-primary { background-color: #3c453e; border-color: #3c453e; border-radius: 10px; padding: 0.7rem 1rem; font-weight: 600; }
        .btn-primary:hover { background-color: #2d342f; border-color: #2d342f; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(60,69,62,0.3); }
        .form-control { border-radius: 10px; padding: 0.65rem 1rem; border: 2px solid #e9ecef; }
        .form-control:focus { border-color: #3c453e; box-shadow: 0 0 0 3px rgba(60,69,62,0.1); }
        a { color: #3c453e; }
        a:hover { color: #2d342f; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card admin-card shadow">
                    <div class="admin-header">
                        <i class="bi bi-shield-lock" style="font-size: 2rem;"></i>
                        <h4 class="fw-bold mb-0 mt-2">Admin Panel</h4>
                        <p class="small opacity-75 mb-0">Sign in to manage your website</p>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger py-2 small">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-medium">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-medium">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">Remember Me</label>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary py-2">Sign In</button>
                            </div>

                            <hr class="my-3">

                            <div class="text-center">
                                <a href="{{ url('/') }}" class="small text-decoration-none text-muted">
                                    <i class="bi bi-arrow-left"></i> Back to Website
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
