<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\HeroSlider;
use App\Models\User;
use App\Models\Statistic;
use App\Models\Berita;
use App\Models\Event;
use App\Models\Admission;
use App\Models\Divisi;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;
        
        $data = [
            'user' => $user,
            'role' => $role,
        ];
        
        if ($role === 'superadmin') {
            $data['totalSliders'] = HeroSlider::where('is_active', true)->count();
            $data['totalUsers'] = User::count();
            $data['totalKonsultan'] = User::where('role', 'konsultan')->count();
            $data['totalGrcs'] = User::where('role', 'grcs')->count();
            $data['totalActive'] = User::where('is_active', true)->count();
            $data['totalInactive'] = User::where('is_active', false)->count();
            $data['totalStatistics'] = Statistic::where('is_active', true)->count();
            $data['totalBerita'] = Berita::count();
            $data['totalBeritaPending'] = Berita::where('status', 'pending')->count();
            $data['totalEvent'] = Event::count();
            $data['totalEventPending'] = Event::where('status', 'pending')->count();
            $data['totalAdmission'] = Admission::count();
            $data['totalAdmissionPending'] = Admission::where('status', 'pending')->count();
            $data['pendingKonsultanCount'] = User::where('role', 'konsultan')
                ->where(function($q) {
                    $q->where('verification_status', 'pending')
                      ->orWhere(function($sub) {
                          $sub->where('is_active', false)->whereNull('verification_status');
                      });
                })->count();
            $data['pendingGrcsCount'] = User::where('role', 'grcs')
                ->where(function($q) {
                    $q->where('verification_status', 'pending')
                      ->orWhere(function($sub) {
                          $sub->where('is_active', false)->whereNull('verification_status');
                      });
                })->count();
            $data['recentPendingKonsultan'] = User::where('role', 'konsultan')
                ->where(function($q) {
                    $q->where('verification_status', 'pending')
                      ->orWhere(function($sub) {
                          $sub->where('is_active', false)->whereNull('verification_status');
                      });
                })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            $data['totalDivisi'] = Divisi::where('is_active', true)->count();
            $data['totalTestimonial'] = Testimonial::where('is_approved', true)->count();
            $data['totalTestimonialPending'] = Testimonial::where('is_approved', false)->count();
            $data['recentUsers'] = User::orderBy('created_at', 'desc')->take(5)->get();
            $data['recentBerita'] = Berita::orderBy('created_at', 'desc')->take(5)->get();
            $data['recentAdmission'] = Admission::orderBy('created_at', 'desc')->take(5)->get();
            $data['showSuperadminStats'] = true;
            $data['showKonsultanStats'] = false;
            $data['showGrcsStats'] = false;
        }
        
        if ($role === 'konsultan') {
            $data['profileCompletion'] = $user->profile_completion ?? 0;
            $data['membershipStatus'] = $user->membership_type ?? 'pending';
            $data['membershipExpiry'] = $user->berlaku_sd ?? null;
            $data['totalBeritaDraft'] = Berita::where('created_by', $user->id)->where('status', 'pending')->count();
            $data['totalBeritaPublished'] = Berita::where('created_by', $user->id)->where('status', 'approved')->count();
            $data['showSuperadminStats'] = false;
            $data['showKonsultanStats'] = true;
            $data['showGrcsStats'] = false;
        }
        
        if ($role === 'grcs') {
            $data['profileCompletion'] = $user->profile_completion ?? 0;
            $data['membershipStatus'] = $user->membership_type ?? 'pending';
            $data['membershipExpiry'] = $user->berlaku_sd ?? null;
            $data['division'] = $user->position ?? 'Belum ditentukan';
            $data['totalAdmission'] = Admission::where('email', $user->email)->count();
            $data['showSuperadminStats'] = false;
            $data['showKonsultanStats'] = false;
            $data['showGrcsStats'] = true;
        }
        
        return view('backoffice.dashboard', $data);
    }
}