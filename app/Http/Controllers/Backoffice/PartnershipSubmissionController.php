<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\PartnershipSubmission;
use App\Models\PartnershipPillar;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnershipSubmissionController extends Controller
{
    /**
     * Tampilkan daftar pengajuan & verifikasi formulir kemitraan
     */
    public function index(Request $request)
    {
        $query = PartnershipSubmission::query();

        // Filter pencarian
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('institusi', 'like', "%{$search}%")
                  ->orWhere('nama_pic', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_wa', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('pillar_title', 'like', "%{$search}%");
            });
        }

        // Filter status tab
        $currentStatus = $request->status;
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Urutan: pending paling atas jika semua, atau urutan ASC + verified_at
        if ($currentStatus === 'approved') {
            $submissions = $query->orderBy('urutan', 'asc')->latest('verified_at')->paginate(15)->withQueryString();
        } else {
            $submissions = $query->latest()->paginate(15)->withQueryString();
        }

        // Statistik ringkasan
        $totalAll = PartnershipSubmission::count();
        $totalPending = PartnershipSubmission::where('status', 'pending')->count();
        $totalApproved = PartnershipSubmission::where('status', 'approved')->count();
        $totalRejected = PartnershipSubmission::where('status', 'rejected')->count();

        $pillars = PartnershipPillar::where('is_active', true)->orderBy('order', 'asc')->get();

        return view('backoffice.partnership.submissions', compact(
            'submissions',
            'totalAll',
            'totalPending',
            'totalApproved',
            'totalRejected',
            'currentStatus',
            'pillars'
        ));
    }

    /**
     * Form tambah mitra langsung dari backoffice
     */
    public function create()
    {
        $pillars = PartnershipPillar::where('is_active', true)->orderBy('order', 'asc')->get();
        return view('backoffice.partnership.create-mitra', compact('pillars'));
    }

    /**
     * Simpan data mitra baru dari backoffice
     */
    public function store(Request $request)
    {
        $request->validate([
            'institusi' => 'required|string|max:255',
            'nama_pic'  => 'nullable|string|max:255',
            'email'     => 'nullable|email|max:255',
            'no_wa'     => 'nullable|string|max:50',
            'kategori'  => 'nullable|string|max:100',
            'website'   => 'nullable|string|max:255',
            'link_gmap' => 'nullable|string',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'status'    => 'required|in:pending,approved,rejected',
            'urutan'    => 'nullable|integer',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . Str::slug($request->institusi) . '.' . $file->getClientOriginalExtension();
            $destination = public_path('image/partnership_logos');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $fileName);
            $logoPath = 'image/partnership_logos/' . $fileName;
        }

        $isApproved = $request->status === 'approved';

        $partner = PartnershipSubmission::create([
            'institusi'    => $request->institusi,
            'kategori'     => $request->kategori,
            'nama_pic'     => $request->nama_pic ?? 'Admin Institusi',
            'email'        => $request->email ?? 'info@' . Str::slug($request->institusi) . '.id',
            'no_wa'        => $request->no_wa ?? '-',
            'website'      => $request->website,
            'link_gmap'    => $request->link_gmap,
            'logo'         => $logoPath,
            'pillar_slug'  => $request->pillar_slug,
            'pillar_title' => $request->pillar_title,
            'pesan'        => $request->pesan,
            'status'       => $request->status,
            'urutan'       => $request->urutan ?? 0,
            'verified_at'  => $isApproved ? now() : null,
            'verified_by'  => $isApproved ? (auth()->user()->name ?? 'Super Admin') : null,
            'admin_notes'  => $request->admin_notes,
        ]);

        $msg = $isApproved
            ? "Mitra '{$partner->institusi}' berhasil ditambahkan dan langsung tampil di halaman Mitra & Klien."
            : "Data mitra '{$partner->institusi}' berhasil disimpan dengan status '{$partner->status}'.";

        return redirect()->route('backoffice.partnership-submission.index', ['status' => $request->status])
            ->with('success', $msg);
    }

    /**
     * Form edit data mitra / pengajuan
     */
    public function edit($id)
    {
        $submission = PartnershipSubmission::findOrFail($id);
        $pillars = PartnershipPillar::where('is_active', true)->orderBy('order', 'asc')->get();
        return view('backoffice.partnership.edit-mitra', compact('submission', 'pillars'));
    }

    /**
     * Update data mitra / pengajuan
     */
    public function update(Request $request, $id)
    {
        $submission = PartnershipSubmission::findOrFail($id);

        $request->validate([
            'institusi' => 'required|string|max:255',
            'nama_pic'  => 'nullable|string|max:255',
            'email'     => 'nullable|email|max:255',
            'no_wa'     => 'nullable|string|max:50',
            'kategori'  => 'nullable|string|max:100',
            'website'   => 'nullable|string|max:255',
            'link_gmap' => 'nullable|string',
            'logo'      => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'status'    => 'required|in:pending,approved,rejected',
            'urutan'    => 'nullable|integer',
        ]);

        $logoPath = $submission->logo;
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada di folder uploads
            if ($submission->logo && str_contains($submission->logo, 'partnership_logos') && file_exists(public_path($submission->logo))) {
                @unlink(public_path($submission->logo));
            }

            $file = $request->file('logo');
            $fileName = time() . '_' . Str::slug($request->institusi) . '.' . $file->getClientOriginalExtension();
            $destination = public_path('image/partnership_logos');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $fileName);
            $logoPath = 'image/partnership_logos/' . $fileName;
        }

        $wasApproved = $submission->isApproved();
        $nowApproved = $request->status === 'approved';

        $submission->update([
            'institusi'    => $request->institusi,
            'kategori'     => $request->kategori,
            'nama_pic'     => $request->nama_pic ?? $submission->nama_pic,
            'email'        => $request->email ?? $submission->email,
            'no_wa'        => $request->no_wa ?? $submission->no_wa,
            'website'      => $request->website,
            'link_gmap'    => $request->link_gmap,
            'logo'         => $logoPath,
            'pillar_slug'  => $request->pillar_slug ?? $submission->pillar_slug,
            'pillar_title' => $request->pillar_title ?? $submission->pillar_title,
            'pesan'        => $request->pesan,
            'status'       => $request->status,
            'urutan'       => $request->urutan ?? 0,
            'verified_at'  => $nowApproved ? ($submission->verified_at ?? now()) : null,
            'verified_by'  => $nowApproved ? ($submission->verified_by ?? (auth()->user()->name ?? 'Super Admin')) : null,
            'admin_notes'  => $request->admin_notes,
        ]);

        return redirect()->route('backoffice.partnership-submission.index', ['status' => $request->status])
            ->with('success', "Data mitra '{$submission->institusi}' berhasil diperbarui.");
    }

    /**
     * Aksi cepat verifikasi (Approve / Reject / Pending) oleh Super Admin
     */
    public function updateStatus(Request $request, $id)
    {
        $submission = PartnershipSubmission::findOrFail($id);
        $newStatus = $request->input('status', 'approved');

        if ($newStatus === 'approved') {
            $submission->update([
                'status'      => 'approved',
                'verified_at' => now(),
                'verified_by' => auth()->user()->name ?? 'Super Admin',
                'admin_notes' => $request->input('admin_notes', $submission->admin_notes),
            ]);

            return back()->with('success', "Permohonan kemitraan dari '{$submission->institusi}' berhasil DISETUJUI & DIVERIFIKASI! Logo dan nama mitra kini resmi tayang di halaman publik Mitra & Klien.");
        } elseif ($newStatus === 'rejected') {
            $submission->update([
                'status'      => 'rejected',
                'admin_notes' => $request->input('admin_notes', $submission->admin_notes),
            ]);

            return back()->with('success', "Permohonan kemitraan dari '{$submission->institusi}' telah DITOLAK.");
        } else {
            // Batalkan verifikasi -> kembalikan ke pending
            $submission->update([
                'status'      => 'pending',
                'verified_at' => null,
                'verified_by' => null,
            ]);

            return back()->with('success', "Verifikasi '{$submission->institusi}' dibatalkan (dikembalikan ke Menunggu Verifikasi).");
        }
    }

    /**
     * Hapus data pengajuan
     */
    public function destroy($id)
    {
        $submission = PartnershipSubmission::findOrFail($id);

        if ($submission->logo && str_contains($submission->logo, 'partnership_logos') && file_exists(public_path($submission->logo))) {
            @unlink(public_path($submission->logo));
        }

        $name = $submission->institusi;
        $submission->delete();

        return redirect()->route('backoffice.partnership-submission.index')
            ->with('success', "Data mitra/pengajuan '{$name}' berhasil dihapus.");
    }
}
