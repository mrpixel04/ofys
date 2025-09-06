<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\ActivityController;
use App\Http\Controllers\Guest\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Provider\ProviderController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;

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

// Home page - using the simple jQuery version
Route::get('/', function () {
    return view('guest.simple-welcome');
})->name('home');

// Original Livewire home
Route::get('/livewire-home', [HomeController::class, 'index'])->name('livewire.home');

// Keeping this route for reference
Route::get('/welcome', function () {
    return view('guest.welcome');
});

// Activities routes (these don't require authentication)
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');

// About page
Route::view('/about', 'guest.about')->name('about');

// Contact page
Route::view('/contact', 'guest.contact')->name('contact');

// Legal pages (dummy content to be customized later)
Route::view('/terms', 'guest.legal.terms')->name('legal.terms');
Route::view('/privacy', 'guest.legal.privacy')->name('legal.privacy');

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
    Route::get('/admin/simple-providers', [AdminController::class, 'showSimpleProviders'])->name('admin.simple-providers');
    Route::get('/admin/simple-providers-basic', [AdminController::class, 'showSimpleProvidersBasic'])->name('admin.simple-providers-basic');
    Route::get('/admin/providers/activities', [AdminController::class, 'showActivities'])->name('admin.providers.activities');
    Route::get('/admin/providers/activities/create', [AdminController::class, 'createActivity'])->name('admin.providers.activities.create');
    Route::post('/admin/providers/activities/store', [AdminController::class, 'storeActivity'])->name('admin.providers.activities.store');
    Route::get('/admin/providers/activities/{id}', [AdminController::class, 'showActivityDetails'])->name('admin.providers.activities.show');
    Route::get('/admin/providers/activities/{id}/edit', [AdminController::class, 'editActivity'])->name('admin.providers.activities.edit');
    Route::put('/admin/providers/activities/{id}/update', [AdminController::class, 'updateActivity'])->name('admin.providers.activities.update');
    Route::post('/admin/providers/activities/{id}/toggle-status', [AdminController::class, 'toggleActivityStatus'])->name('admin.providers.activities.toggle-status');
    Route::delete('/admin/providers/activities/{id}', [AdminController::class, 'deleteActivity'])->name('admin.providers.activities.delete');
    Route::get('/admin/providers/{id}', [AdminController::class, 'showProviderDetails'])->name('admin.providers.view');
    Route::get('/admin/providers/{id}/edit', [AdminController::class, 'editProvider'])->name('admin.providers.edit');
    Route::put('/admin/providers/{id}', [AdminController::class, 'updateProvider'])->name('admin.providers.update');

    // Customers management
    Route::get('/admin/customers', [AdminCustomerController::class, 'index'])->name('admin.customers');
    Route::get('/admin/customers/{id}', [AdminCustomerController::class, 'show'])->name('admin.customers.show');
    Route::delete('/admin/customers/{id}', [AdminCustomerController::class, 'destroy'])->name('admin.customers.destroy');

    // Settings
    Route::get('/admin/settings', [AdminController::class, 'showSettings'])->name('admin.settings');
    Route::put('/admin/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/admin/settings/language', [AdminController::class, 'updateLanguage'])->name('admin.settings.language');

    // Admin Profile
    Route::get('/admin/profile', [AdminController::class, 'showSimpleProfile'])->name('admin.profile');
    Route::put('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/admin/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
});

// Provider Routes
Route::middleware(['auth', 'verified', 'role:provider'])->name('provider.')->prefix('provider')->group(function () {
    // Dashboard
    Route::get('/', [ProviderController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProviderController::class, 'showProfile'])->name('profile');
    Route::get('/simple-profile', [ProviderController::class, 'showProfile'])->name('simple-profile');
    Route::post('/profile/update', [ProviderController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [ProviderController::class, 'updatePassword'])->name('password.update');

    // Shop Info
    Route::get('/shop-info', [ProviderController::class, 'showShopInfo'])->name('shop-info');
    Route::post('/shop-info', [ProviderController::class, 'updateShopInfo'])->name('shop-info.update');

    // Activities
    Route::get('/activities', [ProviderController::class, 'showActivities'])->name('activities');
    Route::get('/simple-activities', [ProviderController::class, 'showActivities'])->name('simple-activities');
    Route::get('/activities/create', [ProviderController::class, 'createActivity'])->name('activities.create');
    Route::get('/activities/{id}', [ProviderController::class, 'viewActivity'])->name('activities.view');
    Route::get('/activities/{id}/edit', [ProviderController::class, 'editActivity'])->name('activities.edit');
    Route::delete('/activities/{id}', [ProviderController::class, 'deleteActivity'])->name('activities.delete');

    // Bookings
    Route::get('/bookings', [ProviderController::class, 'showBookings'])->name('bookings');
    Route::get('/bookings/{booking}', [ProviderController::class, 'showBooking'])->name('bookings.show');
    Route::post('/bookings/{booking}/status', [ProviderController::class, 'updateBookingStatus'])->name('bookings.updateStatus');

    // Manually add a redirect to ensure we're handling this properly
    Route::get('/bookings/{booking}/details', function($booking) {
        return redirect()->route('provider.bookings.show', $booking);
    })->name('bookings.details');
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

// Add route for simple welcome page (no Livewire or Alpine)
Route::get('/simple', function () {
    return view('simple-welcome');
})->name('simple.welcome');
