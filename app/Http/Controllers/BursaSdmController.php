<?php
namespace App\Http\Controllers;

use App\Models\BursaSdm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BursaSdmController extends Controller
{
    public function index(Request $request)
    {
        $tipe = $request->get('tipe', 'perusahaan'); // default tab
        $kategori = $request->get('kategori');
        $search = $request->get('search');

        $query = BursaSdm::publik()->where('tipe', $tipe);

        if ($kategori && $kategori !== 'all') {
            $query->where('kategori', $kategori);
        }
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $data = $query->latest()->paginate(9)->withQueryString();

        $kategoriList = BursaSdm::publik()
            ->where('tipe', $tipe)
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');

        return view('bursa-sdm.index', compact('data', 'tipe', 'kategoriList', 'search', 'kategori'));
    }

    public function show($slug)
    {
        $item = BursaSdm::publik()->where('slug', $slug)->firstOrFail();
        return view('bursa-sdm.show', compact('item'));
    }

    public function create($tipe)
    {
        abort_unless(in_array($tipe, ['perusahaan', 'individu']), 404);
        return view('bursa-sdm.create', compact('tipe'));
    }

    public function store(Request $request)
    {
        $tipe = $request->input('tipe');

        $fotoRule = $tipe === 'perusahaan'
            ? 'nullable|file|mimes:jpg,jpeg,png|max:2048'
            : 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048';

        $request->validate([
            'tipe' => 'required|in:perusahaan,individu',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email',
            'no_wa' => 'required|string|max:20',
            'kategori' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'foto' => $fotoRule,
            'alamat' => 'nullable|string',
            'website' => 'nullable|string',
            'bidang_usaha' => 'nullable|string',
            'keahlian' => 'nullable|string',
            'posisi_dicari' => 'nullable|string',
        ]);

        $data = $request->except('foto');
        $data['status'] = 'pending';
        $data['is_active'] = false;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('bursa-sdm', 'public');
        }

        BursaSdm::create($data);

        return back()->with('success', 'Data berhasil dikirim! Menunggu verifikasi admin sebelum tampil di halaman publik.');
    }
}