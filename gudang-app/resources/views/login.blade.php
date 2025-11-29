<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            background: 
                url('{{ asset('images/background.jpeg') }}') no-repeat center center fixed,
                linear-gradient(to bottom right, #09182fff, #30619dff, #7bb2f5ff);
            background-size: cover;
        }

        .bokeh {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.06) 0%, transparent 50%);
            z-index: 1;
        }

        .login-card {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.95); /* putih lebih solid */
            border-radius: 20px;
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            color: #111; /* teks hitam untuk kontras dengan background putih */
        }

        .login-card h3 {
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
            color: #111;
        }

        .form-label {
            color: #333;
            font-weight: 500;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        }

        .btn-login {
            border-radius: 12px;
            padding: 12px;
            font-size: 17px;
            font-weight: 600;
            background: linear-gradient(to right, #3b82f6, #2563eb);
            border: none;
            color: white;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: scale(1.02);
            background: linear-gradient(to right, #2563eb, #1d4ed8);
        }

        .alert-danger {
            border-radius: 10px;
            background: #fee2e2;
            color: #991b1b;
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="bokeh"></div>

    <div class="login-card">
        <h3>Login</h3>

        @if($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn btn-login w-100">Login</button>
        </form>
    </div>
</body>
</html>
