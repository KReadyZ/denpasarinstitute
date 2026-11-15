<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return view('backoffice.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle upload foto QRIS
        if ($request->hasFile('qris_image')) {
            $request->validate([
                'qris_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);
            $file = $request->file('qris_image');
            $filename = 'qris_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('qris', $filename, 'public');
            SiteSetting::set('qris_image', $path, 'admission', 'Foto Barcode QRIS');
        } elseif ($request->filled('remove_qris_image')) {
            $oldPath = SiteSetting::get('qris_image');
            if ($oldPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($oldPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            SiteSetting::set('qris_image', null, 'admission', 'Foto Barcode QRIS');
        }

        $data = $request->except(['_token', '_method', 'qris_image', 'remove_qris_image', 'current_tab']);

        foreach ($data as $key => $value) {
            // Determine appropriate group based on key prefix
            $group = 'general';
            if (str_starts_with($key, 'contact_')) $group = 'contact';
            elseif (str_starts_with($key, 'social_')) $group = 'social';
            elseif (str_starts_with($key, 'footer_')) $group = 'footer';
            elseif (str_starts_with($key, 'sambutan_')) $group = 'home';
            elseif (str_starts_with($key, 'partner_')) $group = 'partner';
            elseif (str_starts_with($key, 'admission_') || str_starts_with($key, 'bank_') || str_starts_with($key, 'qris_') || str_starts_with($key, 'tunai_') || str_starts_with($key, 'transfer_')) $group = 'admission';

            SiteSetting::set($key, $value, $group);
        }

        SiteSetting::clearCache();

        $activeTab = $request->get('current_tab', 'contact');

        return redirect()
            ->route('backoffice.settings.index', ['tab' => $activeTab])
            ->with('success', 'Semua pengaturan website, formulir dan konten berhasil diperbarui!');
    }
}

