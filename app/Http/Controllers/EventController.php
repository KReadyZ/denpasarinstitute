<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\KategoriEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $kategoriList = KategoriEvent::orderBy('nama')->get();
        $events = Event::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('event.index', compact('events', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori'     => 'required|string',
            'kontributor'  => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'kategori', 'kontributor', 'no_anggota',
            'published_at', 'title', 'content',
        ]);

        $data['status']    = 'pending';
        $data['is_active'] = false;
        $data['views']     = 0;
        $data['created_by'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('event/image', 'public');
        }

        Event::create($data);

        return redirect()->route('event.index')
            ->with('success', 'Event berhasil diajukan! Admin akan meninjau dan menyetujui event Anda dalam waktu singkat.');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        if (!$event->is_active || $event->status !== 'approved') {
            abort(403, 'Event tidak tersedia');
        }

        $event->increment('views');

        $eventLain = Event::where('is_active', true)
            ->where('status', 'approved')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('event.show', compact('event', 'eventLain'));
    }

    public function latestEvent()
    {
        $events = Event::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        return response()->json($events);
    }

    public function featuredEvent()
    {
        $event = Event::where('is_active', true)
            ->where('status', 'approved')
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->first();

        return response()->json($event);
    }
}