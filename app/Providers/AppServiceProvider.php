<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Divisi;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share $allDivisi ke layout.app dengan caching 1 jam
        View::composer('layouts.app', function ($view) {
            $allDivisi = Cache::remember('all_divisi_active', 3600, function() {
                return Divisi::where('is_active', true)
                    ->orderBy('urutan', 'asc')
                    ->get();
            });
            
            $view->with('allDivisi', $allDivisi);
        });
    }
}