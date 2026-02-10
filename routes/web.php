<?php

use App\Http\Controllers\GuruController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiAdminController;
use App\Http\Controllers\HolidayController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'create'])->name('absensi.create');

    Route::post('/absensi/izin-sakit', [AbsensiController::class, 'store'])->name('absensi.store');

    Route::post('/absensi/datang', [AbsensiController::class, 'absenDatang'])->name('absensi.datang');

    Route::post('/absensi/pulang', [AbsensiController::class, 'absenPulang'])->name('absensi.pulang');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Statistik Absensi
    Route::get('/statistik', [App\Http\Controllers\StatistikController::class, 'index'])
        ->name('statistik.index');
    
    Route::get('/statistik/grafik', [App\Http\Controllers\StatistikController::class, 'grafik'])
        ->name('statistik.grafik');

    Route::get('/statistik/cetak', [App\Http\Controllers\StatistikController::class, 'cetak'])
        ->name('statistik.cetak');
    
    Route::get('/holidays', [App\Http\Controllers\HolidayController::class, 'index'])->name('holidays.index');
    Route::post('/holidays', [App\Http\Controllers\HolidayController::class, 'store'])->name('holidays.store');
    Route::delete('/holidays/{holiday}', [App\Http\Controllers\HolidayController::class, 'destroy'])->name('holidays.destroy');
});





// ================= DASHBOARD =================
Route::get('/dashboard', function () {
    $todayHoliday = \App\Models\Holiday::whereDate('date', now())->first();
    $pendingApprovals = 0;
    
    if (auth()->user()->role === 'admin') {
        $pendingApprovals = \App\Models\Absensi::where('pending', true)
            ->whereIn('status', ['izin', 'sakit'])
            ->count();
    }

    return view('dashboard', compact('todayHoliday', 'pendingApprovals'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/absensi/otp', [AbsensiController::class, 'showOtp'])->middleware('auth')->name('absensi.formOtp');

// ================= AUTH =================
Route::middleware('auth')->group(function () {

    Route::get('/tes-absen-pulang', [AbsensiController::class, 'autoTidakAbsenPulang']);


    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================= GURU =================
    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/absensi', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::get('/guru/absensi/riwayat', [AbsensiController::class, 'riwayat'])->name('absensi.riwayat');
        Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::post('/absensi/kirim-otp', [AbsensiController::class, 'kirimOtp'])->name('absensi.kirimOtp');
        Route::post('/absensi/verifikasi-otp', [AbsensiController::class, 'verifikasiOtp'])->name('absensi.verifikasiOtp');
        
        // NOTIFIKASI/INFORMASI
        Route::get('/guru/informasi', [App\Http\Controllers\NotificationController::class, 'index'])->name('guru.notifications.index');
        Route::post('/guru/informasi/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('guru.notifications.read');
        Route::post('/guru/informasi/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('guru.notifications.readAll');
        Route::delete('/guru/informasi/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('guru.notifications.destroy');
        Route::get('/guru/informasi/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount'])->name('guru.notifications.unreadCount');
    });

    // ================= ADMIN =================
 Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

        // KELOLA GURU
        Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/guru', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/guru/{id}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('/guru/{id}', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('guru.destroy');

          // KELOLA ABSENSI GURU
    Route::get('/absensi', [AbsensiAdminController::class, 'index'])
        ->name('absensi.index');

    Route::get('/absensi/{id}', [AbsensiAdminController::class, 'show'])
        ->name('absensi.show');

    Route::get('/absensi/{id}/edit', [AbsensiAdminController::class, 'edit'])
        ->name('absensi.edit');

    Route::put('/absensi/{id}', [AbsensiAdminController::class, 'update'])
        ->name('absensi.update');

    Route::post('/absensi/{id}/approve', [AbsensiAdminController::class, 'approve'])
        ->name('absensi.approve');

    Route::post('/absensi/{id}/reject', [AbsensiAdminController::class, 'reject'])
        ->name('absensi.reject');
    
    // BROADCAST/KIRIM INFORMASI KE SEMUA GURU
    Route::get('/broadcast', [App\Http\Controllers\Admin\BroadcastController::class, 'index'])
        ->name('broadcast.index');
    
    Route::get('/broadcast/create', [App\Http\Controllers\Admin\BroadcastController::class, 'create'])
        ->name('broadcast.create');
    
    Route::post('/broadcast', [App\Http\Controllers\Admin\BroadcastController::class, 'store'])
        ->name('broadcast.store');
    
    Route::get('/broadcast/{broadcastId}/edit', [App\Http\Controllers\Admin\BroadcastController::class, 'edit'])
        ->name('broadcast.edit');
    
    Route::put('/broadcast/{broadcastId}', [App\Http\Controllers\Admin\BroadcastController::class, 'update'])
        ->name('broadcast.update');
    
    Route::delete('/broadcast/{broadcastId}', [App\Http\Controllers\Admin\BroadcastController::class, 'destroy'])
        ->name('broadcast.destroy');
});

});

require __DIR__.'/auth.php';
