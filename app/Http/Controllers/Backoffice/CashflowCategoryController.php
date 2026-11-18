<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\CashflowCategory;
use App\Models\Cashflow;
use Illuminate\Http\Request;

class CashflowCategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori transaksi kas
     */
    public function index(?Request $request = null)
    {
        $request = $request ?? request();
        $query = CashflowCategory::query();

        // Filter tipe
        if ($request->filled('tipe') && in_array($request->tipe, ['masuk', 'keluar'])) {
            $query->where('tipe', $request->tipe);
        }

        // Filter status
        if ($request->filled('status') && in_array($request->status, ['active', 'inactive'])) {
            $query->where('is_active', $request->status === 'active');
        }

        // Pencarian
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('nama', 'like', "%{$q}%")
                    ->orWhere('kode', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        $categories = $query->orderBy('tipe', 'asc')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $countMasuk = CashflowCategory::where('tipe', 'masuk')->count();
        $countKeluar = CashflowCategory::where('tipe', 'keluar')->count();
        $countTotal = CashflowCategory::count();

        // Hitung relasi penggunaan transaksi kas per kategori
        $usageCounts = Cashflow::selectRaw('kode_kategori, count(*) as total')
            ->groupBy('kode_kategori')
            ->pluck('total', 'kode_kategori')
            ->toArray();

        return view('backoffice.cashflow.kategori.index', compact(
            'categories',
            'countMasuk',
            'countKeluar',
            'countTotal',
            'usageCounts'
        ));
    }

    /**
     * Tampilkan form tambah kategori
     */
    public function create(?Request $request = null)
    {
        $request = $request ?? request();
        $defaultTipe = $request->get('tipe', 'masuk');
        if (!in_array($defaultTipe, ['masuk', 'keluar'])) {
            $defaultTipe = 'masuk';
        }

        return view('backoffice.cashflow.kategori.create', compact('defaultTipe'));
    }

    /**
     * Simpan kategori baru
     */
    public function store(Request $request)
    {
        // Format kode menjadi uppercase
        $kode = strtoupper(trim($request->kode ?? ''));
        $request->merge(['kode' => $kode]);

        $request->validate([
            'tipe'      => 'required|in:masuk,keluar',
            'kode'      => 'required|string|max:30|unique:cashflow_categories,kode',
            'nama'      => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], [
            'tipe.required' => 'Pilih jenis transaksi kas (Uang Masuk / Keluar).',
            'kode.required' => 'Kode kategori wajib diisi.',
            'kode.unique'   => 'Kode kategori ini sudah digunakan. Gunakan kode lain.',
            'nama.required' => 'Nama kategori wajib diisi.',
        ]);

        CashflowCategory::create([
            'tipe'      => $request->tipe,
            'kode'      => $kode,
            'nama'      => trim($request->nama),
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->filled('urutan') ? (int) $request->urutan : 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        $successMsg = "Kategori [{$kode}] {$request->nama} berhasil ditambahkan!";

        if ($request->input('submit_action') === 'save_and_add') {
            return redirect()->route('backoffice.cashflow.kategori.create')
                ->with('success', $successMsg . ' Silakan tambah kategori lainnya.');
        }

        return redirect()->route('backoffice.cashflow.kategori.index')
            ->with('success', $successMsg);
    }

    /**
     * Tampilkan form edit kategori
     */
    public function edit($id)
    {
        $category = CashflowCategory::findOrFail($id);

        $usageCount = Cashflow::where('kode_kategori', $category->kode)->count();

        return view('backoffice.cashflow.kategori.edit', compact('category', 'usageCount'));
    }

    /**
     * Perbarui data kategori
     */
    public function update(Request $request, $id)
    {
        $category = CashflowCategory::findOrFail($id);

        $kode = strtoupper(trim($request->kode ?? ''));
        $request->merge(['kode' => $kode]);

        $request->validate([
            'tipe'      => 'required|in:masuk,keluar',
            'kode'      => 'required|string|max:30|unique:cashflow_categories,kode,' . $category->id,
            'nama'      => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'urutan'    => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], [
            'kode.required' => 'Kode kategori wajib diisi.',
            'kode.unique'   => 'Kode kategori ini sudah digunakan.',
            'nama.required' => 'Nama kategori wajib diisi.',
        ]);

        $oldKode = $category->kode;
        $category->update([
            'tipe'      => $request->tipe,
            'kode'      => $kode,
            'nama'      => trim($request->nama),
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->filled('urutan') ? (int) $request->urutan : 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        // Jika kode berubah, sinkronkan catatan kas yang masih mengacu pada kode lama
        if ($oldKode !== $kode) {
            Cashflow::where('kode_kategori', $oldKode)->update([
                'kode_kategori' => $kode,
            ]);
        }

        return redirect()->route('backoffice.cashflow.kategori.index')
            ->with('success', "Kategori [{$kode}] berhasil diperbarui!");
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        $category = CashflowCategory::findOrFail($id);

        // Cek apakah ada transaksi kas yang menggunakan kategori ini
        $countUsage = Cashflow::where('kode_kategori', $category->kode)
            ->orWhere('kategori', $category->nama)
            ->count();

        if ($countUsage > 0) {
            return redirect()->route('backoffice.cashflow.kategori.index')
                ->with('error', "Kategori [{$category->kode}] tidak dapat dihapus karena sudah memiliki {$countUsage} data transaksi kas. Anda dapat menonaktifkannya agar tidak muncul lagi pada pilihan form baru.");
        }

        $nama = $category->nama;
        $category->delete();

        return redirect()->route('backoffice.cashflow.kategori.index')
            ->with('success', "Kategori [{$nama}] berhasil dihapus.");
    }

    /**
     * Toggle status aktif/non-aktif kategori dengan 1 klik
     */
    public function toggle($id)
    {
        $category = CashflowCategory::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        $statusLabel = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Kategori [{$category->kode}] berhasil {$statusLabel}.");
    }
}

