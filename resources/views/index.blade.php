<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bufet Coffee</title>
</head>
<body>

{{-- HEADER / NAVBAR --}}
@include('partials.header')

<!-- HERO -->
<section style="padding:60px; text-align:center;">
    <h1>Bufet Coffee</h1>
    <p>Kopi berkualitas dari kebun terbaik Indonesia</p>
</section>

<hr>

<!-- PRODUK -->
<section id="produk" style="padding:40px;">
    <h2>Produk Kami</h2>

    <ul>
        <li>Wine Coffee</li>
        <li>Natural Coffee</li>
        <li>Honey Coffee</li>
        <li>Full Washed Coffee</li>
    </ul>

    <a href="/menu">
        <button>Lihat Produk Selengkapnya</button>
    </a>
</section>

<hr>

<!-- EVENT -->
<section id="event" style="padding:40px;">
    <h2>Event</h2>
    <p>Ikuti berbagai event dan promo menarik dari Bufet Coffee.</p>

    <ul>
        <li>Farm Visit</li>
        <li>Coffee Tasting</li>
        <li>Promo Bulanan</li>
    </ul>

    <a href="/event">
        <button>Lihat Event</button>
    </a>
</section>

<hr>

<!-- LOKASI -->
<section id="lokasi" style="padding:40px;">
    <h2>Lokasi Kami</h2>
    <p>
        <a 
          href="https://www.google.com/maps/place//data=!4m2!3m1!1s0x2e689583d08084a7:0xe625d13864d45a3f"
          target="_blank"
        >
            Lihat lokasi Bufet Coffee di Google Maps
        </a>
    </p>
</section>

<hr>

{{-- FOOTER --}}
@include('partials.footer')

</body>
</html>
