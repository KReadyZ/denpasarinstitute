<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index(Request $request)
    {
        $currentLocation = $request->get('location', 'navbar_left');

        $locations = [
            'navbar_left'      => 'Navbar Kiri',
            'navbar_right'     => 'Navbar Kanan',
            'footer_komunitas' => 'Footer (Komunitas)',
            'footer_kebijakan' => 'Footer (Kebijakan/Bawah)',
        ];

        $items = NavigationItem::where('location', $currentLocation)
            ->orderBy('order', 'asc')
            ->get();

        return view('backoffice.navigation.index', compact('items', 'locations', 'currentLocation'));
    }

    public function create(Request $request)
    {
        $location = $request->get('location', 'navbar_left');
        $locations = [
            'navbar_left'      => 'Navbar Kiri',
            'navbar_right'     => 'Navbar Kanan',
            'footer_komunitas' => 'Footer (Komunitas)',
            'footer_kebijakan' => 'Footer (Kebijakan/Bawah)',
        ];

        return view('backoffice.navigation.create', compact('location', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:100',
            'url'       => 'required|string|max:255',
            'location'  => 'required|string|in:navbar_left,navbar_right,footer_komunitas,footer_kebijakan',
            'order'     => 'required|integer',
            'target'    => 'required|string|in:_self,_blank',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        NavigationItem::create($validated);

        return redirect()
            ->route('backoffice.navigation.index', ['location' => $validated['location']])
            ->with('success', 'Menu navigasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = NavigationItem::findOrFail($id);
        $locations = [
            'navbar_left'      => 'Navbar Kiri',
            'navbar_right'     => 'Navbar Kanan',
            'footer_komunitas' => 'Footer (Komunitas)',
            'footer_kebijakan' => 'Footer (Kebijakan/Bawah)',
        ];

        return view('backoffice.navigation.edit', compact('item', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $item = NavigationItem::findOrFail($id);

        $validated = $request->validate([
            'title'     => 'required|string|max:100',
            'url'       => 'required|string|max:255',
            'location'  => 'required|string|in:navbar_left,navbar_right,footer_komunitas,footer_kebijakan',
            'order'     => 'required|integer',
            'target'    => 'required|string|in:_self,_blank',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $item->update($validated);

        return redirect()
            ->route('backoffice.navigation.index', ['location' => $validated['location']])
            ->with('success', 'Menu navigasi berhasil diperbarui!');
    }

    public function toggleActive($id)
    {
        $item = NavigationItem::findOrFail($id);
        $item->is_active = !$item->is_active;
        $item->save();

        return redirect()
            ->back()
            ->with('success', 'Status menu berhasil diubah!');
    }

    public function destroy($id)
    {
        $item = NavigationItem::findOrFail($id);
        $location = $item->location;
        $item->delete();

        return redirect()
            ->route('backoffice.navigation.index', ['location' => $location])
            ->with('success', 'Menu navigasi berhasil dihapus!');
    }
}

