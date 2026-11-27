
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KonsultanPublicController;
use App\Http\Controllers\GrcsPublicController;
use App\Http\Controllers\BursaSdmController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\Backoffice\AuthController;
use App\Http\Controllers\Backoffice\DashboardController;
use App\Http\Controllers\Backoffice\HeroSliderController;
use App\Http\Controllers\Backoffice\ProfileController;
use App\Http\Controllers\Backoffice\UserController;
use App\Http\Controllers\Backoffice\KonsultanController;
use App\Http\Controllers\Backoffice\GrcsController;
use App\Http\Controllers\Backoffice\KartuController;
use App\Http\Controllers\Backoffice\KategoriBeritaController;
use App\Http\Controllers\Backoffice\BeritaController as BackofficeBeritaController;
use App\Http\Controllers\Backoffice\DivisiController as BackofficeDivisiController;
use App\Http\Controllers\Backoffice\ProgramController;
use App\Http\Controllers\Backoffice\KategoriEventController;
use App\Http\Controllers\Backoffice\StatisticController;
use App\Http\Controllers\Backoffice\NavigationController;
use App\Http\Controllers\Backoffice\SiteSettingController;
use App\Http\Controllers\Backoffice\PartnershipPillarController;
use App\Http\Controllers\Backoffice\PartnershipSubmissionController;
use App\Http\Controllers\Backoffice\EventController as BackofficeEventController;
use App\Http\Controllers\Backoffice\BursaSdmController as BackofficeBursaSdmController;
use App\Http\Controllers\Backoffice\TestimonialController as BackofficeTestimonialController;
use App\Http\Controllers\Backoffice\AdmissionController as BackofficeAdmissionController;
use App\Http\Controllers\Backoffice\CashflowController;
use App\Http\Controllers\Backoffice\CashflowCategoryController;
use App\Http\Controllers\Backoffice\ProjectController;
use App\Http\Controllers\Backoffice\AdminManagementController;
use App\Http\Controllers\Backoffice\DivisiSectionController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\PartnerDetailController;
use App\Http\Controllers\MitraKlienController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');

