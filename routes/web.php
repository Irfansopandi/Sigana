<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCampaignController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminTransparencyController;
use App\Http\Controllers\Admin\AdminVolunteerController;
use App\Http\Controllers\Admin\AdminAssignmentController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Relawan\RelawanDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\User\NotificationController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/bencana', [HomeController::class, 'bencana'])->name('bencana');
Route::get('/bencana/{slug}', [DonationController::class, 'bencanaDetail'])->name('bencana.detail');
Route::get('/bencana/{slug}/donasi', [HomeController::class, 'bencanaDonasiPage'])->name('bencana.donasi');
Route::post('/bencana/{slug}/donasi/transaction', [DonationController::class, 'createTransaction'])->name('bencana.donasi.transaction');
Route::get('/bencana/{slug}/donasi/payment/{donation}', [DonationController::class, 'payment'])->name('bencana.donasi.payment');
Route::get('/bencana/{slug}/donasi/finish', [DonationController::class, 'finish'])->name('bencana.donasi.finish');
Route::post('/bencana/donasi/update-status', [DonationController::class, 'updateStatus'])->name('bencana.donasi.update-status');
Route::get('/transparansi', [HomeController::class, 'transparansi'])->name('transparansi');
Route::get('/transparansi/{slug}', [HomeController::class, 'transparansiDetail'])->name('transparansi.detail');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/gabung-relawan', [RegisterController::class, 'showRelawan'])->name('register.relawan');
Route::post('/gabung-relawan', [RegisterController::class, 'storeRelawan'])->name('register.relawan.store');

// Midtrans webhook
Route::post('/midtrans/notification', [DonationController::class, 'notification'])->name('midtrans.notification');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');

    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('password.send-otp');
    Route::get('/forgot-password/otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
    Route::post('/forgot-password/otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
// Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/campaigns', [AdminCampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [AdminCampaignController::class, 'create'])->name('campaigns.create');
    Route::get('/campaigns/archived', [AdminCampaignController::class, 'archived'])->name('campaigns.archived'); 
    Route::post('/campaigns', [AdminCampaignController::class, 'store'])->name('campaigns.store');
    Route::get('/campaigns/{campaign}', [AdminCampaignController::class, 'show'])->name('campaigns.show');
    Route::get('/campaigns/{campaign}/edit', [AdminCampaignController::class, 'edit'])->name('campaigns.edit');
    Route::match(['put', 'patch'], '/campaigns/{campaign}', [AdminCampaignController::class, 'update'])->name('campaigns.update');
    Route::delete('/campaigns/{campaign}', [AdminCampaignController::class, 'destroy'])->name('campaigns.destroy');


    Route::post('/campaigns/{campaign}/approve', [AdminCampaignController::class, 'approve'])->name('campaigns.approve');
    Route::post('/campaigns/{campaign}/reject', [AdminCampaignController::class, 'reject'])->name('campaigns.reject');
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::get('/transparency', [AdminTransparencyController::class, 'index'])->name('transparency.index');
    Route::get('/transparency/{report}', [AdminTransparencyController::class, 'show'])->name('transparency.show');
    Route::match(['put','patch'], '/transparency/{report}', [AdminTransparencyController::class, 'update'])->name('transparency.update');
    Route::get('/volunteers', [AdminVolunteerController::class, 'index'])->name('volunteers.index');
    Route::get('/volunteers/{user}', [AdminVolunteerController::class, 'show'])->name('volunteers.show');
    Route::post('/volunteers/{user}/verify', [AdminVolunteerController::class, 'verify'])->name('volunteers.verify');
    Route::put('/volunteers/{user}', [AdminVolunteerController::class, 'update'])->name('volunteers.update');
    Route::get('/assignments', [AdminAssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create', [AdminAssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AdminAssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [AdminSettingsController::class, 'profile'])->name('settings.profile');
    Route::match(['put', 'patch'], '/settings/profile', [AdminSettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::get('/settings/system', [AdminSettingsController::class, 'system'])->name('settings.system');
    Route::match(['put', 'patch'], '/settings/system', [AdminSettingsController::class, 'updateSystem'])->name('settings.system.update');
});

// Relawan
Route::prefix('relawan')->name('relawan.')->middleware(['auth', 'role:relawan'])->group(function () {
    Route::get('/dashboard', [RelawanDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', function () { return 'Coming soon'; })->name('laporan.index');
});


// User
Route::prefix('user')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/kampanye', [UserDashboardController::class, 'campaigns'])->name('campaigns');
    Route::get('/kampanye-selesai', [UserDashboardController::class, 'archivedCampaigns'])->name('campaigns.archived'); 
    Route::get('/lapor-bencana', [UserDashboardController::class, 'indexReport'])->name('lapor-bencana');
    Route::get('/lapor-bencana/create', [UserDashboardController::class, 'createReport'])->name('lapor-bencana.create');
    Route::post('/lapor-bencana', [UserDashboardController::class, 'storeReport'])->name('lapor-bencana.store');
    Route::delete('lapor-bencana/{campaign}', [UserDashboardController::class, 'destroyReport'])->name('lapor-bencana.destroy');
    Route::get('/lapor-bencana/{campaign}/edit', [UserDashboardController::class, 'editReport'])->name('lapor-bencana.edit');
    Route::put('/lapor-bencana/{campaign}', [UserDashboardController::class, 'updateReport'])->name('lapor-bencana.update');
    Route::get('/riwayat-donasi', [UserDashboardController::class, 'donationHistory'])->name('donation-history');
    Route::get('/transparansi', [UserDashboardController::class, 'transparency'])->name('transparency');
    Route::get('/profil', [UserDashboardController::class, 'profile'])->name('profile');
    Route::put('/profil/info', [UserDashboardController::class, 'updateInfo'])->name('profile.update-info');
    Route::put('/profil/password', [UserDashboardController::class, 'updatePassword'])->name('profile.update-password');
    Route::put('/profil/photo', [UserDashboardController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifikasi/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/notifikasi/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
});