<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::orderBy('order')->get();
        return view('backoffice.slider.index', compact('sliders'));
    }

    public function create()
    {
        $nextOrder = (HeroSlider::max('order') ?? -1) + 1;
        return view('backoffice.slider.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|in:banner,divisi',
            'order' => 'required|integer',
        ]);

        $data = $request->only([
            'title', 'subtitle', 'button_text', 'button_url',
            'order', 'is_active', 'type', 'divisi_name'
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['stats'] = $this->cleanStats($request->input('stats', []));

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $request->file('background_image')
                ->store('slider/backgrounds', 'public');
        }

        if ($request->hasFile('logo_image')) {
            $data['logo_image'] = $request->file('logo_image')
                ->store('slider/logos', 'public');
        }

        HeroSlider::create($data);

        return redirect()->route('backoffice.slider.index')
            ->with('success', 'Slide berhasil ditambahkan.');
    }

    public function edit(HeroSlider $slider)
    {
        return view('backoffice.slider.edit', compact('slider'));
    }

    public function update(Request $request, HeroSlider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|in:banner,divisi',
            'order' => 'required|integer',
        ]);

        $data = $request->only([
            'title', 'subtitle', 'button_text', 'button_url',
            'order', 'type', 'divisi_name'
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['stats'] = $this->cleanStats($request->input('stats', []));

        if ($request->hasFile('background_image')) {
            if ($slider->background_image) Storage::disk('public')->delete($slider->background_image);
            $data['background_image'] = $request->file('background_image')
                ->store('slider/backgrounds', 'public');
        }

        if ($request->hasFile('logo_image')) {
            if ($slider->logo_image) Storage::disk('public')->delete($slider->logo_image);
            $data['logo_image'] = $request->file('logo_image')
                ->store('slider/logos', 'public');
        }

        $slider->update($data);

        return redirect()->route('backoffice.slider.index')
            ->with('success', 'Slide berhasil diperbarui.');
    }

    public function destroy(HeroSlider $slider)
    {
        if ($slider->background_image) Storage::disk('public')->delete($slider->background_image);
        if ($slider->logo_image) Storage::disk('public')->delete($slider->logo_image);
        $slider->delete();

        return redirect()->route('backoffice.slider.index')
            ->with('success', 'Slide berhasil dihapus.');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $item) {
            HeroSlider::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Bersihkan input stats: buang yang kosong, batasi maksimal 6 item.
     */
    private function cleanStats($stats)
    {
        if (!is_array($stats)) {
            return [];
        }

        $cleaned = [];

        foreach ($stats as $stat) {
            $number = trim($stat['number'] ?? '');
            $label  = trim($stat['label'] ?? '');

            // skip kalau dua-duanya kosong
            if ($number === '' && $label === '') {
                continue;
            }

            $cleaned[] = [
                'number' => $number,
                'label'  => $label,
            ];

            if (count($cleaned) >= 6) {
                break;
            }
        }

        return $cleaned;
    }
}