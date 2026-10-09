<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'role'   => 'nullable|string|max:255',
            'tag'    => 'nullable|string|max:100',
            'quote'  => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $validated['is_approved'] = false;

        Testimonial::create($validated);

        return redirect()->back()
            ->with('success', 'Terima kasih! Apresiasi Anda telah kami terima dan akan tampil setelah diverifikasi.');
    }
}