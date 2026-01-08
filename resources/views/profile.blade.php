<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profile User</title>
</head>
<body>

@include('partials.header')

<h2>Profile User</h2>

{{-- tampilkan error validasi --}}
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <p style="color:green;">
        {{ session('success') }}
    </p>
@endif

<form method="POST" action="/profile/update">
    @csrf

    <!-- NAMA -->
    <div>
        <label>Nama</label><br>
        <input
            type="text"
            name="name"
            value="{{ old('name', $user->name) }}"
            required
        >
    </div>

    <br>

    <!-- EMAIL -->
    <div>
        <label>Email</label><br>
        <input
            type="email"
            name="email"
            value="{{ old('email', $user->email) }}"
            required
        >
    </div>

    <br>

    <!-- NOMOR TELEPON -->
    <div>
        <label>Nomor Telepon</label><br>
        <input
            type="text"
            name="phone"
            value="{{ old('phone', $user->phone) }}"
            required
        >
    </div>

    <br>

    <!-- BIO -->
    <div>
        <label>Bio</label><br>
        <textarea
            name="bio"
            rows="4"
            placeholder="Tulis bio kamu di sini..."
        >{{ old('bio', $user->bio) }}</textarea>
    </div>

    <br>

    <!-- STATUS (ROLE) -->
    <div>
        <label>Status</label><br>
        <input
            type="text"
            value="{{ ucfirst($user->role) }}"
            readonly
        >
    </div>

    <br>

    <button type="submit">Simpan Perubahan</button>
</form>

</body>
</html>
