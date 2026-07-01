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
use App\Http\Controllers\Admin\AdminCertificateController;
use App\Http\Controllers\Admin\AdminCoordinatorReportController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCoordinatorSelectionController;
use App\Http\Controllers\Relawan\RelawanDashboardController;
use App\Http\Controllers\Relawan\RelawanNotificationController;
use App\Http\Controllers\Relawan\RelawanCoordinatorReportController;
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
    Route::get('/transparency/{report}/edit', [AdminTransparencyController::class, 'edit'])->name('transparency.edit');
    Route::put('/transparency/{report}/info', [AdminTransparencyController::class, 'updateInfo'])->name('transparency.updateInfo');

    // Alokasi Belanja
    Route::post('/transparency/{report}/allocations', [AdminTransparencyController::class, 'storeAllocation'])->name('transparency.allocations.store');
    Route::put('/transparency/allocations/{allocation}', [AdminTransparencyController::class, 'updateAllocation'])->name('transparency.allocations.update');
    Route::delete('/transparency/allocations/{allocation}', [AdminTransparencyController::class, 'destroyAllocation'])->name('transparency.allocations.destroy');

    // Timeline Penyaluran
    Route::post('/transparency/{report}/timeline', [AdminTransparencyController::class, 'storeTimeline'])->name('transparency.timeline.store');
    Route::put('/transparency/timeline/{timeline}', [AdminTransparencyController::class, 'updateTimeline'])->name('transparency.timeline.update');
    Route::delete('/transparency/timeline/{timeline}', [AdminTransparencyController::class, 'destroyTimeline'])->name('transparency.timeline.destroy');

    // Dokumen Pendukung
    Route::post('/transparency/{report}/docs', [AdminTransparencyController::class, 'storeDoc'])->name('transparency.docs.store');
    Route::delete('/transparency/docs/{doc}', [AdminTransparencyController::class, 'destroyDoc'])->name('transparency.docs.destroy');
    Route::post('transparency/{report}/evidence', [AdminTransparencyController::class, 'storeEvidence'])->name('transparency.evidence.store');
    Route::delete('transparency/evidence/{evidence}', [AdminTransparencyController::class, 'destroyEvidence'])->name('transparency.evidence.destroy');
    Route::match(['put','patch'], '/transparency/{report}', [AdminTransparencyController::class, 'update'])->name('transparency.update');
    Route::get('/volunteers', [AdminVolunteerController::class, 'index'])->name('volunteers.index');
    Route::get('/volunteers/{user}', [AdminVolunteerController::class, 'show'])->name('volunteers.show');
    Route::post('/volunteers/{user}/verify', [AdminVolunteerController::class, 'verify'])->name('volunteers.verify');
    Route::put('/volunteers/{user}', [AdminVolunteerController::class, 'update'])->name('volunteers.update');
    Route::get('/assignments', [AdminAssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{campaign}', [AdminAssignmentController::class, 'show'])->name('assignments.show');
    Route::post('/assignments/{campaign}/roles', [AdminAssignmentController::class, 'storeRole'])->name('assignments.roles.store');
    Route::delete('/assignments/roles/{role}', [AdminAssignmentController::class, 'destroyRole'])->name('assignments.roles.destroy');
    Route::post('/assignments/volunteers/{volunteer}/verifikasi', [AdminAssignmentController::class, 'verifikasi'])->name('assignments.verifikasi');
    Route::post('/assignments', [AdminAssignmentController::class, 'store'])->name('assignments.store');
    Route::patch('assignments/volunteers/{volunteer}/set-coordinator', [AdminAssignmentController::class, 'setKoordinator'])->name('assignments.set-coordinator');
    Route::patch('assignments/volunteers/{volunteer}/unset-coordinator', [AdminAssignmentController::class, 'unsetKoordinator'])->name('assignments.unset-coordinator');
    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/profile', [AdminSettingsController::class, 'profile'])->name('settings.profile');
    Route::match(['put', 'patch'], '/settings/profile', [AdminSettingsController::class, 'updateProfile'])->name('settings.profile.update');
    // sertifikat relawan
    Route::get('/certificates', [AdminCertificateController::class, 'index'])->name('certificates.index');
    Route::post('/certificates', [AdminCertificateController::class, 'store'])->name('certificates.store');
    Route::delete('/certificates/{certificate}', [AdminCertificateController::class, 'destroy'])->name('certificates.destroy');
    Route::get('coordinator-reports', [AdminCoordinatorReportController::class, 'index'])->name('coordinator-reports.index');
    Route::get('/certificates/{campaign}', [AdminCertificateController::class, 'show'])->name('certificates.show');
    Route::get('coordinator-reports/{coordinatorReport}', [AdminCoordinatorReportController::class, 'show'])->name('coordinator-reports.show');
    Route::post('coordinator-reports/{coordinatorReport}/approve', [AdminCoordinatorReportController::class, 'approve'])->name('coordinator-reports.approve');
    Route::post('coordinator-reports/{coordinatorReport}/reject', [AdminCoordinatorReportController::class, 'reject'])->name('coordinator-reports.reject');

    // Seleksi Koordinator Bencana
    Route::get('/coordinator-selections', [AdminCoordinatorSelectionController::class, 'index'])->name('coordinator-selections.index');
    Route::post('/coordinator-selections/volunteers/{volunteer}/verifikasi', [AdminCoordinatorSelectionController::class, 'verifikasi'])->name('coordinator-selections.verifikasi');
    Route::get('/notifications/unread', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'unread'])->name('notifications.unread');
    Route::get('/notifications', [\App\Http\Controllers\Admin\AdminNotificationController::class, 'index'])->name('notifications');
});

