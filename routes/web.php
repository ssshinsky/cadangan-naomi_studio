<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudioController;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC ROUTES ────────────────────────────────────────────────────────────

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/alur', fn() => view('alur'))->name('alur');
Route::get('/studios', [StudioController::class, 'index'])->name('studios.index');
Route::get('/studios/{slug}', [StudioController::class, 'show'])->name('studios.show');
Route::get('/open-class', [App\Http\Controllers\OpenClassController::class, 'index'])->name('open-class.index');
Route::get('/open-class/{slug}', [App\Http\Controllers\OpenClassController::class, 'show'])->name('open-class.show');

// ─── CUSTOMER ROUTES (auth) ───────────────────────────────────────────────────

Route::middleware(['auth', 'role:customer'])->group(function () {

    // Profil
    Route::get('/profil', [App\Http\Controllers\CustomerProfileController::class, 'index'])->name('profil');
    Route::get('/profil/edit', [App\Http\Controllers\CustomerProfileController::class, 'edit'])->name('profil.edit');
    Route::patch('/profil', [App\Http\Controllers\CustomerProfileController::class, 'update'])->name('profil.update');
    Route::get('/profil/riwayat-booking', [App\Http\Controllers\CustomerProfileController::class, 'riwayatBooking'])->name('profil.riwayat-booking');
    Route::get('/profil/riwayat-kelas', fn() => view('profile.riwayatkelas'))->name('profil.riwayat-kelas');
    Route::get('/profil/riwayat-booking/{id}', [App\Http\Controllers\CustomerProfileController::class, 'bookingDetail'])->name('profil.booking-detail');
    Route::get('/profil/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'download'])->name('profil.invoice');
    Route::post('/profil/booking/{id}/cancel', [App\Http\Controllers\CustomerProfileController::class, 'cancelBooking'])->name('profil.booking.cancel');
    Route::get('/profil/riwayat-kelas/{id}', fn() => view('profile.kelas-detail'))->name('profil.kelas-detail');

    // Booking
    Route::get('/booking', [App\Http\Controllers\BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking/cart', [App\Http\Controllers\BookingController::class, 'addToCart'])->name('booking.cart.add');
    Route::delete('/booking/cart/{id}', [App\Http\Controllers\BookingController::class, 'removeFromCart'])->name('booking.cart.remove');
    Route::post('/booking/checkout', [App\Http\Controllers\BookingController::class, 'checkout'])->name('booking.checkout');

    // Reviews
    Route::post('/reviews', [App\Http\Controllers\StudioReviewController::class, 'store'])->name('reviews.store');

    // Checkout / Pembayaran
    Route::get('/checkout', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [App\Http\Controllers\PaymentController::class, 'store'])->name('payment.store');
    Route::get('/checkout/status', [App\Http\Controllers\PaymentController::class, 'status'])->name('payment.status');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── ADMIN ROUTES ─────────────────────────────────────────────────────────────

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Bookings
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/payment/{paymentId}/confirm', [App\Http\Controllers\Admin\BookingController::class, 'confirmPayment'])->name('bookings.payment.confirm');
    Route::post('/bookings/payment/{paymentId}/reject', [App\Http\Controllers\Admin\BookingController::class, 'rejectPayment'])->name('bookings.payment.reject');
    Route::post('/bookings/{id}/settlement', [App\Http\Controllers\Admin\BookingController::class, 'confirmSettlement'])->name('bookings.settlement');
    Route::post('/bookings/{id}/cancel', [App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/bookings/{id}/invoice', [App\Http\Controllers\Admin\BookingController::class, 'invoice'])->name('bookings.invoice');

    // Studios
    Route::get('/studios', [App\Http\Controllers\Admin\StudioController::class, 'index'])->name('studios.index');
    Route::get('/studios/create', [App\Http\Controllers\Admin\StudioController::class, 'create'])->name('studios.create');
    Route::post('/studios', [App\Http\Controllers\Admin\StudioController::class, 'store'])->name('studios.store');
    Route::get('/studios/{id}/edit', [App\Http\Controllers\Admin\StudioController::class, 'edit'])->name('studios.edit');
    Route::put('/studios/{id}', [App\Http\Controllers\Admin\StudioController::class, 'update'])->name('studios.update');
    Route::delete('/studios/{id}', [App\Http\Controllers\Admin\StudioController::class, 'destroy'])->name('studios.destroy');
    Route::post('/studios/{id}/toggle-active', [App\Http\Controllers\Admin\StudioController::class, 'toggleActive'])->name('studios.toggle-active');

    // Kelas
    Route::get('/kelas', [App\Http\Controllers\Admin\OpenClassController::class, 'index'])->name('classes.index');
    Route::get('/kelas/create', [App\Http\Controllers\Admin\OpenClassController::class, 'create'])->name('classes.create');
    Route::post('/kelas', [App\Http\Controllers\Admin\OpenClassController::class, 'store'])->name('classes.store');
    Route::get('/kelas/{class}/edit', [App\Http\Controllers\Admin\OpenClassController::class, 'edit'])->name('classes.edit');
    Route::put('/kelas/{class}', [App\Http\Controllers\Admin\OpenClassController::class, 'update'])->name('classes.update');
    Route::delete('/kelas/{class}', [App\Http\Controllers\Admin\OpenClassController::class, 'destroy'])->name('classes.destroy');
    Route::post('/kelas/{class}/toggle-active', [App\Http\Controllers\Admin\OpenClassController::class, 'toggleActive'])->name('classes.toggle-active');

    // Maintenance / Biaya Operasional
    Route::get('/maintenance', [App\Http\Controllers\Admin\MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [App\Http\Controllers\Admin\MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [App\Http\Controllers\Admin\MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{maintenance}/edit', [App\Http\Controllers\Admin\MaintenanceController::class, 'edit'])->name('maintenance.edit');
    Route::put('/maintenance/{maintenance}', [App\Http\Controllers\Admin\MaintenanceController::class, 'update'])->name('maintenance.update');
    Route::delete('/maintenance/{maintenance}', [App\Http\Controllers\Admin\MaintenanceController::class, 'destroy'])->name('maintenance.destroy');

    // Laporan
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

    // Mentors
    Route::get('/mentors', [App\Http\Controllers\Admin\MentorController::class, 'index'])->name('mentors.index');
    Route::get('/mentors/create', [App\Http\Controllers\Admin\MentorController::class, 'create'])->name('mentors.create');
    Route::post('/mentors', [App\Http\Controllers\Admin\MentorController::class, 'store'])->name('mentors.store');
    Route::get('/mentors/{mentor}/edit', [App\Http\Controllers\Admin\MentorController::class, 'edit'])->name('mentors.edit');
    Route::put('/mentors/{mentor}', [App\Http\Controllers\Admin\MentorController::class, 'update'])->name('mentors.update');
    Route::delete('/mentors/{mentor}', [App\Http\Controllers\Admin\MentorController::class, 'destroy'])->name('mentors.destroy');
    Route::post('/mentors/{mentor}/toggle-active', [App\Http\Controllers\Admin\MentorController::class, 'toggleActive'])->name('mentors.toggle-active');

    // Customers
    Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/export-pdf', [App\Http\Controllers\Admin\CustomerController::class, 'exportPdf'])->name('customers.export-pdf');
    Route::post('/customers/{customer}/toggle-active', [App\Http\Controllers\Admin\CustomerController::class, 'toggleActive'])->name('customers.toggle-active');
    Route::post('/customers/{customer}/reset-password', [App\Http\Controllers\Admin\CustomerController::class, 'resetPassword'])->name('customers.reset-password');

    // Notifications
    Route::get('/notifications/{id}/read', [App\Http\Controllers\Admin\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});

require __DIR__.'/auth.php';
