<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::orderBy('order')->get();
        return view('backoffice.statistic.index', compact('statistics'));
    }

    public function create()
    {
        return view('backoffice.statistic.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        Statistic::create($validated);

        return redirect()->route('backoffice.statistic.index')
            ->with('success', 'Statistik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $statistic = Statistic::findOrFail($id);
        return view('backoffice.statistic.edit', compact('statistic'));
    }

    public function update(Request $request, $id)
    {
        $statistic = Statistic::findOrFail($id);
        $validated = $this->validateData($request);
        $statistic->update($validated);

        return redirect()->route('backoffice.statistic.index')
            ->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->delete();

        return redirect()->route('backoffice.statistic.index')
            ->with('success', 'Statistik berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->update(['is_active' => !$statistic->is_active]);

        return back()->with('success', 'Status statistik berhasil diubah.');
    }

    private function validateData(Request $request): array
    {
        $validated = $request->validate([
            'icon'              => 'required|string|max:50',
            'number'            => 'required|integer|min:0',
            'label'             => 'required|string|max:100',
            'trend_percentage'  => 'nullable|integer|min:0|max:999',
            'trend_direction'   => 'required|in:up,down',
            'order'             => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order']     = $validated['order'] ?? 0;

        return $validated;
    }
}