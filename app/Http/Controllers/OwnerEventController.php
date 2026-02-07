<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Services\ImgBBService;

class OwnerEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::orderBy('start_date', 'asc')->get();
        return view('owner.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Detect POST Size Violation
        if (!$request->has('title')) {
            return back()->withErrors(['image' => 'Gagal: File terlalu besar (Melebihi batas server ' . ini_get('post_max_size') . '). Mohon kompres file di bawah 5MB.'])->withInput();
        }

        $request->validate([
            'title'          => 'required|max:150',
            'description'    => 'required',
            'image'          => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'instagram_link' => 'nullable|url',
        ], [
            'image.max' => 'Ukuran gambar maksimal 5MB.'
        ]);

        $imagePath = $this->handleUpload($request->file('image'));

        Event::create([
            'title'          => $request->title,
            'description'    => $request->description,
            'image'          => $imagePath,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'instagram_link' => $request->instagram_link,
        ]);

        return redirect('/owner/event')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('owner.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Detect POST Size Violation
        if (!$request->has('title')) {
             return back()->withErrors(['image' => 'Gagal: File terlalu besar (Melebihi batas server ' . ini_get('post_max_size') . '). Mohon kompres file di bawah 5MB.'])->withInput();
        }

        $request->validate([
            'title'          => 'required|max:150',
            'description'    => 'required',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'instagram_link' => 'nullable|url',
        ], [
            'image.max' => 'Ukuran gambar maksimal 5MB.'
        ]);
        
        $data = $request->except(['image']);

        if ($request->hasFile('image')) {
            $newImagePath = $this->handleUpload($request->file('image'));
            
            // Hapus file lama jika ada (lokal)
            if ($event->image && !str_starts_with($event->image, 'http')) {
                Storage::disk('public')->delete($event->image);
            }

            $data['image'] = $newImagePath;
        }

        $event->update($data);

        return redirect('/owner/event')->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // Cleanup files
        if ($event->image && !str_starts_with($event->image, 'http')) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();

        return redirect('/owner/event')->with('success', 'Event berhasil dihapus.');
    }

    /**
     * Handle Image Upload with ImgBB as primary and Local Storage as fallback.
     */
    private function handleUpload($file)
    {
        if (!$file) return null;

        // 1. Attempt ImgBB Upload
        Log::info('Attempting ImgBB upload for: ' . $file->getClientOriginalName());
        $url = ImgBBService::upload($file);

        if ($url) {
            return $url;
        }

        // 2. Fallback to Local Storage if ImgBB fails
        Log::warning('ImgBB upload failed, falling back to local storage.');
        // Store in public/events folder
        $path = $file->store('events', 'public');
        
        return $path;
    }
}

