<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminManagementController extends Controller
{
    /**
     * Tampilkan daftar akun Admin & Finance dengan data Role Dinamis dari Database
     */
    public function index(Request $request)
    {
        // Ambil daftar role internal secara dinamis dari tabel roles
        $staffRoles = Role::internal()->orderBy('order')->orderBy('id')->get();
        $availableSlugs = $staffRoles->pluck('slug')->toArray();

        // Jika tabel roles belum memiliki data, fallback ke role inti
        if (empty($availableSlugs)) {
            $availableSlugs = ['superadmin', 'admin', 'finance'];
        }

        $query = User::whereIn('role', $availableSlugs)->with('roleModel');

        // Filter Role Dinamis
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter Status Aktif/Nonaktif
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Pencarian Nama / Email / Telepon
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Urutkan: superadmin di atas, lalu berdasarkan created_at desc
        $users = $query->orderByRaw("CASE WHEN role = 'superadmin' THEN 1 ELSE 2 END")
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Hitung statistik ringkasan per role secara dinamis
        $roleCounts = [];
        foreach ($staffRoles as $sr) {
            $roleCounts[$sr->slug] = User::where('role', $sr->slug)->count();
        }

        $totalActive   = User::whereIn('role', $availableSlugs)->where('is_active', true)->count();
        $totalInactive = User::whereIn('role', $availableSlugs)->where('is_active', false)->count();
        $totalStaff    = User::whereIn('role', $availableSlugs)->count();

        return view('backoffice.admin-management.index', compact(
            'users',
            'staffRoles',
            'roleCounts',
            'totalActive',
            'totalInactive',
            'totalStaff'
        ));
    }

    /**
     * Simpan akun Admin / Finance baru (Role divalidasi ke tabel roles)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'role'                  => ['required', 'string', Rule::exists('roles', 'slug')->where('is_active', true)],
            'phone'                 => 'nullable|string|max:30',
            'password'              => 'required|string|min:8|confirmed',
            'is_active'             => 'nullable|boolean',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Alamat email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email tersebut sudah terdaftar di sistem.',
            'role.required'         => 'Silakan pilih peran (role) akun.',
            'role.exists'           => 'Role yang dipilih tidak valid atau sudah nonaktif.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal harus 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = new User();
        $user->name            = $validated['name'];
        $user->email           = strtolower(trim($validated['email']));
        $user->role            = $validated['role'];
        $user->phone           = $validated['phone'] ?? null;
        $user->password        = Hash::make($validated['password']);
        $user->password_plain  = Crypt::encryptString($validated['password']);
        $user->is_active       = $request->boolean('is_active', true);
        $user->membership_type = 'vip';
        $user->member_since    = now();
        $user->save();

        $roleModel = Role::where('slug', $user->role)->first();
        $roleName = $roleModel ? $roleModel->name : ucfirst($user->role);

        return redirect()->route('backoffice.admin-management.index')
            ->with('success', "Akun {$roleName} ({$user->name}) berhasil dibuat!");
    }

    /**
     * Update data profil akun (Nama, Email, Role, Telepon, Status)
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'      => ['required', 'string', Rule::exists('roles', 'slug')->where('is_active', true)],
            'phone'     => 'nullable|string|max:30',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.unique'   => 'Email tersebut sudah digunakan oleh akun lain.',
            'role.required'  => 'Role wajib ditentukan.',
            'role.exists'    => 'Role yang dipilih tidak valid atau sudah nonaktif.',
        ]);

        // Cegah Super Admin mengubah rolenya sendiri menjadi role selain superadmin jika sedang login
        if ($user->id === Auth::id() && $validated['role'] !== 'superadmin') {
            return back()->with('error', 'Anda tidak dapat menurunkan role akun Anda sendiri saat sedang login.');
        }

        // Cegah menonaktifkan akun sendiri
        if ($user->id === Auth::id() && !$request->boolean('is_active', true)) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri yang sedang digunakan.');
        }

        $user->name      = $validated['name'];
        $user->email     = strtolower(trim($validated['email']));
        $user->role      = $validated['role'];
        $user->phone     = $validated['phone'] ?? null;
        $user->is_active = $request->boolean('is_active', false);
        $user->save();

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data akun {$user->name} berhasil diperbarui!",
                'user'    => $user
            ]);
        }

        return redirect()->route('backoffice.admin-management.index')
            ->with('success', "Data akun {$user->name} berhasil diperbarui!");
    }

    /**
     * Reset / Ubah Password akun oleh Super Admin
     */
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        $user->password = Hash::make($request->password);
        $user->password_plain = Crypt::encryptString($request->password);
        $user->save();

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Password untuk akun {$user->name} ({$user->email}) berhasil diperbarui!"
            ]);
        }

        return redirect()->route('backoffice.admin-management.index')
            ->with('success', "Password untuk akun {$user->name} ({$user->email}) berhasil diperbarui!");
    }

    /**
     * Toggle status aktif / nonaktif akun
     */
    public function toggleActive(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            $msg = 'Anda tidak dapat menonaktifkan akun Anda sendiri yang sedang aktif.';
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $msg = "Akun {$user->name} ({$user->email}) berhasil {$statusStr}!";

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'   => true,
                'is_active' => $user->is_active,
                'message'   => $msg
            ]);
        }

        return redirect()->route('backoffice.admin-management.index')->with('success', $msg);
    }

    /**
     * Hapus akun admin / finance
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            $msg = 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.';
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->with('error', $msg);
        }

        $name = $user->name;
        $email = $user->email;
        $user->delete();

        $msg = "Akun {$name} ({$email}) berhasil dihapus!";

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg
            ]);
        }

        return redirect()->route('backoffice.admin-management.index')->with('success', $msg);
    }

    /**
     * Tambah Role Baru secara Dinamis oleh Super Admin
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'slug'        => 'nullable|string|max:50|unique:roles,slug',
            'description' => 'nullable|string|max:500',
            'badge_color' => 'required|in:primary,secondary,success,danger,warning,info,dark',
            'icon'        => 'required|string|max:50',
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'slug.unique'   => 'Kode/slug role sudah digunakan.',
        ]);

        $slug = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        // Pastikan unik
        $originalSlug = $slug;
        $count = 1;
        while (Role::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $role = Role::create([
            'name'        => $validated['name'],
            'slug'        => $slug,
            'category'    => 'internal',
            'description' => $validated['description'] ?? null,
            'badge_color' => $validated['badge_color'],
            'icon'        => $validated['icon'],
            'is_system'   => false,
            'is_active'   => true,
            'order'       => Role::max('order') + 1,
        ]);

        return redirect()->route('backoffice.admin-management.index')
            ->with('success', "Role baru \"{$role->name}\" berhasil ditambahkan ke database!");
    }

    /**
     * Update data Role Dinamis
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'badge_color' => 'required|in:primary,secondary,success,danger,warning,info,dark',
            'icon'        => 'required|string|max:50',
            'is_active'   => 'nullable|boolean',
        ]);

        $role->name        = $validated['name'];
        $role->description = $validated['description'] ?? null;
        $role->badge_color = $validated['badge_color'];
        $role->icon        = $validated['icon'];
        if (!$role->is_system) {
            $role->is_active = $request->boolean('is_active', true);
        }
        $role->save();

        return redirect()->route('backoffice.admin-management.index')
            ->with('success', "Data role \"{$role->name}\" berhasil diperbarui!");
    }

    /**
     * Hapus Role Dinamis (hanya non-sistem & yang tidak sedang dipakai akun aktif)
     */
    public function destroyRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($role->is_system) {
            return back()->with('error', "Role \"{$role->name}\" adalah role sistem inti dan tidak boleh dihapus.");
        }

        $assignedCount = User::where('role', $role->slug)->count();
        if ($assignedCount > 0) {
            return back()->with('error', "Role \"{$role->name}\" masih digunakan oleh {$assignedCount} akun. Ubah role akun tersebut terlebih dahulu sebelum menghapus role ini.");
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('backoffice.admin-management.index')
            ->with('success', "Role \"{$roleName}\" berhasil dihapus dari database!");
    }
}
