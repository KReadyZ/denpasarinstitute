<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['konsultan', 'grcs']);
        
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        $totalKonsultan = User::where('role', 'konsultan')->count();
        $totalGrcs = User::where('role', 'grcs')->count();
        $totalActive = User::whereIn('role', ['konsultan', 'grcs'])->where('is_active', true)->count();
        $totalInactive = User::whereIn('role', ['konsultan', 'grcs'])->where('is_active', false)->count();
        
        return view('backoffice.users.index', compact(
            'users', 'totalKonsultan', 'totalGrcs', 'totalActive', 'totalInactive'
        ));
    }

    public function create()
    {
        return view('backoffice.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:konsultan,grcs',
            'nip_nim' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'membership_type' => 'required|in:regular,premium,vip',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['member_since'] = now();

        User::create($validated);

        return redirect()->route('backoffice.users.index')
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backoffice.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:konsultan,grcs',
            'nip_nim' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'membership_type' => 'required|in:regular,premium,vip',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active', false);

        $user->update($validated);

        return redirect()->route('backoffice.users.index')
            ->with('success', 'Data anggota berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        return redirect()->route('backoffice.users.index')
            ->with('success', "Anggota {$userName} berhasil dihapus! 🗑️");
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('backoffice.users.index')
            ->with('success', "Akun {$user->name} berhasil {$status}");
    }
}