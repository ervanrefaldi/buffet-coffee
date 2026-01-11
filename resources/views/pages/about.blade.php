<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tentang Bufet Coffee</title>
</head>
<body>

@include('partials.header')

<div style="max-width:800px;margin:auto;padding:40px">

    <h1>Tentang Bufet Coffee</h1>

    <p>
        Bufet Coffee adalah perusahaan kopi lokal Indonesia yang berfokus pada
        kualitas biji kopi terbaik langsung dari petani dan kebun kopi pilihan.
        Kami menghadirkan berbagai varian kopi seperti Natural, Honey, Wine, dan Full Washed.
    </p>

    <h3>Visi</h3>
    <p>
        Menjadi brand kopi Indonesia yang dikenal karena kualitas, transparansi,
        dan keberlanjutan petani kopi.
    </p>

    <h3>Misi</h3>
    <ul>
        <li>Mendukung petani kopi lokal</li>
        <li>Menyediakan kopi berkualitas tinggi</li>
        <li>Menyediakan sistem pemesanan online yang mudah</li>
    </ul>

    <h3>Aktor dalam Sistem</h3>

    <table border="1" cellpadding="10" width="100%">
        <tr>
            <th>Aktor</th>
            <th>Peran</th>
        </tr>
        <tr>
            <td>Guest</td>
            <td>Pengunjung yang belum login, bisa melihat produk dan event</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td>User terdaftar yang bisa membeli produk</td>
        </tr>
        <tr>
            <td>Member</td>
            <td>Pelanggan dengan status khusus dan mendapatkan diskon</td>
        </tr>
    </table>

</div>

@include('partials.footer')

</body>
</html>
