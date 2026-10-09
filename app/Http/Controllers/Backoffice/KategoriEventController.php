<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\KategoriEvent;
use Illuminate\Http\Request;

class KategoriEventController extends Controller
{
    public function index()
    {
        $kategoris = KategoriEvent::orderBy('nama')->paginate(10);

        return view('backoffice.kategori-event.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_events,nama',
        ]);

        $kategori = KategoriEvent::create(['nama' => $request->nama]);

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'kategori' => $kategori,
            ]);
        }

        return redirect()->route('backoffice.kategori-event.index')
            ->with('success', 'Kategori event berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriEvent::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_events,nama,' . $kategori->id,
        ]);

        $kategori->update(['nama' => $request->nama]);

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'kategori' => $kategori,
            ]);
        }

        return redirect()->route('backoffice.kategori-event.index')
            ->with('success', 'Kategori event berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $kategori = KategoriEvent::findOrFail($id);
        $kategori->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('backoffice.kategori-event.index')
            ->with('success', 'Kategori event berhasil dihapus.');
    }
}