// Relawan
Route::prefix('relawan')->name('relawan.')->middleware(['auth', 'role:relawan'])->group(function () {
    Route::get('/dashboard', [RelawanDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bencana', [RelawanDashboardController::class, 'bencana'])->name('bencana');
    Route::get('/bencana-diikuti', [RelawanDashboardController::class, 'bencanaDiikuti'])->name('bencana-diikuti');
    Route::get('/bencana-diikuti/selesai', [RelawanDashboardController::class, 'bencanaDiikutiSelesai'])->name('bencana-diikuti.selesai');
    Route::get('/bencana/{campaign}/gabung-relawan', [\App\Http\Controllers\Relawan\VolunteerJoinController::class, 'create'])->name('volunteer-join.create');
    Route::post('/bencana/{campaign}/gabung-relawan', [\App\Http\Controllers\Relawan\VolunteerJoinController::class, 'store'])->name('volunteer-join.store');
    Route::get('/bencana-diikuti/{campaign}/detail', [RelawanDashboardController::class, 'bencanaDiikutiDetail'])->name('bencana-diikuti.detail');
    Route::get('/transparansi', [RelawanDashboardController::class, 'transparansi'])->name('transparansi');
    Route::get('/transparansi/{report}', [RelawanDashboardController::class, 'show'])->name('transparansi.detail');
    Route::get('/notifikasi', [RelawanNotificationController::class, 'index'])->name('notifications');
    Route::get('/notifikasi/unread', [RelawanNotificationController::class, 'unread'])->name('notifications.unread');

    // Coordinator reports resource routes
    Route::resource('coordinator-reports', RelawanCoordinatorReportController::class)->names([
        'index' => 'coordinator-reports.index',
        'create' => 'coordinator-reports.create',
        'store' => 'coordinator-reports.store',
        'show' => 'coordinator-reports.show',
        'edit' => 'coordinator-reports.edit',
        'update' => 'coordinator-reports.update',
        'destroy' => 'coordinator-reports.destroy',
    ]);

    Route::delete('coordinator-reports/photos/{photo}', [RelawanCoordinatorReportController::class, 'destroyPhoto'])
    ->name('coordinator-reports.photos.destroy');
    Route::delete('coordinator-reports/documents/{document}', [RelawanCoordinatorReportController::class, 'destroyDocument'])
        ->name('coordinator-reports.documents.destroy');
    Route::get('/sertifikat/{campaign}', [\App\Http\Controllers\Relawan\RelawanCertificateController::class, 'show'])
    ->name('sertifikat');
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