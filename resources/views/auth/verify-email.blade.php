<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>
<body>

<h2>Verifikasi Email</h2>

<p>Sebelum melanjutkan, silakan periksa email Anda untuk link verifikasi.</p>

<p>Jika Anda tidak menerima email, kami akan dengan senang hati mengirimkan yang baru.</p>

<form method="POST" action="{{ route('verification.send') }}">
    @csrf

    <button type="submit">Kirim Ulang Email Verifikasi</button>
</form>

<form method="POST" action="{{ route('logout') }}">
    @csrf

    <button type="submit">Logout</button>
</form>

</body>
</html>