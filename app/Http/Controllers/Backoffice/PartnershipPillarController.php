<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PartnershipPillar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'number'            => 'required|string|max:10',
            'title'             => 'required|string|max:150',
            'slug'              => 'nullable|string|max:150',
            'subtitle'          => 'nullable|string|max:255',
            'badge'             => 'nullable|string|max:150',
            'hero_title'        => 'nullable|string|max:255',
            'hero_sub'          => 'nullable|string',
            'tag'               => 'required|string|max:100',
            'icon'              => 'nullable|string|max:50',
            'description'       => 'required|string',
            'link_url'          => 'nullable|string|max:255',
            'link_text'         => 'nullable|string|max:50',
            'order'             => 'required|integer',
            'image_file'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image'             => 'nullable|string|max:255',
            'detail_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'detail_image'      => 'nullable|string|max:255',
            'image_tag'         => 'nullable|string|max:150',
            'image_sub'         => 'nullable|string|max:255',
            'intro'             => 'nullable|string',
            'cta_title'         => 'nullable|string|max:255',
            'cta_sub'           => 'nullable|string',
            'wa_text'           => 'nullable|string|max:500',
            'wa_btn'            => 'nullable|string|max:100',
            'services'          => 'nullable|array',
            'highlights'        => 'nullable|array',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['link_text'] = $validated['link_text'] ?? 'Learn more';
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Upload foto kartu utama
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_card_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('image/partners'), $fileName);
            $validated['image'] = 'image/partners/' . $fileName;
        }

        // Upload foto detail showcase
        if ($request->hasFile('detail_image_file')) {
            $file = $request->file('detail_image_file');
            $fileName = time() . '_detail_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('image/partners'), $fileName);
            $validated['detail_image'] = 'image/partners/' . $fileName;
        }

        // Format services array
        if (isset($validated['services']) && is_array($validated['services'])) {
            $cleanedServices = [];
            foreach ($validated['services'] as $svc) {
                if (!empty($svc['title'])) {
                    $cleanedServices[] = [
                        'icon'  => $svc['icon'] ?? 'fa-check',
                        'title' => $svc['title'],
                        'desc'  => $svc['desc'] ?? '',
                    ];
                }
            }
            $validated['services'] = $cleanedServices;
        }

        // Format highlights array
        if (isset($validated['highlights']) && is_array($validated['highlights'])) {
            $cleanedHighlights = [];
            foreach ($validated['highlights'] as $hl) {
                if (!empty($hl['title'])) {
                    $cleanedHighlights[] = [
                        'icon'  => $hl['icon'] ?? 'fa-star',
                        'title' => $hl['title'],
                        'desc'  => $hl['desc'] ?? '',
                    ];
                }
            }
            $validated['highlights'] = $cleanedHighlights;
        }

        unset($validated['image_file'], $validated['detail_image_file']);

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
            'number'            => 'required|string|max:10',
            'title'             => 'required|string|max:150',
            'slug'              => 'nullable|string|max:150',
            'subtitle'          => 'nullable|string|max:255',
            'badge'             => 'nullable|string|max:150',
            'hero_title'        => 'nullable|string|max:255',
            'hero_sub'          => 'nullable|string',
            'tag'               => 'required|string|max:100',
            'icon'              => 'nullable|string|max:50',
            'description'       => 'required|string',
            'link_url'          => 'nullable|string|max:255',
            'link_text'         => 'nullable|string|max:50',
            'order'             => 'required|integer',
            'image_file'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'image'             => 'nullable|string|max:255',
            'detail_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'detail_image'      => 'nullable|string|max:255',
            'image_tag'         => 'nullable|string|max:150',
            'image_sub'         => 'nullable|string|max:255',
            'intro'             => 'nullable|string',
            'cta_title'         => 'nullable|string|max:255',
            'cta_sub'           => 'nullable|string',
            'wa_text'           => 'nullable|string|max:500',
            'wa_btn'            => 'nullable|string|max:100',
            'services'          => 'nullable|array',
            'highlights'        => 'nullable|array',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['link_text'] = $validated['link_text'] ?? 'Learn more';
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Upload foto kartu utama jika ada file baru
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '_card_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('image/partners'), $fileName);
            $validated['image'] = 'image/partners/' . $fileName;
        }

        // Upload foto detail showcase jika ada file baru
        if ($request->hasFile('detail_image_file')) {
            $file = $request->file('detail_image_file');
            $fileName = time() . '_detail_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('image/partners'), $fileName);
            $validated['detail_image'] = 'image/partners/' . $fileName;
        }

        // Format services array
        if (isset($validated['services']) && is_array($validated['services'])) {
            $cleanedServices = [];
            foreach ($validated['services'] as $svc) {
                if (!empty($svc['title'])) {
                    $cleanedServices[] = [
                        'icon'  => $svc['icon'] ?? 'fa-check',
                        'title' => $svc['title'],
                        'desc'  => $svc['desc'] ?? '',
                    ];
                }
            }
            $validated['services'] = $cleanedServices;
        }

        // Format highlights array
        if (isset($validated['highlights']) && is_array($validated['highlights'])) {
            $cleanedHighlights = [];
            foreach ($validated['highlights'] as $hl) {
                if (!empty($hl['title'])) {
                    $cleanedHighlights[] = [
                        'icon'  => $hl['icon'] ?? 'fa-star',
                        'title' => $hl['title'],
                        'desc'  => $hl['desc'] ?? '',
                    ];
                }
            }
            $validated['highlights'] = $cleanedHighlights;
        }

        unset($validated['image_file'], $validated['detail_image_file']);

        $pillar->update($validated);

        return redirect()
            ->route('backoffice.partnership-pillar.index')
            ->with('success', 'Pilar kemitraan dan detail halaman berhasil diperbarui!');
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
