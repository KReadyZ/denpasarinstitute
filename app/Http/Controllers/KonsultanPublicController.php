<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KonsultanPublicController extends Controller
{

    public function index(Request $request)
    {
        $query = User::konsultan('is_active', true)
            ->orderBy('name', 'asc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('institution', 'like', "%{$q}%")
                    ->orWhere('position', 'like', "%{$q}%");
            });
        }

        $konsultans = $query->paginate(12);

        return view('konsultan.index', compact('konsultans'));
    }


    public function show($id)
    {
        $konsultan = User::konsultan('is_active', true)->findOrFail($id);

        return view('konsultan.show', compact('konsultan'));
    }
}