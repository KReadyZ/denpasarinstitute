<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Program;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with('programs')->latest()->paginate(20);
        return view('backoffice.admission.index', compact('admissions'));
    }

    public function create()
    {
        $programs = Program::where('is_active', true)->orderBy('nama')->get();
        return view('backoffice.admission.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'hp_wa' => 'required|string|max:30',
            'email' => 'required|email|max:255',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:programs,id',
            'special_request' => 'nullable|string',
            'bukti_bayar_pendaftaran' => 'nullable|file|max:2048',
            'bukti_bayar_program' => 'nullable|file|max:2048',
            'sumber_informasi' => 'nullable|array',
        ]);

        if ($request->hasFile('bukti_bayar_pendaftaran')) {
            $data['bukti_bayar_pendaftaran'] = $request->file('bukti_bayar_pendaftaran')->store('admission/bukti', 'public');
        }

        if ($request->hasFile('bukti_bayar_program')) {
            $data['bukti_bayar_program'] = $request->file('bukti_bayar_program')->store('admission/bukti', 'public');
        }

        $admission = Admission::create($data);

        if (!empty($data['program_ids'])) {
            $admission->programs()->sync($data['program_ids']);
        }

        return redirect()->route('backoffice.admission.index')->with('success', 'Data pendaftaran ditambahkan.');
    }

    public function edit(Admission $admission)
    {
        $admission->load('programs');
        $programs = Program::where('is_active', true)->orderBy('nama')->get();
        return view('backoffice.admission.edit', compact('admission', 'programs'));
    }

    public function update(Request $request, Admission $admission)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'hp_wa' => 'required|string|max:30',
            'email' => 'required|email|max:255',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:programs,id',
            'special_request' => 'nullable|string',
            'bukti_bayar_pendaftaran' => 'nullable|file|max:2048',
            'bukti_bayar_program' => 'nullable|file|max:2048',
            'sumber_informasi' => 'nullable|array',
        ]);

        if ($request->hasFile('bukti_bayar_pendaftaran')) {
            $data['bukti_bayar_pendaftaran'] = $request->file('bukti_bayar_pendaftaran')->store('admission/bukti', 'public');
        }

        if ($request->hasFile('bukti_bayar_program')) {
            $data['bukti_bayar_program'] = $request->file('bukti_bayar_program')->store('admission/bukti', 'public');
        }

        $admission->update($data);
        $admission->programs()->sync($data['program_ids'] ?? []);

        return redirect()->route('backoffice.admission.index')->with('success', 'Data pendaftaran diperbarui.');
    }

    public function approve(Request $request, Admission $admission)
    {
        $data = $request->validate([
            'catatan_admin' => 'nullable|string',
        ]);

        $admission->update([
            'status' => 'approved',
            'catatan_admin' => $data['catatan_admin'] ?? $admission->catatan_admin,
            'approved_at' => now(),
        ]);

        $this->sendApprovalEmail($admission);

        return back()->with('success', 'Pendaftaran disetujui.');
    }

    public function reject(Request $request, Admission $admission)
    {
        $data = $request->validate([
            'catatan_admin' => 'nullable|string',
        ]);

        $admission->update([
            'status' => 'rejected',
            'catatan_admin' => $data['catatan_admin'] ?? $admission->catatan_admin,
        ]);

        return back()->with('success', 'Pendaftaran ditolak.');
    }

    public function destroy(Admission $admission)
    {
        $admission->delete();
        return back()->with('success', 'Data dihapus.');
    }

    protected function sendApprovalEmail(Admission $admission)
    {
    }
}