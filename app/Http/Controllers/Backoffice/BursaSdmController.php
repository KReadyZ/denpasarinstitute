<?php
namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\BursaSdm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BursaSdmController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->get('tipe');
        $status = $request->get('status');

        $query = BursaSdm::query();
        if ($tipe) $query->where('tipe', $tipe);
        if ($status) $query->where('status', $status);

        $items = $query->latest()->paginate(15)->withQueryString();

        return view('backoffice.bursa-sdm.index', compact('items', 'tipe', 'status'));
    }

    public function create()
    {
        return view('backoffice.bursa-sdm.create');
    }

    public function store(Request $request)
    {
        $fotoRule = $request->input('tipe') === 'individu'
            ? 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            : 'nullable|file|mimes:jpg,jpeg,png|max:2048';

        $request->validate([
            'tipe' => 'required|in:perusahaan,individu',
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'email' => 'nullable|email',
            'kategori' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => $fotoRule,
            'alamat' => 'nullable|string',
            'website' => 'nullable|string',
            'bidang_usaha' => 'nullable|string',
            'keahlian' => 'nullable|string',
            'posisi_dicari' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except('foto', 'is_active');
        $data['is_active'] = $request->has('is_active') && $request->status === 'approved';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('bursa-sdm', 'public');
        }

        BursaSdm::create($data);

        return redirect()->route('backoffice.bursa-sdm.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = BursaSdm::findOrFail($id);
        return view('backoffice.bursa-sdm.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = BursaSdm::findOrFail($id);

        $fotoRule = $request->input('tipe') === 'individu'
            ? 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
            : 'nullable|file|mimes:jpg,jpeg,png|max:2048';

        $request->validate([
            'tipe' => 'required|in:perusahaan,individu',
            'nama' => 'required|string|max:255',
            'no_wa' => 'required|string|max:20',
            'email' => 'nullable|email',
            'kategori' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => $fotoRule,
            'alamat' => 'nullable|string',
            'website' => 'nullable|string',
            'bidang_usaha' => 'nullable|string',
            'keahlian' => 'nullable|string',
            'posisi_dicari' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->except('foto', 'is_active');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('foto')) {
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            $data['foto'] = $request->file('foto')->store('bursa-sdm', 'public');
        }

        $item->update($data);

        return redirect()->route('backoffice.bursa-sdm.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function approve($id)
    {
        $item = BursaSdm::findOrFail($id);
        $item->update(['status' => 'approved', 'is_active' => true]);
        return back()->with('success', 'Data disetujui dan tampil di halaman publik.');
    }

    public function reject($id)
    {
        $item = BursaSdm::findOrFail($id);
        $item->update(['status' => 'rejected', 'is_active' => false]);
        return back()->with('success', 'Data ditolak.');
    }

    public function toggleActive($id)
    {
        $item = BursaSdm::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);
        return back()->with('success', 'Status tampil diperbarui.');
    }

    public function destroy($id)
    {
        $item = BursaSdm::findOrFail($id);
        if ($item->foto) Storage::disk('public')->delete($item->foto);
        $item->delete();
        return back()->with('success', 'Data dihapus.');
    }
}