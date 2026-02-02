<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            return back()->withErrors(['image' => 'Gagal: File terlau besar (Melebihi batas server ' . ini_get('post_max_size') . '). Mohon kompres file di bawah 5MB.'])->withInput();
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = ImgBBService::upload($request->file('image'));
            
            if (!$imagePath) {
                return back()->withErrors(['image' => 'Gagal mengunggah gambar ke ImgBB. Silakan coba lagi.'])->withInput();
            }
        }

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
            $newImagePath = ImgBBService::upload($request->file('image'));
            
            if (!$newImagePath) {
                return back()->withErrors(['image' => 'Gagal mengunggah gambar ke ImgBB. Silakan coba lagi.'])->withInput();
            }

            $data['image'] = $newImagePath;
            
            // Hapus file lama jika ada (lokal)
            if ($event->image && !str_starts_with($event->image, 'http')) {
                $paths = [
                    public_path('images/events'),
                ];
                if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) $paths[] = $_SERVER['DOCUMENT_ROOT'] . '/images/events';
                if (file_exists(base_path('../public_html'))) $paths[] = base_path('../public_html/images/events');
                $paths = array_unique($paths);

                foreach ($paths as $path) {
                    $oldFile = $path . '/' . basename($event->image);
                    if (file_exists($oldFile)) @unlink($oldFile);
                }
            }
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
            $paths = [
                public_path('images/events'),
            ];
            if (isset($_SERVER['DOCUMENT_ROOT']) && !empty($_SERVER['DOCUMENT_ROOT'])) $paths[] = $_SERVER['DOCUMENT_ROOT'] . '/images/events';
            if (file_exists(base_path('../public_html'))) $paths[] = base_path('../public_html/images/events');
            $paths = array_unique($paths);

            foreach ($paths as $path) {
                $file = $path . '/' . basename($event->image);
                if (file_exists($file)) @unlink($file);
            }
        }
        
        $event->delete();

        return redirect('/owner/event')->with('success', 'Event berhasil dihapus.');
    }
}

