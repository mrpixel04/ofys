<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Livewire\HomeActivities;

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

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Keeping this route for reference
Route::get('/welcome', function () {
    return view('welcome');
});

// Activities routes (these don't require authentication)
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');

// About page
Route::view('/about', 'about')->name('about');

// Contact page
Route::view('/contact', 'contact')->name('contact');

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
    Route::post('/admin/bookings/{id}/payment', [AdminBookingController::class, 'processPayment'])->name('admin.bookings.payment');
    Route::get('/admin/bookings-statistics', [AdminBookingController::class, 'getStatistics'])->name('admin.bookings.statistics');

    // Providers management
    Route::get('/admin/providers', [AdminController::class, 'showProviders'])->name('admin.providers');
    Route::get('/admin/providers/activities', [AdminController::class, 'showActivities'])->name('admin.providers.activities');
    Route::get('/admin/providers/activities/{id}', [AdminController::class, 'showActivityDetails'])->name('admin.providers.activities.show');
    Route::get('/admin/providers/{id}', [AdminController::class, 'showProviderDetails'])->name('admin.providers.view');
    Route::get('/admin/providers/{id}/edit', [AdminController::class, 'editProvider'])->name('admin.providers.edit');
    Route::put('/admin/providers/{id}', [AdminController::class, 'updateProvider'])->name('admin.providers.update');

    // Customers management
    Route::get('/admin/customers', [AdminController::class, 'showCustomers'])->name('admin.customers');

    // Settings
    Route::get('/admin/settings', [AdminController::class, 'showSettings'])->name('admin.settings');
    Route::put('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/admin/settings/language', [AdminController::class, 'updateLanguage'])->name('admin.settings.language');

    // Admin Profile
    Route::get('/admin/profile', [AdminController::class, 'showProfile'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/admin/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
});

// Provider Routes
Route::middleware(['auth', 'role:provider'])->prefix('provider')->name('provider.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProviderController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProviderController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [ProviderController::class, 'updateProfile'])->name('profile.update');

    // Shop Info
    Route::get('/shop-info', [ProviderController::class, 'showShopInfo'])->name('shop-info');
    Route::put('/shop-info', [ProviderController::class, 'updateShopInfo'])->name('shop-info.update');

    // Bookings management
    Route::get('/bookings', [ProviderController::class, 'showBookings'])->name('bookings');
    Route::get('/bookings/{booking}', [ProviderController::class, 'showBooking'])->name('bookings.show');
    Route::post('/bookings/{booking}/status', [ProviderController::class, 'updateBookingStatus'])->name('bookings.updateStatus');

    // Activities management
    Route::get('/activities', [ProviderController::class, 'showActivities'])->name('activities');
    Route::get('/activities/create', [ProviderController::class, 'createActivity'])->name('activities.create');
    Route::get('/activities/{id}', [ProviderController::class, 'viewActivity'])->name('activities.view');
    Route::get('/activities/{id}/edit', [ProviderController::class, 'editActivity'])->name('activities.edit');

    // Pricing management
    Route::get('/pricing', [ProviderController::class, 'showPricing'])->name('pricing');
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
    Route::get('/bookings', [CustomerBookingController::class, 'index'])->name('customer.bookings');
    Route::get('/bookings/{id}', [CustomerBookingController::class, 'show'])->name('customer.bookings.show');
    Route::post('/bookings/{id}/cancel', [CustomerBookingController::class, 'cancel'])->name('customer.bookings.cancel');

    // Payment routes
    Route::post('/bookings/{id}/payment/transfer', [CustomerBookingController::class, 'processTransferPayment'])->name('customer.bookings.payment.transfer');
    Route::get('/bookings/{id}/payment/online', [CustomerBookingController::class, 'showOnlinePayment'])->name('customer.bookings.payment.online');
    Route::post('/bookings/{id}/payment/cash', [CustomerBookingController::class, 'processCashPayment'])->name('customer.bookings.payment.cash');

    // Activity booking (requires login)
    Route::get('/activities/{id}/book', [CustomerBookingController::class, 'create'])->name('customer.bookings.create');
    Route::post('/activities/{id}/book', [CustomerBookingController::class, 'store'])->name('customer.bookings.store');

    // Booking confirmation
    Route::get('/booking/confirmation/{id}', [CustomerBookingController::class, 'confirmation'])->name('customer.bookings.confirmation');
});
