<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 400px;
    }

    .login-container h2 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 30px;
      text-align: center;
      color: #1f2937;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      font-size: 15px;
      font-weight: 600;
      color: #374151;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px 14px;
      font-size: 15px;
      border: 1px solid #d1d5db;
      border-radius: 8px;
      background: #f9fafb;
      transition: border 0.2s, box-shadow 0.2s;
    }

    input:focus {
      border-color: #4f46e5;
      outline: none;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .error {
      color: #dc2626;
      font-size: 13px;
      margin-top: 4px;
    }

    button {
      background: #4f46e5;
      color: white;
      padding: 12px;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
      transition: background 0.3s ease;
    }

    button:hover {
      background: #4338ca;
    }

    .login-footer {
      margin-top: 25px;
      text-align: center;
      font-size: 14px;
      color: #6b7280;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Admin Login</h2>

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}">
        @error('email') <div class="error">{{ $message }}</div> @enderror
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        @error('password') <div class="error">{{ $message }}</div> @enderror
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="login-footer">
      &copy; {{ now()->year }} SajiloCargo Admin Panel
    </div>
  </div>

</body>
</html>
