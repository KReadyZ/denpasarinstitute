<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\Program;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisiList = \App\Models\Divisi::with(['programs' => function ($q) {
            $q->where('is_active', true)->orderBy('nama');
        }])->where('is_active', true)->orderBy('urutan')->orderBy('nama')->get();

        $programs = Program::with('divisi')
            ->where('is_active', true)
            ->orderBy('divisi_id', 'asc')
            ->orderBy('nama', 'asc')
            ->get();
        
        return view('admission.create', compact('programs', 'divisiList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'hp_wa' => 'required|string|max:30',
            'email' => 'required|email|max:255|unique:admissions,email',
            'program_ids' => 'nullable|array|min:1',
            'program_ids.*' => 'exists:programs,id',
            'special_request' => 'nullable|string|max:5000',
            'nominal_pembayaran' => 'nullable|string',
            'metode_pembayaran' => 'nullable|string|max:100',
            'deskripsi_pembayaran' => 'nullable|string',
            'bukti_bayar_pendaftaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bukti_bayar_program' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sumber_informasi' => 'nullable|array',
            'sumber_informasi.*' => 'string',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'hp_wa.required' => 'Nomor HP/WA harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar sebelumnya.',
            'program_ids.min' => 'Pilih minimal 1 program.',
            'program_ids.*.exists' => 'Program yang dipilih tidak valid.',
            'bukti_bayar_pendaftaran.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
            'bukti_bayar_program.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
        ]);

        // Upload bukti pembayaran pendaftaran
        if ($request->hasFile('bukti_bayar_pendaftaran')) {
            $file = $request->file('bukti_bayar_pendaftaran');
            $filename = 'bukti_pendaftaran_' . time() . '_' . $file->getClientOriginalName();
            $validated['bukti_bayar_pendaftaran'] = $file->storeAs('admission/bukti', $filename, 'public');
        }

        // Upload bukti pembayaran program
        if ($request->hasFile('bukti_bayar_program')) {
            $file = $request->file('bukti_bayar_program');
            $filename = 'bukti_program_' . time() . '_' . $file->getClientOriginalName();
            $validated['bukti_bayar_program'] = $file->storeAs('admission/bukti', $filename, 'public');
        }

        // Convert sumber_informasi array to collection
        if (!empty($validated['sumber_informasi'])) {
            $validated['sumber_informasi'] = $validated['sumber_informasi'];
        }

        // Set default status
        $validated['status'] = 'pending';

        // Sanitasi nominal pembayaran
        if ($request->filled('nominal_pembayaran')) {
            $nomStr = preg_replace('/[^0-9]/', '', (string)$request->nominal_pembayaran);
            $validated['nominal_pembayaran'] = $nomStr ? (float)$nomStr : 250000.00;
        } else {
            $validated['nominal_pembayaran'] = 250000.00;
        }
        $validated['metode_pembayaran'] = $request->metode_pembayaran ?: 'Transfer Bank';
        $validated['status_pembayaran'] = str_contains($validated['metode_pembayaran'], 'DP') ? 'dp' : 'lunas';

        // Create admission record
        $admission = Admission::create($validated);

        // Sync programs
        if (!empty($validated['program_ids'])) {
            $admission->programs()->sync($validated['program_ids']);
        }

        // Return success message
        return redirect()->route('home')
            ->with('success', 'Pendaftaran Anda berhasil dikirim! Kami akan segera memverifikasi data Anda.');
    }
}