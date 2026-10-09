<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DivisiController extends Controller
{
    public function index()
    {
        $divisis = Divisi::orderBy('urutan', 'asc')->get();
        return view('backoffice.divisi.index', compact('divisis'));
    }

    public function create()
    {
        return view('backoffice.divisi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'header' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'header' => $request->header,
            'deskripsi' => $request->deskripsi,
            'stats' => $this->cleanStats($request->input('stats', [])),
            'is_active' => $request->has('is_active'),
            'urutan' => $request->urutan ?? 0,
        ];

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')->store('divisi_heroes', 'public');
        }

        Divisi::create($data);

        return redirect()->route('backoffice.divisi.index')
                       ->with('success', 'Divisi berhasil dibuat!');
    }

    public function edit($id)
    {
        $divisi = Divisi::findOrFail($id);
        return view('backoffice.divisi.edit', compact('divisi'));
    }

    public function update(Request $request, $id)
    {
        $divisi = Divisi::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'header' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'header' => $request->header,
            'deskripsi' => $request->deskripsi,
            'stats' => $this->cleanStats($request->input('stats', [])),
            'is_active' => $request->has('is_active'),
            'urutan' => $request->urutan ?? 0,
        ];

        if ($request->hasFile('background_image')) {
            if ($divisi->background_image) {
                Storage::disk('public')->delete($divisi->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('divisi_heroes', 'public');
        }

        $divisi->update($data);

        return redirect()->route('backoffice.divisi.index')
                       ->with('success', 'Divisi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);

        if ($divisi->background_image) {
            Storage::disk('public')->delete($divisi->background_image);
        }

        $divisi->delete();

        return redirect()->route('backoffice.divisi.index')
                       ->with('success', 'Divisi berhasil dihapus!');
    }

    protected function cleanStats(array $stats)
    {
        return array_values(array_filter($stats, function ($stat) {
            return !empty($stat['number']) && !empty($stat['label']);
        }));
    }
}