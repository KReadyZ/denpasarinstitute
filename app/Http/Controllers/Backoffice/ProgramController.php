<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index(Divisi $divisi)
    {
        $programs = $divisi->programs()->orderBy('urutan', 'asc')->get();
        return view('backoffice.program.index', compact('divisi', 'programs'));
    }

    public function create(Divisi $divisi)
    {
        return view('backoffice.program.create', compact('divisi'));
    }

    public function store(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'ikon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        Program::create([
            'divisi_id' => $divisi->id,
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'ikon' => $request->ikon,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('backoffice.program.index', $divisi->id)
                         ->with('success', 'Program berhasil ditambahkan!');
    }

    public function edit(Divisi $divisi, Program $program)
    {
        return view('backoffice.program.edit', compact('divisi', 'program'));
    }

    public function update(Request $request, Divisi $divisi, Program $program)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'ikon' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $program->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'ikon' => $request->ikon,
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('backoffice.program.index', $divisi->id)
                         ->with('success', 'Program berhasil diperbarui!');
    }

    public function destroy(Divisi $divisi, Program $program)
    {
        $program->delete();
        return redirect()->route('backoffice.program.index', $divisi->id)
                         ->with('success', 'Program berhasil dihapus!');
    }

    // ============================================
    // PERBAIKAN UTAMA: API DENGAN DUAL FORMAT
    // ============================================
    public function publicByDivisiSlug(string $slug)
    {
        $divisi = Divisi::where('slug', $slug)
                        ->where('is_active', true)
                        ->first();

        if (!$divisi) {
            return response()->json([
                'success'  => false,
                'message'  => 'Divisi tidak ditemukan atau tidak aktif.',
                'programs' => [], // DUAL FORMAT
                'data'     => [], // DUAL FORMAT
                'count'    => 0,
            ], 404);
        }

        $programs = $divisi->programs()
                        ->where('is_active', true)
                        ->orderBy('urutan', 'asc')
                        ->get(['id', 'nama', 'slug', 'ikon', 'deskripsi', 'urutan']);

        return response()->json([
            'success' => true,
            'divisi' => [
                'id'   => $divisi->id,
                'nama' => $divisi->nama,
                'slug' => $divisi->slug,
            ],
            'count'    => $programs->count(),
            'programs' => $programs, // DUAL FORMAT
            'data'     => $programs, // DUAL FORMAT
        ]);
    }
}