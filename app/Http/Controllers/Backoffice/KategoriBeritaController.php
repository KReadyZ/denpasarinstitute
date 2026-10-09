<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;

class KategoriBeritaController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBerita::orderBy('nama')->paginate(10);

        return view('backoffice.kategori-berita.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_beritas,nama',
        ]);

        $kategori = KategoriBerita::create(['nama' => $request->nama]);

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'kategori' => $kategori,
            ]);
        }

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100|unique:kategori_beritas,nama,' . $id,
        ]);

        $kategori->update(['nama' => $request->nama]);

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'kategori' => $kategori,
            ]);
        }

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $kategori->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}