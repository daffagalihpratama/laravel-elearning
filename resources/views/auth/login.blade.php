<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>

  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #696cff, #8592ff);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: Arial, sans-serif;
    }

    .login-card {
      width: 400px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .login-title {
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
      font-size: 22px;
      color: #333;
    }

    .btn-login {
      background: #696cff;
      color: white;
      width: 100%;
      padding: 10px;
      border-radius: 10px;
    }

    .btn-login:hover {
      background: #5a5fe0;
    }

    .form-control {
      border-radius: 10px;
    }

    .error {
      color: red;
      font-size: 13px;
    }
  </style>
</head>

<body>

  <div class="login-card">

    <div class="login-title">
      LOGIN E-LEARNING
    </div>

    {{-- error message --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="/login">
      @csrf

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan email">
        @error('email')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password">
        @error('password')
          <div class="error">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-login">
        Login
      </button>
    </form>

  </div>

</body>

</html>
