<?php

namespace App\Http\Controllers;

use App\Models\HeroSlider;
use App\Models\Berita;
use App\Models\Event;
use App\Models\Divisi;
use App\Models\User;
use App\Models\Testimonial;
use App\Models\BursaSdm;
use App\Models\Statistic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::where('is_active', true)
            ->orderBy('order')
            ->get();

        $latestEvents = Event::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        $latestBeritas = Berita::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        $divisis = Divisi::where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->get();

        $konsultans = User::where('role', 'konsultan')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $grcsMembers = User::where('role', 'grcs')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $testimonials = Testimonial::where('is_approved', true)
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        $bursaSdmItems = BursaSdm::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $statistics = Statistic::active()
            ->orderBy('order')
            ->get();

        return view('home', compact(
            'sliders',
            'latestEvents',
            'latestBeritas',
            'divisis',
            'konsultans',
            'grcsMembers',
            'testimonials',
            'bursaSdmItems',
            'statistics'
        ));
    }
}