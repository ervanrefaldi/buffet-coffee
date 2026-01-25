<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'title'          => 'required|max:150',
            'description'    => 'required',
            'image'          => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'instagram_link' => 'nullable|url',
        ], [
            'image.required'    => ' Gambar event wajib diupload.',
            'image.image'       => 'File harus berupa gambar.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/events'), $filename);
            $imagePath = 'images/events/' . $filename;
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
        $request->validate([
            'title'          => 'required|max:150',
            'description'    => 'required',
            'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'instagram_link' => 'nullable|url',
        ]);

        $event = Event::findOrFail($id);
        
        $data = $request->except(['image']);

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image && file_exists(public_path($event->image))) {
                unlink(public_path($event->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/events'), $filename);
            $data['image'] = 'images/events/' . $filename;
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
        
        if ($event->image && file_exists(public_path($event->image))) {
            unlink(public_path($event->image));
        }
        
        $event->delete();

        return redirect('/owner/event')->with('success', 'Event berhasil dihapus.');
    }
}
