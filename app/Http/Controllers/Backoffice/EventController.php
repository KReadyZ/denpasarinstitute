<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\KategoriEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::orderBy('created_at', 'desc');

        if (Auth::user()->role !== 'superadmin') {
            $query->where('created_by', Auth::id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->paginate(10)->withQueryString();

        return view('backoffice.event.index', compact('events'));
    }

    public function create()
    {
        $kategoriList = KategoriEvent::orderBy('nama')->get();

        return view('backoffice.event.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori'     => 'required|string',
            'kontributor'  => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
            'views'        => 'nullable|integer|min:0|max:500',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'kategori', 'kontributor', 'no_anggota',
            'published_at', 'title', 'content', 'views',
        ]);

        $isSuperadmin = Auth::user()->role === 'superadmin';

        if ($isSuperadmin) {
            $data['status']      = 'approved';
            $data['approved_by'] = Auth::id();
            $data['approved_at'] = now();
            $data['is_active']   = $request->has('is_active');
        } else {
            $data['status']    = 'pending';
            $data['is_active'] = false;
        }

        $data['created_by'] = Auth::id();
        $data['views'] = $data['views'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('event/image', 'public');
        }

        Event::create($data);

        $message = $isSuperadmin
            ? 'Event berhasil ditambahkan dan langsung tayang.'
            : 'Event berhasil dikirim dan menunggu verifikasi admin.';

        return redirect()->route('backoffice.event.index')->with('success', $message);
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $this->authorizeOwner($event);

        $kategoriList = KategoriEvent::orderBy('nama')->get();

        return view('backoffice.event.edit', compact('event', 'kategoriList'));
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $this->authorizeOwner($event);

        $request->validate([
            'kategori'     => 'required|string',
            'kontributor'  => 'required|string|max:255',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'published_at' => 'nullable|date',
            'views'        => 'nullable|integer|min:0|max:500',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'kategori', 'kontributor', 'no_anggota',
            'published_at', 'title', 'content', 'views',
        ]);

        $isSuperadmin = Auth::user()->role === 'superadmin';

        if ($isSuperadmin) {
            $data['is_active'] = $request->has('is_active');
        } else {
            $data['status']         = 'pending';
            $data['is_active']      = false;
            $data['approved_by']    = null;
            $data['approved_at']    = null;
            $data['rejection_note'] = null;
        }

        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')
                ->store('event/image', 'public');
        }

        $event->update($data);

        $message = $isSuperadmin
            ? 'Event berhasil diperbarui.'
            : 'Event berhasil diperbarui dan dikirim ulang untuk verifikasi.';

        return redirect()->route('backoffice.event.index')->with('success', $message);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $this->authorizeOwner($event);

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('backoffice.event.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $event = Event::findOrFail($id);

        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang bisa mengubah status tayang.');
        }

        if ($event->status !== 'approved') {
            return back()->with('error', 'Event harus disetujui terlebih dahulu sebelum bisa ditayangkan.');
        }

        $event->update(['is_active' => !$event->is_active]);

        return back()->with('success', 'Status tayang event diperbarui.');
    }

    public function verifikasiIndex()
    {
        $this->ensureSuperadmin();

        $events = Event::pending()
            ->with('creator')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('backoffice.event.verifikasi', compact('events'));
    }

    public function approve($id)
    {
        $this->ensureSuperadmin();

        $event = Event::findOrFail($id);
        $event->update([
            'status'         => 'approved',
            'is_active'      => true,
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'rejection_note' => null,
        ]);

        return back()->with('success', 'Event "' . $event->title . '" berhasil disetujui dan tayang di website.');
    }

    public function reject(Request $request, $id)
    {
        $this->ensureSuperadmin();

        $request->validate([
            'rejection_note' => 'required|string|max:500',
        ]);

        $event = Event::findOrFail($id);
        $event->update([
            'status'         => 'rejected',
            'is_active'      => false,
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', 'Event "' . $event->title . '" ditolak.');
    }

    private function authorizeOwner(Event $event)
    {
        if (Auth::user()->role !== 'superadmin' && $event->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke event ini.');
        }
    }

    private function ensureSuperadmin()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang bisa mengakses halaman ini.');
        }
    }
}