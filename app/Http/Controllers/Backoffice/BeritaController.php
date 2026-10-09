<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $query = Berita::orderBy('created_at', 'desc');

        if (Auth::user()->role !== 'superadmin') {
            $query->where('created_by', Auth::id());
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $beritas = $query->paginate(10)->withQueryString();

        return view('backoffice.berita.index', compact('beritas'));
    }

    public function create()
    {
        $kategoriList = KategoriBerita::orderBy('nama')->get();

        return view('backoffice.berita.create', compact('kategoriList'));
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
                ->store('berita/image', 'public');
        }

        Berita::create($data);

        $message = $isSuperadmin
            ? 'Berita berhasil ditambahkan dan langsung tayang.'
            : 'Berita berhasil dikirim dan menunggu verifikasi admin.';

        return redirect()->route('backoffice.berita.index')->with('success', $message);
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $this->authorizeOwner($berita);

        $kategoriList = KategoriBerita::orderBy('nama')->get();

        return view('backoffice.berita.edit', compact('berita', 'kategoriList'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        $this->authorizeOwner($berita);

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
            if ($berita->image) {
                Storage::disk('public')->delete($berita->image);
            }
            $data['image'] = $request->file('image')
                ->store('berita/image', 'public');
        }

        $berita->update($data);

        $message = $isSuperadmin
            ? 'Berita berhasil diperbarui.'
            : 'Berita berhasil diperbarui dan dikirim ulang untuk verifikasi.';

        return redirect()->route('backoffice.berita.index')->with('success', $message);
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $this->authorizeOwner($berita);

        if ($berita->image) {
            Storage::disk('public')->delete($berita->image);
        }

        $berita->delete();

        return redirect()->route('backoffice.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $berita = Berita::findOrFail($id);

        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang bisa mengubah status tayang.');
        }

        if ($berita->status !== 'approved') {
            return back()->with('error', 'Berita harus disetujui terlebih dahulu sebelum bisa ditayangkan.');
        }

        $berita->update(['is_active' => !$berita->is_active]);

        return back()->with('success', 'Status tayang berita diperbarui.');
    }

    public function verifikasiIndex()
    {
        $this->ensureSuperadmin();

        $beritas = Berita::pending()
            ->with('creator')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('backoffice.berita.verifikasi', compact('beritas'));
    }

    public function approve($id)
    {
        $this->ensureSuperadmin();

        $berita = Berita::findOrFail($id);
        $berita->update([
            'status'         => 'approved',
            'is_active'      => true,
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'rejection_note' => null,
        ]);

        return back()->with('success', 'Berita "' . $berita->title . '" berhasil disetujui dan tayang di website.');
    }

    public function reject(Request $request, $id)
    {
        $this->ensureSuperadmin();

        $request->validate([
            'rejection_note' => 'required|string|max:500',
        ]);

        $berita = Berita::findOrFail($id);
        $berita->update([
            'status'         => 'rejected',
            'is_active'      => false,
            'approved_by'    => Auth::id(),
            'approved_at'    => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', 'Berita "' . $berita->title . '" ditolak.');
    }

    private function authorizeOwner(Berita $berita)
    {
        if (Auth::user()->role !== 'superadmin' && $berita->created_by !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke berita ini.');
        }
    }

    private function ensureSuperadmin()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Hanya superadmin yang bisa mengakses halaman ini.');
        }
    }
}