<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    public function index()
    {
        $kategoriList = KategoriBerita::orderBy('nama')->get();
        $beritas = Berita::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('berita.index', compact('beritas', 'kategoriList'));
    }

    // TAMBAHKAN METHOD INI
    public function create()
    {
        $kategoriList = KategoriBerita::orderBy('nama')->get();
        return view('berita.create', compact('kategoriList'));
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
                ->store('berita/image', 'public');
        }

        Berita::create($data);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diajukan! Admin akan meninjau dan menyetujui berita Anda dalam waktu singkat.');
    }

    public function show($id)
    {
        $berita = Berita::findOrFail($id);

        if (!$berita->is_active || $berita->status !== 'approved') {
            abort(403, 'Berita tidak tersedia');
        }

        $berita->increment('views');

        $beritaLain = Berita::where('is_active', true)
            ->where('status', 'approved')
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        return view('berita.show', compact('berita', 'beritaLain'));
    }

    public function latestBerita()
    {
        $beritas = Berita::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        return response()->json($beritas);
    }

    public function featuredBerita()
    {
        $berita = Berita::where('is_active', true)
            ->where('status', 'approved')
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->first();

        return response()->json($berita);
    }
}