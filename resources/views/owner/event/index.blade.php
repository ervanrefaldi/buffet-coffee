@extends('layouts.owner')

@section('title', 'Kelola Event')
@section('subtitle', 'Daftar semua event yang akan berlangsung atau sudah selesai.')

@section('content')
    <div class="mb-6">
        <a href="/owner/event/create" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 active:bg-amber-800 focus:outline-none focus:border-amber-900 focus:ring ring-amber-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Event Baru
        </a>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        <!-- Mobile View (Cards) -->
        <div class="grid grid-cols-1 gap-6 md:hidden px-4 pb-4">
            @forelse($events as $event)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="h-40 w-full relative">
                        <img src="{{ str_starts_with($event->image, 'http') ? $event->image : asset($event->image) }}" alt="Event" class="w-full h-full object-cover">
                        @php
                            $now = date('Y-m-d');
                            $isActive = $event->start_date <= $now && $event->end_date >= $now;
                        @endphp
                        <span class="absolute top-2 right-2 px-2 py-1 text-xs font-bold rounded-full {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $isActive ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $event->title }}</h3>
                        <p class="text-xs text-gray-500 mb-3">
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $event->description }}</p>
                        
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                            <a href="/owner/event/{{ $event->events_id }}/edit" class="flex-1 text-center bg-indigo-50 text-indigo-700 py-2 rounded-lg font-medium text-sm mr-2 hover:bg-indigo-100 transition">Edit</a>
                            <form action="/owner/event/{{ $event->events_id }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 text-red-700 py-2 rounded-lg font-medium text-sm hover:bg-red-100 transition">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-gray-500 bg-white rounded-lg border border-dashed border-gray-300">
                    Belum ada event.
                </div>
            @endforelse
        </div>

        <!-- Desktop View (Table) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Event</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($events as $event)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ str_starts_with($event->image, 'http') ? $event->image : asset($event->image) }}?v={{ strtotime($event->updated_at ?? $event->created_at) }}" alt="Event" class="h-16 w-24 object-cover rounded-md border border-gray-200">
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                <div class="text-sm text-gray-500 truncate w-48">{{ Str::limit($event->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">s/d</div>
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $now = date('Y-m-d');
                                    $isActive = $event->start_date <= $now && $event->end_date >= $now;
                                @endphp
                                @if($isActive)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/owner/event/{{ $event->events_id }}/edit" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                <form action="/owner/event/{{ $event->events_id }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                Belum ada event yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
