<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Event - Bufet Coffee</title>
    <style>
        .event-card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .event-card img {
            max-width: 300px;
            display: block;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

@include('partials.header')

<h1 style="text-align:center;">Event Bufet Coffee</h1>
<p style="text-align:center;">Event dan promo terbaru dari Bufet Coffee</p>

<hr>

<div style="width:80%; margin:auto;">

@if($events->count() == 0)
    <p style="text-align:center;">Tidak ada event yang sedang berlangsung.</p>
@endif

@foreach($events as $event)
    <div class="event-card">
        <h2>{{ $event->title }}</h2>

        @if($event->image)
            <img src="{{ asset('storage/events/'.$event->image) }}" alt="{{ $event->title }}">
        @endif

        <p>{{ $event->description }}</p>

        <p>
            <strong>Periode:</strong>
            {{ $event->start_date }} sampai {{ $event->end_date }}
        </p>
    </div>
@endforeach

</div>

@include('partials.footer')

</body>
</html>
