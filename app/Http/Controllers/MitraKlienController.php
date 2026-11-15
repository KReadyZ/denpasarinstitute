<?php

namespace App\Http\Controllers;

use App\Models\PartnershipSubmission;
use App\Models\PartnershipPillar;
use Illuminate\Http\Request;

class MitraKlienController extends Controller
{
    /**
     * Tampilkan halaman publik Mitra & Klien
     */
    public function index(Request $request)
    {
        $query = PartnershipSubmission::approved();

        // Filter pencarian
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('institusi', 'like', "%{$keyword}%")
                  ->orWhere('kategori', 'like', "%{$keyword}%")
                  ->orWhere('pillar_title', 'like', "%{$keyword}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            $query->where('kategori', $request->kategori);
        }

        // Urutkan berdasarkan urutan ASC, lalu tanggal verifikasi terbaru
        $partners = $query->orderBy('urutan', 'asc')
                          ->latest('verified_at')
                          ->paginate(20)
                          ->withQueryString();

        // Kumpulan kategori unik dari mitra yang sudah approved
        $categories = PartnershipSubmission::approved()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->pluck('kategori');

        $totalApproved = PartnershipSubmission::approved()->count();
        $pillars = PartnershipPillar::where('is_active', true)->orderBy('order', 'asc')->get();

        return view('mitra-klien', compact('partners', 'categories', 'totalApproved', 'pillars'));
    }
}
