<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class GrcsPublicController extends Controller
{

    public function index(Request $request)
    {
        $query = User::Grcs('is_active', true)
            ->orderBy('name', 'asc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('institution', 'like', "%{$q}%")
                    ->orWhere('position', 'like', "%{$q}%");
            });
        }

        $members = $query->paginate(12);

        return view('grcs.index', compact('members'));
    }


    public function show($id)
    {
        $member = User::Grcs('is_active', true)->findOrFail($id);

        return view('grcs.show', compact('member'));
    }
}