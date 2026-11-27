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
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliderMode = SiteSetting::get('hero_slider_order_mode', 'random');

        if ($sliderMode === 'ordered') {
            $sliders = HeroSlider::where('is_active', true)
                ->orderBy('order')
                ->get();
        } else {
            // Mode Default: Acak (Random) setiap kali halaman dimuat / reload
            $sliders = HeroSlider::where('is_active', true)
                ->inRandomOrder()
                ->get();
        }

        $latestEvents = Event::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        $latestBeritas = Berita::where('is_active', true)
            ->where('status', 'approved')
            ->orderBy('published_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        // Divisi di-randomkan urutannya setiap kali reload halaman
        $divisis = Divisi::where('is_active', true)
            ->inRandomOrder()
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