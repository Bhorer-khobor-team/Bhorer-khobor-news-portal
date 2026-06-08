<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন লগইন | ভোরের খবর</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e293b 0%, #c0392b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #c0392b, #e74c3c);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .login-body { padding: 2rem; }
        .form-control:focus { border-color: #c0392b; box-shadow: 0 0 0 0.2rem rgba(192,57,43,0.25); }
        .btn-login { background: #c0392b; border-color: #c0392b; color: #fff; font-weight: 600; }
        .btn-login:hover { background: #a93226; border-color: #a93226; color: #fff; }
        .input-group-text { cursor: pointer; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h3 class="mb-1 fw-bold">ভোরের খবর</h3>
            <p class="mb-0 opacity-75">অ্যাডমিন প্যানেলে প্রবেশ করুন</p>
        </div>
        <div class="login-body">
            @if($errors->any())
            <div class="alert alert-danger py-2 small">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold small">ইমেইল</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="admin@example.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold small">পাসওয়ার্ড</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required>
                        <span class="input-group-text" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">মনে রাখুন</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-login w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>লগইন করুন
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const input = document.getElementById('passwordInput');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    </script>
</body>
</html>
