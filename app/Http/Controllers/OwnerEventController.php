<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OwnerEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = DB::table('events')
            ->orderBy('start_date', 'asc')
            ->get();

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
            'image.required'    => 'Gambar event wajib diupload.',
            'image.image'       => 'File harus berupa gambar.',
            'end_date.after_or_equal' => 'Tanggal selesai harus sama atau setelah tanggal mulai.',
        ]);

        // Handle File Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan ke storage/app/public/events
            $path = $file->storeAs('events', $filename, 'public'); 
            $imagePath = 'storage/' . $path;
        }

        DB::table('events')->insert([
            'title'          => $request->title,
            'description'    => $request->description,
            'image'          => $imagePath,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'instagram_link' => $request->instagram_link,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect('/owner/event')->with('success', 'Event berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $event = DB::table('events')->where('events_id', $id)->first();

        if (!$event) {
            return redirect('/owner/event')->with('error', 'Event tidak ditemukan.');
        }

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

        $event = DB::table('events')->where('events_id', $id)->first();
        if (!$event) {
            return back()->with('error', 'Event tidak ditemukan.');
        }

        $imagePath = $event->image;
        
        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image) {
                $oldPath = str_replace('storage/', '', $event->image);
                Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('events', $filename, 'public');
            $imagePath = 'storage/' . $path;
        }

        DB::table('events')->where('events_id', $id)->update([
            'title'          => $request->title,
            'description'    => $request->description,
            'image'          => $imagePath,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'instagram_link' => $request->instagram_link,
            'updated_at'     => now(),
        ]);

        return redirect('/owner/event')->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = DB::table('events')->where('events_id', $id)->first();
        
        if ($event) {
            // Hapus gambar
            if ($event->image) {
                $oldPath = str_replace('storage/', '', $event->image);
                Storage::disk('public')->delete($oldPath);
            }
            
            DB::table('events')->where('events_id', $id)->delete();
            return redirect('/owner/event')->with('success', 'Event berhasil dihapus.');
        }
        
        return redirect('/owner/event')->with('error', 'Gagal menghapus event.');
    }
}
