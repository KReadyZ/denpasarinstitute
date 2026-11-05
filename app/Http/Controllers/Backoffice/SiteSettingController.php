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
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Determine appropriate group based on key prefix
            $group = 'general';
            if (str_starts_with($key, 'contact_')) $group = 'contact';
            elseif (str_starts_with($key, 'social_')) $group = 'social';
            elseif (str_starts_with($key, 'footer_')) $group = 'footer';
            elseif (str_starts_with($key, 'sambutan_')) $group = 'home';
            elseif (str_starts_with($key, 'partner_')) $group = 'partner';

            SiteSetting::set($key, $value, $group);
        }

        SiteSetting::clearCache();

        return redirect()
            ->route('backoffice.settings.index')
            ->with('success', 'Semua pengaturan website dan konten berhasil diperbarui!');
    }
}

