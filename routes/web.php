<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('homepage');
});

// Keeping this route for reference
Route::get('/welcome', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Language Switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ms'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('language.switch');

// Admin Routes
Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Bookings management
    Route::get('/admin/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings');
    Route::get('/admin/bookings/{id}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
    Route::get('/admin/bookings/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.bookings.edit');
    Route::put('/admin/bookings/{id}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    Route::post('/admin/bookings/{id}/cancel', [AdminBookingController::class, 'cancel'])->name('admin.bookings.cancel');
    Route::get('/admin/bookings-statistics', [AdminBookingController::class, 'getStatistics'])->name('admin.bookings.statistics');

    // Providers management
    Route::get('/admin/providers', [AdminController::class, 'showProviders'])->name('admin.providers');
    Route::get('/admin/providers/activities', [AdminController::class, 'showActivities'])->name('admin.providers.activities');
    Route::get('/admin/providers/{id}', [AdminController::class, 'showProviderDetails'])->name('admin.providers.view');
    Route::get('/admin/providers/{id}/edit', [AdminController::class, 'editProvider'])->name('admin.providers.edit');
    Route::put('/admin/providers/{id}', [AdminController::class, 'updateProvider'])->name('admin.providers.update');

    // Customers management
    Route::get('/admin/customers', [AdminController::class, 'showCustomers'])->name('admin.customers');

    // Settings
    Route::get('/admin/settings', [AdminController::class, 'showSettings'])->name('admin.settings');
    Route::put('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});

// Provider Routes
Route::middleware(['auth', 'role:provider'])->group(function () {
    // Dashboard
    Route::get('/provider/dashboard', [ProviderController::class, 'dashboard'])->name('provider.dashboard');

    // Profile
    Route::get('/provider/profile', [ProviderController::class, 'showProfile'])->name('provider.profile');
    Route::put('/provider/profile', [ProviderController::class, 'updateProfile'])->name('provider.profile.update');

    // Shop Info
    Route::get('/provider/shop-info', [ProviderController::class, 'showShopInfo'])->name('provider.shop-info');
    Route::put('/provider/shop-info', [ProviderController::class, 'updateShopInfo'])->name('provider.shop-info.update');

    // Bookings management
    Route::get('/provider/bookings', [ProviderController::class, 'showBookings'])->name('provider.bookings');

    // Activities management
    Route::get('/provider/activities', [ProviderController::class, 'showActivities'])->name('provider.activities');

    // Pricing management
    Route::get('/provider/pricing', [ProviderController::class, 'showPricing'])->name('provider.pricing');
});

// Customer Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    // Profile
    Route::get('/profile', [CustomerController::class, 'showProfile'])->name('customer.profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');

    // Account
    Route::get('/account', [CustomerController::class, 'showAccount'])->name('customer.account');
    Route::put('/account/password', [CustomerController::class, 'updatePassword'])->name('customer.account.password.update');

    // Bookings
    Route::get('/bookings', [CustomerController::class, 'showBookings'])->name('customer.bookings');
    Route::get('/bookings/{id}', [CustomerController::class, 'showBookingDetails'])->name('customer.bookings.show');
    Route::post('/bookings/{id}/cancel', [CustomerController::class, 'cancelBooking'])->name('customer.bookings.cancel');
});
