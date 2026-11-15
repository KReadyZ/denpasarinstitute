<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Program;
use App\Models\Cashflow;
use App\Models\Project;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index()
    {
        $admissions = Admission::with(['programs', 'cashflow'])->latest()->paginate(20);
        return view('backoffice.admission.index', compact('admissions'));
    }

    public function create()
    {
        $divisiList = \App\Models\Divisi::with(['programs' => function ($q) {
            $q->where('is_active', true)->orderBy('nama');
        }])->where('is_active', true)->orderBy('urutan')->orderBy('nama')->get();

        $programs = Program::with('divisi')->where('is_active', true)->orderBy('divisi_id', 'asc')->orderBy('nama', 'asc')->get();
        return view('backoffice.admission.create', compact('programs', 'divisiList'));
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
            'nominal_pembayaran' => 'nullable|string',
            'metode_pembayaran' => 'nullable|string|max:100',
            'deskripsi_pembayaran' => 'nullable|string',
        ]);

        if ($request->hasFile('bukti_bayar_pendaftaran')) {
            $data['bukti_bayar_pendaftaran'] = $request->file('bukti_bayar_pendaftaran')->store('admission/bukti', 'public');
        }

        if ($request->hasFile('bukti_bayar_program')) {
            $data['bukti_bayar_program'] = $request->file('bukti_bayar_program')->store('admission/bukti', 'public');
        }

        if ($request->filled('nominal_pembayaran')) {
            $nomStr = preg_replace('/[^0-9]/', '', (string)$request->nominal_pembayaran);
            $data['nominal_pembayaran'] = $nomStr ? (float)$nomStr : 250000.00;
        } else {
            $data['nominal_pembayaran'] = 250000.00;
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
        $divisiList = \App\Models\Divisi::with(['programs' => function ($q) {
            $q->where('is_active', true)->orderBy('nama');
        }])->where('is_active', true)->orderBy('urutan')->orderBy('nama')->get();

        $programs = Program::with('divisi')->where('is_active', true)->orderBy('divisi_id', 'asc')->orderBy('nama', 'asc')->get();
        return view('backoffice.admission.edit', compact('admission', 'programs', 'divisiList'));
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
            'nominal_pembayaran' => 'nullable|string',
            'metode_pembayaran' => 'nullable|string|max:100',
            'deskripsi_pembayaran' => 'nullable|string',
        ]);

        if ($request->hasFile('bukti_bayar_pendaftaran')) {
            $data['bukti_bayar_pendaftaran'] = $request->file('bukti_bayar_pendaftaran')->store('admission/bukti', 'public');
        }

        if ($request->hasFile('bukti_bayar_program')) {
            $data['bukti_bayar_program'] = $request->file('bukti_bayar_program')->store('admission/bukti', 'public');
        }

        if ($request->filled('nominal_pembayaran')) {
            $nomStr = preg_replace('/[^0-9]/', '', (string)$request->nominal_pembayaran);
            $data['nominal_pembayaran'] = $nomStr ? (float)$nomStr : 250000.00;
        }

        if (isset($data['metode_pembayaran'])) {
            $data['status_pembayaran'] = str_contains($data['metode_pembayaran'], 'DP') ? 'dp' : 'lunas';
        }

        $admission->update($data);
        $admission->programs()->sync($data['program_ids'] ?? []);

        // Sync dengan cashflow jika sudah terhubung
        if ($admission->cashflow_id) {
            $cf = Cashflow::find($admission->cashflow_id);
            if ($cf) {
                $cf->update([
                    'nama_pihak' => $admission->nama_lengkap,
                    'nominal' => $admission->nominal_pembayaran,
                    'metode_pembayaran' => $admission->metode_pembayaran ?: $cf->metode_pembayaran,
                ]);
            }
        }

        return redirect()->route('backoffice.admission.index')->with('success', 'Data pendaftaran diperbarui.');
    }

    public function approve(Request $request, Admission $admission)
    {
        $request->validate([
            'catatan_admin'      => 'nullable|string',
            'nominal_pembayaran' => 'nullable|string',
            'metode_pembayaran'  => 'nullable|string|max:100',
            'sync_cashflow'      => 'nullable',
        ]);

        $nominalStr = preg_replace('/[^0-9,\.]/', '', (string) ($request->nominal_pembayaran ?? $admission->nominal_pembayaran ?? '250000'));
        if (strpos($nominalStr, '.') !== false && strpos($nominalStr, ',') !== false) {
            $nominalStr = str_replace('.', '', $nominalStr);
            $nominalStr = str_replace(',', '.', $nominalStr);
        } elseif (strpos($nominalStr, '.') !== false) {
            $nominalStr = str_replace('.', '', $nominalStr);
        } elseif (strpos($nominalStr, ',') !== false) {
            $nominalStr = str_replace(',', '.', $nominalStr);
        }
        $nominal = is_numeric($nominalStr) ? (float) $nominalStr : 250000.00;
        if ($nominal <= 0) {
            $nominal = 250000.00;
        }

        $metode = $request->metode_pembayaran ?: ($admission->metode_pembayaran ?: 'Transfer Bank');
        $statusPembayaran = str_contains($metode, 'DP') ? 'dp' : 'lunas';
        $catatan = $request->catatan_admin ?? $admission->catatan_admin;

        // Buat otomatis transaksi Kas Masuk jika belum terhubung
        $cashflowId = $admission->cashflow_id;
        $syncCashflow = $request->has('sync_cashflow') ? (bool) $request->sync_cashflow : true;

        if (!$cashflowId && $syncCashflow) {
            $programNames = $admission->programs->pluck('nama')->implode(', ');
            $kode = Cashflow::generateKode('masuk', 'KM-ADM');
            
            $lampiran = $admission->bukti_bayar_pendaftaran ?? $admission->bukti_bayar_program;
            if ($lampiran && !str_starts_with($lampiran, 'storage/')) {
                // jika path storage biasa, sesuaikan dengan asset path
                $lampiran = 'storage/' . $lampiran;
            }

            $firstProgram = $admission->programs->first();
            $projectId = null;
            if ($firstProgram) {
                $project = Project::where('program_id', $firstProgram->id)->first();
                if (!$project) {
                    $project = Project::create([
                        'kode'          => Project::generateKode(),
                        'nama_proyek'   => 'Kelas ' . $firstProgram->nama,
                        'nama_peserta'  => $admission->nama_lengkap,
                        'pic'           => 'Tim Pengajar DI',
                        'program_id'    => $firstProgram->id,
                        'divisi_id'     => $firstProgram->divisi_id,
                        'tanggal_mulai' => now(),
                        'nilai_proyek'  => $nominal,
                        'status'        => 'aktif',
                        'created_by'    => auth()->id(),
                    ]);
                }
                $projectId = $project->id;
            }

            $cashflow = Cashflow::create([
                'kode'              => $kode,
                'judul'             => 'Pendaftaran Peserta: ' . $admission->nama_lengkap . ($statusPembayaran === 'dp' ? ' (DP / Uang Muka)' : ''),
                'tipe'              => 'masuk',
                'kode_kategori'     => 'KM-ADM',
                'kategori'          => 'Pendaftaran Siswa / Mahasiswa Baru (Admission)',
                'program_id'        => $firstProgram?->id,
                'project_id'        => $projectId,
                'status'            => $statusPembayaran,
                'nominal'           => $nominal,
                'tanggal'           => now()->toDateString(),
                'nama_pihak'        => $admission->nama_lengkap,
                'metode_pembayaran' => $metode,
                'deskripsi'         => 'Pembayaran ' . ($statusPembayaran === 'dp' ? 'DP / uang muka ' : '') . 'pendaftaran peserta program ' . ($programNames ? '[' . $programNames . ']' : 'Denpasar Institute') . ' atas nama ' . $admission->nama_lengkap . ' (HP: ' . $admission->hp_wa . ')',
                'lampiran'          => $lampiran,
                'created_by'        => auth()->id(),
            ]);

            $cashflowId = $cashflow->id;
        } elseif ($cashflowId) {
            // Perbarui nominal di catatan kas jika sudah ada
            $cf = Cashflow::find($cashflowId);
            if ($cf) {
                $cf->update([
                    'nominal'           => $nominal,
                    'status'            => $statusPembayaran,
                    'metode_pembayaran' => $metode,
                    'nama_pihak'        => $admission->nama_lengkap,
                ]);
            }
        }

        $admission->update([
            'status'             => 'approved',
            'status_pembayaran'  => $statusPembayaran,
            'catatan_admin'      => $catatan,
            'nominal_pembayaran' => $nominal,
            'metode_pembayaran'  => $metode,
            'cashflow_id'        => $cashflowId,
            'approved_at'        => now(),
        ]);

        $this->sendApprovalEmail($admission);

        return back()->with('success', "Pendaftaran {$admission->nama_lengkap} berhasil disetujui! Pembayaran Rp " . number_format($nominal, 0, ',', '.') . " telah otomatis dicatat ke Buku Kas & Kuitansi/Invoice resmi telah diterbitkan.");
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
        if ($admission->cashflow_id) {
            $cf = Cashflow::find($admission->cashflow_id);
            if ($cf) {
                $cf->delete();
            }
        }
        $admission->delete();
        return back()->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    protected function sendApprovalEmail(Admission $admission)
    {
        if (empty($admission->email)) {
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::to($admission->email)
                ->send(new \App\Mail\AdmissionApprovedMail($admission));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email approval admission ID ' . $admission->id . ': ' . $e->getMessage());
        }
    }
}