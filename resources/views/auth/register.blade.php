<form method="POST" action="/register">
    @csrf

    <!-- NAMA -->
    <div>
        <label>Nama</label><br>
        <input 
            type="text" 
            name="name"
            placeholder="username"
            value="{{ old('name') }}"
            required
            pattern="[A-Za-z\s]+"
            title="Nama hanya boleh berisi huruf dan spasi"
        >
        @error('name')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <br>

    <!-- EMAIL -->
    <div>
        <label>Email</label><br>
        <input 
            type="email" 
            name="email"
            placeholder="Contoh: nama@email.com"
            value="{{ old('email') }}"
            required
            title="Masukkan email dengan format yang benar"
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
            placeholder="Minimal 8 karakter"
            required
            minlength="8"
            title="Password minimal 8 karakter"
        >
        @error('password')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <br>

    <!-- NO TELEPON -->
    <div>
        <label>No Telepon</label><br>
        <input 
            type="text" 
            name="phone"
            placeholder="08xxxxxxxxxx"
            value="{{ old('phone') }}"
            required
            pattern="[0-9]+"
            title="Nomor telepon hanya boleh angka"
        >
        @error('phone')
            <small style="color:red">{{ $message }}</small>
        @enderror
    </div>

    <br>

    <button type="submit">Register</button>
    <p>Sudah punya akun? <a href="/login">Login</a></p>
</form>
