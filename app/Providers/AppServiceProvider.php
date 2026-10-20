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

        // Share pending counts ke backoffice.layouts.app
        View::composer('backoffice.layouts.app', function ($view) {
            try {
                $pendingKonsultanCount = \App\Models\User::where('role', 'konsultan')
                    ->where(function($q) {
                        $q->where('verification_status', 'pending')
                          ->orWhere(function($sub) {
                              $sub->where('is_active', false)->whereNull('verification_status');
                          });
                    })->count();

                $pendingGrcsCount = \App\Models\User::where('role', 'grcs')
                    ->where(function($q) {
                        $q->where('verification_status', 'pending')
                          ->orWhere(function($sub) {
                              $sub->where('is_active', false)->whereNull('verification_status');
                          });
                    })->count();

                $pendingAdmissionCount = \App\Models\Admission::where('status', 'pending')->count();

                $view->with([
                    'pendingKonsultanCount' => $pendingKonsultanCount,
                    'pendingGrcsCount'      => $pendingGrcsCount,
                    'pendingAdmissionCount' => $pendingAdmissionCount,
                ]);
            } catch (\Throwable $e) {
                $view->with([
                    'pendingKonsultanCount' => 0,
                    'pendingGrcsCount'      => 0,
                    'pendingAdmissionCount' => 0,
                ]);
            }
        });
    }
}