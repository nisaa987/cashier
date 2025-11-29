<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url('https://koala.sh/api/image/v2-8dmxi-8cmn6.jpg?width=1344&height=768&dream'); 
             background-size: cover; 
             background-repeat: no-repeat; 
             background-position: center; 
             height: 100vh; 
             display: flex; 
             justify-content: center; 
             align-items: center; 
             margin: 0; 
             font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    
    <div class="card shadow" style="width: 400px; padding: 30px 25px; border-radius: 18px; background-color: rgba(255, 255, 255, 0.9); box-shadow: 0 8px 20px rgba(0,0,0,0.12); text-align: center; backdrop-filter: blur(4px);">
        
        <h3 style="margin-bottom: 25px; font-weight: 600; color: #1f2937; display: flex; align-items: center; justify-content: center; gap: 12px;">
            <img src="{{ asset('assets/img/favicon/favicon.ico') }}" alt="Logo" style="width: 36px; height: 36px; object-fit: contain; filter: drop-shadow(0 0 2px rgba(74,144,226,0.5));">
            Kasir-Go Login
        </h3>

        @if($errors->any())
            <div class="alert alert-danger" style="border-radius: 12px; font-weight: 600; font-size: 14px; margin-bottom: 20px; background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf 
            <div class="mb-3 text-start">
                <label for="email" style="font-weight: 600; color: #374151;">Email</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="Masukan email" autofocus
                    style="border-radius: 12px; padding: 12px 18px; font-size: 16px; border: 1.8px solid #cbd5e1;">
            </div>

            <div class="mb-3 text-start">
                <label for="password" style="font-weight: 600; color: #374151;">Password</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Masukan password" required
                    style="border-radius: 12px; padding: 12px 18px; font-size: 16px; border: 1.8px solid #cbd5e1;">
            </div>

            <button type="submit" class="btn btn-primary w-100" 
                style="background-color: #3b82f6; border: none; border-radius: 20px; padding: 14px 0; font-size: 18px; font-weight: 600; box-shadow: 0 5px 15px rgba(59,130,246,0.4);">
                Login
            </button>
        </form>
    </div>
</body>
</html>
