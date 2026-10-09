<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $testimonials = Testimonial::orderBy('order')->orderByDesc('created_at')->paginate(10);
        return view('backoffice.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        return view('backoffice.testimonial.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'role'        => 'nullable|string|max:255',
            'tag'         => 'nullable|string|max:100',
            'quote'       => 'required|string|max:1000',
            'rating'      => 'required|integer|min:1|max:5',
            'avatar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_approved' => 'nullable|boolean',
            'order'       => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $validated['is_approved'] = $request->has('is_approved');
        $validated['order']       = $request->input('order', 0);

        Testimonial::create($validated);

        return redirect()->route('backoffice.testimonial.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backoffice.testimonial.edit', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'role'        => 'nullable|string|max:255',
            'tag'         => 'nullable|string|max:100',
            'quote'       => 'required|string|max:1000',
            'rating'      => 'required|integer|min:1|max:5',
            'avatar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_approved' => 'nullable|boolean',
            'order'       => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) {
                Storage::disk('public')->delete($testimonial->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $validated['is_approved'] = $request->has('is_approved');
        $validated['order']       = $request->input('order', 0);

        $testimonial->update($validated);

        return redirect()->route('backoffice.testimonial.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->avatar) {
            Storage::disk('public')->delete($testimonial->avatar);
        }
        $testimonial->delete();

        return redirect()->route('backoffice.testimonial.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }

    public function toggleApprove($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_approved' => !$testimonial->is_approved]);

        return redirect()->route('backoffice.testimonial.index')
            ->with('success', 'Status testimoni berhasil diubah.');
    }
}