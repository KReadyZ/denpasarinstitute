<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PartnershipPillar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnershipPillarController extends Controller
{
    public function index()
    {
        $pillars = PartnershipPillar::orderBy('order', 'asc')->get();
        return view('backoffice.partnership.index', compact('pillars'));
    }

    public function create()
    {
        return view('backoffice.partnership.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number'      => 'required|string|max:10',
            'title'       => 'required|string|max:150',
            'tag'         => 'required|string|max:100',
            'icon'        => 'nullable|string|max:50',
            'description' => 'required|string',
            'link_url'    => 'nullable|string|max:255',
            'link_text'   => 'nullable|string|max:50',
            'order'       => 'required|integer',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image'       => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['link_text'] = $validated['link_text'] ?? 'Learn more';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('image/partners'), $fileName);
            $validated['image'] = 'image/partners/' . $fileName;
        }

        unset($validated['image_file']);

        PartnershipPillar::create($validated);

        return redirect()
            ->route('backoffice.partnership-pillar.index')
            ->with('success', 'Pilar kemitraan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $pillar = PartnershipPillar::findOrFail($id);
        return view('backoffice.partnership.edit', compact('pillar'));
    }

    public function update(Request $request, $id)
    {
        $pillar = PartnershipPillar::findOrFail($id);

        $validated = $request->validate([
            'number'      => 'required|string|max:10',
            'title'       => 'required|string|max:150',
            'tag'         => 'required|string|max:100',
            'icon'        => 'nullable|string|max:50',
            'description' => 'required|string',
            'link_url'    => 'nullable|string|max:255',
            'link_text'   => 'nullable|string|max:50',
            'order'       => 'required|integer',
            'image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image'       => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['link_text'] = $validated['link_text'] ?? 'Learn more';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('image/partners'), $fileName);
            $validated['image'] = 'image/partners/' . $fileName;
        }

        unset($validated['image_file']);

        $pillar->update($validated);

        return redirect()
            ->route('backoffice.partnership-pillar.index')
            ->with('success', 'Pilar kemitraan berhasil diperbarui!');
    }

    public function toggleActive($id)
    {
        $pillar = PartnershipPillar::findOrFail($id);
        $pillar->is_active = !$pillar->is_active;
        $pillar->save();

        return redirect()
            ->back()
            ->with('success', 'Status pilar kemitraan berhasil diubah!');
    }

    public function destroy($id)
    {
        $pillar = PartnershipPillar::findOrFail($id);
        $pillar->delete();

        return redirect()
            ->route('backoffice.partnership-pillar.index')
            ->with('success', 'Pilar kemitraan berhasil dihapus!');
    }
}

