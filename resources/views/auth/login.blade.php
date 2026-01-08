<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color:red;">{{ session('error') }}</p>
@endif

<form method="POST" action="/login">
    @csrf

    <!-- EMAIL -->
    <div>
        <label>Email</label><br>
        <input 
            type="email" 
            name="email"
            placeholder="Contoh: nama@email.com"
            required
            value="{{ old('email') }}"
            title="Masukkan email yang terdaftar"
        >
        @error('email')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <br>

    <!-- PASSWORD -->
    <div>
        <label>Password</label><br>
        <input 
            type="password" 
            name="password"
            placeholder="Masukkan password"
            required
            minlength="8"
            title="Masukkan password akun Anda"
        >
        @error('password')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <br>

    <button type="submit">Login</button>
</form>

<p>Belum punya akun? <a href="/register">Register</a></p>

</body>
</html>