Route::prefix('backoffice')->name('backoffice.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('login',     [AuthController::class, 'showLogin'])->name('login');
        Route::post('login',    [AuthController::class, 'login'])->name('login.submit');
        Route::get('register',  [AuthController::class, 'showRegister'])->name('register');
        Route::post('register', [AuthController::class, 'register'])->name('register.submit');
    });

    Route::middleware(['backoffice:superadmin,admin,finance'])->group(function () {
        Route::get('/', function () {
            if (auth()->check() && auth()->user()->role === 'finance') {
                return redirect()->route('backoffice.cashflow.index');
            }
            if (auth()->check() && auth()->user()->role === 'admin') {
                return redirect()->route('backoffice.admission.index');
            }
            return redirect()->route('backoffice.dashboard');
        });
        Route::post('logout',   [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('profile',      [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile',      [ProfileController::class, 'update'])->name('profile.update');
    });

    Route::middleware(['backoffice:superadmin,admin'])->group(function () {
        Route::get('partnership', function () {
            return redirect()->route('backoffice.partnership-pillar.index');
        });

        Route::get('profile/{id}', [ProfileController::class, 'show'])->name('profile.show');

        Route::post('profile/{id}/ecard/generate', [ProfileController::class, 'generateEcard'])->name('profile.ecard.generate');
        Route::post('profile/{id}/ecard/renew',    [ProfileController::class, 'renewEcard'])->name('profile.ecard.renew');

        Route::get('kartu/{id}/depan',    [KartuController::class, 'depan'])->name('kartu.depan');
        Route::get('kartu/{id}/belakang', [KartuController::class, 'belakang'])->name('kartu.belakang');

        Route::prefix('konsultan')->name('konsultan.')->group(function () {
            Route::get('/',                          [KonsultanController::class, 'index'])->name('index');
            Route::get('/verifikasi',                [KonsultanController::class, 'verifikasiIndex'])->name('verifikasi');
            Route::get('/verifikasi/{id}',           [KonsultanController::class, 'verifikasiShow'])->name('verifikasi.show');
            Route::patch('/verifikasi/{id}/approve', [KonsultanController::class, 'approve'])->name('approve');
            Route::post('/verifikasi/{id}/reject',   [KonsultanController::class, 'reject'])->name('reject');
            Route::get('/create',                    [KonsultanController::class, 'create'])->name('create');
            Route::post('/',                         [KonsultanController::class, 'store'])->name('store');
            Route::get('/{id}/edit',                 [KonsultanController::class, 'edit'])->name('edit');
            Route::put('/{id}',                      [KonsultanController::class, 'update'])->name('update');
            Route::delete('/{id}',                   [KonsultanController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle-active',      [KonsultanController::class, 'toggleActive'])->name('toggle-active');
            Route::get('/{id}',                      [KonsultanController::class, 'show'])->name('show');
        });

        Route::prefix('grcs')->name('grcs.')->group(function () {
            Route::get('/',                          [GrcsController::class, 'index'])->name('index');
            Route::get('/verifikasi',                [GrcsController::class, 'verifikasiIndex'])->name('verifikasi');
            Route::get('/verifikasi/{id}',           [GrcsController::class, 'verifikasiShow'])->name('verifikasi.show');
            Route::patch('/verifikasi/{id}/approve', [GrcsController::class, 'approve'])->name('approve');
            Route::post('/verifikasi/{id}/reject',   [GrcsController::class, 'reject'])->name('reject');
            Route::get('/create',                    [GrcsController::class, 'create'])->name('create');
            Route::post('/',                         [GrcsController::class, 'store'])->name('store');
            Route::get('/{id}/edit',                 [GrcsController::class, 'edit'])->name('edit');
            Route::put('/{id}',                      [GrcsController::class, 'update'])->name('update');
            Route::delete('/{id}',                   [GrcsController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle-active',      [GrcsController::class, 'toggleActive'])->name('toggle-active');
            Route::get('/{id}',                      [GrcsController::class, 'show'])->name('show');
        });

        Route::prefix('berita')->name('berita.')->group(function () {
            Route::get('/',                     [BackofficeBeritaController::class, 'index'])->name('index');
            Route::get('/create',               [BackofficeBeritaController::class, 'create'])->name('create');
            Route::post('/',                    [BackofficeBeritaController::class, 'store'])->name('store');
            Route::get('/verifikasi/list',      [BackofficeBeritaController::class, 'verifikasiIndex'])->name('verifikasi');
            Route::patch('/{id}/approve',       [BackofficeBeritaController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject',         [BackofficeBeritaController::class, 'reject'])->name('reject');
            Route::get('/{id}/edit',            [BackofficeBeritaController::class, 'edit'])->name('edit');
            Route::put('/{id}',                 [BackofficeBeritaController::class, 'update'])->name('update');
            Route::delete('/{id}',              [BackofficeBeritaController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle-active', [BackofficeBeritaController::class, 'toggleActive'])->name('toggle-active');
        });

        Route::prefix('kategori-berita')->name('kategori-berita.')->group(function () {
            Route::get('/',        [KategoriBeritaController::class, 'index'])->name('index');
            Route::post('/',       [KategoriBeritaController::class, 'store'])->name('store');
            Route::put('/{id}',    [KategoriBeritaController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriBeritaController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('event')->name('event.')->group(function () {
            Route::get('/',                     [BackofficeEventController::class, 'index'])->name('index');
            Route::get('/create',               [BackofficeEventController::class, 'create'])->name('create');
            Route::post('/',                    [BackofficeEventController::class, 'store'])->name('store');
            Route::get('/verifikasi/list',      [BackofficeEventController::class, 'verifikasiIndex'])->name('verifikasi');
            Route::patch('/{id}/approve',       [BackofficeEventController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject',         [BackofficeEventController::class, 'reject'])->name('reject');
            Route::get('/{id}/edit',            [BackofficeEventController::class, 'edit'])->name('edit');
            Route::put('/{id}',                 [BackofficeEventController::class, 'update'])->name('update');
            Route::delete('/{id}',              [BackofficeEventController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/toggle-active', [BackofficeEventController::class, 'toggleActive'])->name('toggle-active');
        });

        Route::prefix('kategori-event')->name('kategori-event.')->group(function () {
            Route::get('/',        [KategoriEventController::class, 'index'])->name('index');
            Route::post('/',       [KategoriEventController::class, 'store'])->name('store');
            Route::put('/{id}',    [KategoriEventController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriEventController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('bursa-sdm')->name('bursa-sdm.')->group(function () {
            Route::get('/',                     [BackofficeBursaSdmController::class, 'index'])->name('index');
            Route::get('/create',               [BackofficeBursaSdmController::class, 'create'])->name('create');
            Route::post('/',                    [BackofficeBursaSdmController::class, 'store'])->name('store');
            Route::get('/{id}/edit',            [BackofficeBursaSdmController::class, 'edit'])->name('edit');
            Route::put('/{id}',                 [BackofficeBursaSdmController::class, 'update'])->name('update');
            Route::patch('/{id}/approve',       [BackofficeBursaSdmController::class, 'approve'])->name('approve');
            Route::patch('/{id}/reject',        [BackofficeBursaSdmController::class, 'reject'])->name('reject');
            Route::patch('/{id}/toggle-active', [BackofficeBursaSdmController::class, 'toggleActive'])->name('toggle-active');
            Route::delete('/{id}',              [BackofficeBursaSdmController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('testimonial')->name('testimonial.')->group(function () {
            Route::get('/',               [BackofficeTestimonialController::class, 'index'])->name('index');
            Route::get('/create',         [BackofficeTestimonialController::class, 'create'])->name('create');
            Route::post('/',              [BackofficeTestimonialController::class, 'store'])->name('store');
            Route::get('/{id}/edit',      [BackofficeTestimonialController::class, 'edit'])->name('edit');
            Route::put('/{id}',           [BackofficeTestimonialController::class, 'update'])->name('update');
            Route::delete('/{id}',        [BackofficeTestimonialController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/approve', [BackofficeTestimonialController::class, 'toggleApprove'])->name('approve');
        });

        Route::prefix('admission')->name('admission.')->group(function () {
            Route::get('/',                      [BackofficeAdmissionController::class, 'index'])->name('index');
            Route::get('/create',                [BackofficeAdmissionController::class, 'create'])->name('create');
            Route::post('/',                     [BackofficeAdmissionController::class, 'store'])->name('store');
            Route::get('/{admission}/edit',      [BackofficeAdmissionController::class, 'edit'])->name('edit');
            Route::put('/{admission}',           [BackofficeAdmissionController::class, 'update'])->name('update');
            Route::patch('/{admission}/approve', [BackofficeAdmissionController::class, 'approve'])->name('approve');
            Route::patch('/{admission}/reject',  [BackofficeAdmissionController::class, 'reject'])->name('reject');
            Route::delete('/{admission}',        [BackofficeAdmissionController::class, 'destroy'])->name('destroy');
        });

        Route::middleware(['backoffice:superadmin,admin'])->group(function () {

            Route::post('users/{id}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
            Route::post('slider/order', [HeroSliderController::class, 'updateOrder'])->name('slider.order');

            Route::resource('users', UserController::class)->except(['show'])->names([
                'index'   => 'users.index',
                'create'  => 'users.create',
                'store'   => 'users.store',
                'edit'    => 'users.edit',
                'update'  => 'users.update',
                'destroy' => 'users.destroy',
            ]);

            Route::get('slider',               [HeroSliderController::class, 'index'])->name('slider.index');
            Route::post('slider/mode',          [HeroSliderController::class, 'updateMode'])->name('slider.mode');
            Route::get('slider/create',        [HeroSliderController::class, 'create'])->name('slider.create');
            Route::post('slider',              [HeroSliderController::class, 'store'])->name('slider.store');
            Route::get('slider/{slider}/edit', [HeroSliderController::class, 'edit'])->name('slider.edit');
            Route::put('slider/{slider}',      [HeroSliderController::class, 'update'])->name('slider.update');
            Route::delete('slider/{slider}',   [HeroSliderController::class, 'destroy'])->name('slider.destroy');

            Route::resource('divisi', BackofficeDivisiController::class)->except(['show'])->names([
                'index'   => 'divisi.index',
                'create'  => 'divisi.create',
                'store'   => 'divisi.store',
                'edit'    => 'divisi.edit',
                'update'  => 'divisi.update',
                'destroy' => 'divisi.destroy',
            ]);

            Route::prefix('divisi/{divisi}/program')->name('program.')->group(function () {
                Route::get('/',               [ProgramController::class, 'index'])->name('index');
                Route::get('/create',         [ProgramController::class, 'create'])->name('create');
                Route::post('/',              [ProgramController::class, 'store'])->name('store');
                Route::get('/{program}/edit', [ProgramController::class, 'edit'])->name('edit');
                Route::put('/{program}',      [ProgramController::class, 'update'])->name('update');
                Route::patch('/{program}/toggle', [ProgramController::class, 'toggleStatus'])->name('toggle');
                Route::delete('/{program}',   [ProgramController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('divisi/{divisi}/sections')->name('sections.')->group(function () {
                Route::get('/',               [DivisiSectionController::class, 'index'])->name('index');
                Route::get('/create',         [DivisiSectionController::class, 'create'])->name('create');
                Route::post('/',              [DivisiSectionController::class, 'store'])->name('store');
                Route::get('/{section}/edit', [DivisiSectionController::class, 'edit'])->name('edit');
                Route::put('/{section}',      [DivisiSectionController::class, 'update'])->name('update');
                Route::delete('/{section}',   [DivisiSectionController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('statistic')->name('statistic.')->group(function () {
                Route::get('/',                     [StatisticController::class, 'index'])->name('index');
                Route::get('/create',               [StatisticController::class, 'create'])->name('create');
                Route::post('/',                    [StatisticController::class, 'store'])->name('store');
                Route::get('/{id}/edit',            [StatisticController::class, 'edit'])->name('edit');
                Route::put('/{id}',                 [StatisticController::class, 'update'])->name('update');
                Route::delete('/{id}',              [StatisticController::class, 'destroy'])->name('destroy');
                Route::patch('/{id}/toggle-active', [StatisticController::class, 'toggleActive'])->name('toggle-active');
            });

            // Pengaturan Navigasi & Menu
            Route::prefix('navigation')->name('navigation.')->group(function () {
                Route::get('/',                     [NavigationController::class, 'index'])->name('index');
                Route::get('/create',               [NavigationController::class, 'create'])->name('create');
                Route::post('/',                    [NavigationController::class, 'store'])->name('store');
                Route::get('/{id}/edit',            [NavigationController::class, 'edit'])->name('edit');
                Route::put('/{id}',                 [NavigationController::class, 'update'])->name('update');
                Route::delete('/{id}',              [NavigationController::class, 'destroy'])->name('destroy');
                Route::patch('/{id}/toggle-active', [NavigationController::class, 'toggleActive'])->name('toggle-active');
            });

            // Pengaturan Website, Konten & Footer
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('/', [SiteSettingController::class, 'index'])->name('index');
                Route::put('/', [SiteSettingController::class, 'update'])->name('update');
            });

            // Pilar Kemitraan (Partnership Pillars)
            Route::prefix('partnership-pillar')->name('partnership-pillar.')->group(function () {
                Route::get('/',                     [PartnershipPillarController::class, 'index'])->name('index');
                Route::get('/create',               [PartnershipPillarController::class, 'create'])->name('create');
                Route::post('/',                    [PartnershipPillarController::class, 'store'])->name('store');
                Route::get('/{id}/edit',            [PartnershipPillarController::class, 'edit'])->name('edit');
                Route::put('/{id}',                 [PartnershipPillarController::class, 'update'])->name('update');
                Route::delete('/{id}',              [PartnershipPillarController::class, 'destroy'])->name('destroy');
                Route::patch('/{id}/toggle-active', [PartnershipPillarController::class, 'toggleActive'])->name('toggle-active');
            });

            // Pendaftar & Verifikasi Mitra & Klien (Partnership Submissions)
            Route::prefix('partnership-submission')->name('partnership-submission.')->group(function () {
                Route::get('/',              [PartnershipSubmissionController::class, 'index'])->name('index');
                Route::get('/create',        [PartnershipSubmissionController::class, 'create'])->name('create');
                Route::post('/',             [PartnershipSubmissionController::class, 'store'])->name('store');
                Route::get('/{id}/edit',     [PartnershipSubmissionController::class, 'edit'])->name('edit');
                Route::put('/{id}',          [PartnershipSubmissionController::class, 'update'])->name('update');
                Route::patch('/{id}/status', [PartnershipSubmissionController::class, 'updateStatus'])->name('update-status');
                Route::delete('/{id}',       [PartnershipSubmissionController::class, 'destroy'])->name('destroy');
            });

        });
    });

    // Khusus Super Admin: Kelola Akun Admin & Finance
    Route::middleware(['backoffice:superadmin'])->group(function () {
        Route::prefix('admin-management')->name('admin-management.')->group(function () {
            Route::get('/',                                     [AdminManagementController::class, 'index'])->name('index');
            Route::post('/',                                    [AdminManagementController::class, 'store'])->name('store');
            Route::match(['put', 'post'], '/{id}',              [AdminManagementController::class, 'update'])->name('update');
            Route::match(['put', 'post'], '/{id}/password',     [AdminManagementController::class, 'updatePassword'])->name('update-password');
            Route::match(['patch', 'post'], '/{id}/toggle-active', [AdminManagementController::class, 'toggleActive'])->name('toggle-active');
            Route::match(['delete', 'post'], '/{id}',           [AdminManagementController::class, 'destroy'])->name('destroy');

            // Pengelolaan Role Dinamis (Database)
            Route::post('roles',                [AdminManagementController::class, 'storeRole'])->name('roles.store');
            Route::put('roles/{id}',            [AdminManagementController::class, 'updateRole'])->name('roles.update');
            Route::delete('roles/{id}',         [AdminManagementController::class, 'destroyRole'])->name('roles.destroy');
        });
    });

    Route::middleware(['backoffice:superadmin,finance'])->group(function () {
            // Buku Kas Keuangan (Pemasukan & Pengeluaran)
            Route::prefix('cashflow')->name('cashflow.')->group(function () {
                // Kategori Kas Dinamis
                Route::prefix('kategori')->name('kategori.')->group(function () {
                    Route::get('/',             [CashflowCategoryController::class, 'index'])->name('index');
                    Route::get('/create',       [CashflowCategoryController::class, 'create'])->name('create');
                    Route::post('/',            [CashflowCategoryController::class, 'store'])->name('store');
                    Route::get('/{id}/edit',    [CashflowCategoryController::class, 'edit'])->name('edit');
                    Route::put('/{id}',         [CashflowCategoryController::class, 'update'])->name('update');
                    Route::patch('/{id}/toggle',[CashflowCategoryController::class, 'toggle'])->name('toggle');
                    Route::delete('/{id}',      [CashflowCategoryController::class, 'destroy'])->name('destroy');
                });

                Route::get('/',                 [CashflowController::class, 'index'])->name('index');
                Route::get('/export/csv',       [CashflowController::class, 'exportCsv'])->name('export.csv');
                Route::get('/create',           [CashflowController::class, 'create'])->name('create');
                Route::post('/',                [CashflowController::class, 'store'])->name('store');
                Route::get('/cetak/laporan',    [CashflowController::class, 'cetak'])->name('cetak');
                Route::get('/{id}/invoice',     [CashflowController::class, 'invoice'])->name('invoice');
                Route::get('/api/generate-kode',[CashflowController::class, 'generateKodeApi'])->name('api.generate-kode');
                Route::get('/{id}/edit',        [CashflowController::class, 'edit'])->name('edit');
                Route::put('/{id}',             [CashflowController::class, 'update'])->name('update');
                Route::post('/{id}/pelunasan',  [CashflowController::class, 'pelunasan'])->name('pelunasan');
                Route::delete('/{id}',          [CashflowController::class, 'destroy'])->name('destroy');
            });

            // Manajemen Proyek & Program Khusus (Peserta & Kelas DI)
            Route::prefix('project')->name('project.')->group(function () {
                Route::get('/',                     [ProjectController::class, 'index'])->name('index');
                Route::get('/create',               [ProjectController::class, 'create'])->name('create');
                Route::post('/',                    [ProjectController::class, 'store'])->name('store');
                Route::get('/tambah-program',       [ProjectController::class, 'createProgram'])->name('program.create');
                Route::post('/tambah-program',      [ProjectController::class, 'storeProgram'])->name('program.store');
                Route::get('/kategori/{id}',        [ProjectController::class, 'kategori'])->name('kategori');
                Route::get('/kategori/{id}/export-csv', [ProjectController::class, 'exportKategoriCsv'])->name('kategori.export-csv');
                Route::get('/{id}',                 [ProjectController::class, 'show'])->name('show');
                Route::get('/{id}/edit',            [ProjectController::class, 'edit'])->name('edit');
                Route::put('/{id}',                 [ProjectController::class, 'update'])->name('update');
                Route::delete('/{id}',              [ProjectController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/transaksi',      [ProjectController::class, 'storeTransaction'])->name('transaksi.store');
                Route::post('/{id}/update-nilai',   [ProjectController::class, 'updateNilai'])->name('update-nilai');
                Route::get('/{id}/cetak',           [ProjectController::class, 'cetak'])->name('cetak');
            });
    });
});

Route::get('/api/divisi/{slug}/programs', [ProgramController::class, 'publicByDivisiSlug'])
    ->name('api.divisi.programs');

Route::get('/api/berita/latest', [BeritaController::class, 'latestBerita'])
    ->name('api.berita.latest');

Route::get('/api/berita/featured', [BeritaController::class, 'featuredBerita'])
    ->name('api.berita.featured');

Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/',       [BeritaController::class, 'index'])->name('index');
    Route::get('/create', [BeritaController::class, 'create'])->name('create');
    Route::post('/',      [BeritaController::class, 'store'])->name('store');
    Route::get('/{id}',   [BeritaController::class, 'show'])->name('show');
});

Route::prefix('event')->name('event.')->group(function () {
    Route::get('/',              [EventController::class, 'index'])->name('index');
    Route::post('/',             [EventController::class, 'store'])->name('store');
    Route::get('/{id}',          [EventController::class, 'show'])->name('show');
    Route::get('/api/latest',    [EventController::class, 'latestEvent']);
    Route::get('/api/featured',  [EventController::class, 'featuredEvent']);
});

Route::prefix('divisi')->name('divisi.')->group(function () {
    Route::get('/{slug}', [DivisiController::class, 'show'])->name('show');
});

Route::prefix('konsultan')->name('konsultan.')->group(function () {
    Route::get('/',     [KonsultanPublicController::class, 'index'])->name('index');
    Route::get('/{id}', [KonsultanPublicController::class, 'show'])->name('show');
});

Route::prefix('grcs-club')->name('grcs.')->group(function () {
    Route::get('/',     [GrcsPublicController::class, 'index'])->name('index');
    Route::get('/{id}', [GrcsPublicController::class, 'show'])->name('show');
});

Route::get('/grcs', function () {
    return redirect()->route('grcs.index');
});

Route::prefix('bursa-sdm')->name('bursa-sdm.')->group(function () {
    Route::get('/',              [BursaSdmController::class, 'index'])->name('index');
    Route::get('/tambah/{tipe}', [BursaSdmController::class, 'create'])->name('create');
    Route::post('/',             [BursaSdmController::class, 'store'])->name('store');
    Route::get('/{slug}',        [BursaSdmController::class, 'show'])->name('show');
});

Route::prefix('admission')->name('admission.')->group(function () {
    Route::get('/',  [AdmissionController::class, 'create'])->name('create');
    Route::post('/', [AdmissionController::class, 'store'])->name('store');
});

Route::view('/panduan-pendaftaran', 'panduan-pendaftaran')->name('panduan-pendaftaran');
Route::view('/cara-daftar', 'panduan-pendaftaran')->name('cara-daftar');

Route::get('/pendaftaran/konsultan', function () {
    $beritaTerkini = \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('published_at', 'desc')
        ->take(5)
        ->get();
    $beritaTerpopuler = \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('views', 'desc')
        ->take(5)
        ->get();

    return view('pendaftaran', [
        'role' => 'konsultan',
        'beritaTerkini' => $beritaTerkini,
        'beritaTerpopuler' => $beritaTerpopuler,
    ]);
})->name('pendaftaran.konsultan');

Route::get('/pendaftaran/grcs', function () {
    $beritaTerkini = \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('published_at', 'desc')
        ->take(5)
        ->get();
    $beritaTerpopuler = \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('views', 'desc')
        ->take(5)
        ->get();

    return view('pendaftaran', [
        'role' => 'grcs',
        'beritaTerkini' => $beritaTerkini,
        'beritaTerpopuler' => $beritaTerpopuler,
    ]);
})->name('pendaftaran.grcs');

Route::get('/pendaftaran', function (\Illuminate\Http\Request $request) {
    $role = $request->get('role', 'konsultan');
    $beritaTerkini = \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('published_at', 'desc')
        ->take(5)
        ->get();
    $beritaTerpopuler = \App\Models\Berita::where('is_active', true)
        ->where('status', 'approved')
        ->orderBy('views', 'desc')
        ->take(5)
        ->get();

    return view('pendaftaran', [
        'role' => $role,
        'beritaTerkini' => $beritaTerkini,
        'beritaTerpopuler' => $beritaTerpopuler,
    ]);
})->name('pendaftaran');

Route::get('/partner-with-di', function () {
    return view('partner');
})->name('partners-and-community');

// Submit Form Kemitraan (Pop-up Modal)
Route::post('/partner-with-di/form-kemitraan', [PartnerDetailController::class, 'submitForm'])->name('partner.submit-form');

// Detail 6 Pilar Kemitraan (Dynamic)
Route::get('/partner-with-di/{slug}', [PartnerDetailController::class, 'show'])->name('partner.detail');

Route::get('/partner-with-di/research-and-innovation', function () {
    return redirect()->route('partner.detail', 'research-and-innovation');
})->name('partner.research-innovation');

Route::get('/partners-and-collaboration', function () {
    return view('partner');
})->name('partners-and-collaboration');

// Halaman Publik Mitra & Klien (Baru)
Route::get('/mitra-dan-klien', [MitraKlienController::class, 'index'])->name('mitra-dan-klien');
Route::get('/mitra-klien', fn() => redirect()->route('mitra-dan-klien'));
Route::get('/partner', fn() => redirect()->route('mitra-dan-klien'));
Route::get('/partners', fn() => redirect()->route('mitra-dan-klien'));
Route::get('/partners-and-clients', fn() => redirect()->route('mitra-dan-klien'));

// Fallback Route untuk Akses Media Storage (Memastikan file upload seperti foto berita selalu tampil di cPanel/Hostinger)
Route::get('/storage/{path}', function ($path) {
    $storageAppPath = storage_path('app/public/' . $path);
    if (file_exists($storageAppPath)) {
        return response()->file($storageAppPath);
    }
    $pubStoragePath = public_path('storage/' . $path);
    if (file_exists($pubStoragePath)) {
        return response()->file($pubStoragePath);
    }
    abort(404);
})->where('path', '.*')->name('storage.fallback');
