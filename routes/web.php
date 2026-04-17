<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyInquiryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\MaintenanceRequestController as AdminMaintenanceRequestController;
use App\Http\Controllers\Admin\PropertyImageController;
use App\Http\Controllers\Admin\RentPaymentController as AdminRentPaymentController;
use App\Models\Category;
use App\Models\Contact;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\PropertyInquiry;
use App\Models\RentPayment;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $publishedProperties = Property::query()->where('is_published', true);

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'featured_properties' => Property::with(['category', 'mainImage'])
            ->where('is_published', true)
            ->where('featured', true)
            ->latest()
            ->take(3)
            ->get(),
        'market_stats' => [
            'total' => (clone $publishedProperties)->count(),
            'sales' => (clone $publishedProperties)->where('type', 'sale')->count(),
            'rents' => (clone $publishedProperties)->where('type', 'rent')->count(),
            'featured' => (clone $publishedProperties)->where('featured', true)->count(),
            'cities' => (clone $publishedProperties)->distinct()->count('location'),
        ],
        'categories' => Category::withCount([
            'properties' => fn ($query) => $query->where('is_published', true),
        ])
            ->orderByDesc('properties_count')
            ->take(4)
            ->get(),
    ]);
})->name('home');

// Routes publiques pour les biens
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [PropertyController::class, 'show'])->name('properties.show');
Route::post('/properties/{property:slug}/inquiries', [PropertyInquiryController::class, 'store'])->name('properties.inquiries.store');

Route::get('/dashboard', function () {
    $properties = \App\Models\Property::with('category')->get();
    $total = $properties->count();
    $rentals = $properties->where('type', 'rent');
    $rentedCount = $properties->where('status', 'rented')->count();
    $availableCount = $properties->where('status', 'available')->count();
    $maintenanceCount = $properties->where('status', 'maintenance')->count();
    $occupancyRate = $rentals->count() > 0
        ? round(($rentals->where('status', 'rented')->count() / $rentals->count()) * 100)
        : 0;

    return Inertia::render('Dashboard', [
        'stats' => [
            'total' => $total,
            'sales' => $properties->where('type', 'sale')->count(),
            'rents' => $rentals->count(),
            'featured' => $properties->where('featured', true)->count(),
            'available' => $availableCount,
            'rented' => $rentedCount,
            'maintenance' => $maintenanceCount,
            'occupancy_rate' => $occupancyRate,
            'contacts' => Contact::count(),
            'inquiries' => PropertyInquiry::count(),
            'open_maintenance' => MaintenanceRequest::whereIn('status', ['open', 'in_progress'])->count(),
            'pending_rent_payments' => RentPayment::whereIn('status', ['pending', 'late', 'partial'])->count(),
        ],
        'recent_properties' => \App\Models\Property::with(['category', 'mainImage'])->latest()->take(5)->get(),
        'status_breakdown' => [
            ['label' => 'Libre', 'value' => $availableCount, 'status' => 'available'],
            ['label' => 'Loué', 'value' => $rentedCount, 'status' => 'rented'],
            ['label' => 'En travaux', 'value' => $maintenanceCount, 'status' => 'maintenance'],
        ],
        'type_breakdown' => [
            ['label' => 'Vente', 'value' => $properties->where('type', 'sale')->count()],
            ['label' => 'Location', 'value' => $rentals->count()],
        ],
        'category_breakdown' => \App\Models\Category::withCount('properties')
            ->orderByDesc('properties_count')
            ->take(5)
            ->get()
            ->map(fn ($category) => [
                'label' => $category->name,
                'value' => $category->properties_count,
            ])
            ->values(),
        'pipeline' => [
            ['label' => 'Demandes', 'value' => PropertyInquiry::count()],
            ['label' => 'Contacts', 'value' => Contact::count()],
            ['label' => 'Loyers a suivre', 'value' => RentPayment::whereIn('status', ['pending', 'late', 'partial'])->count()],
            ['label' => 'Maintenance ouverte', 'value' => MaintenanceRequest::whereIn('status', ['open', 'in_progress'])->count()],
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Espace Admin
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('properties', \App\Http\Controllers\Admin\PropertyController::class)->except('show');
    Route::patch('properties/{property}/images/{image}/main', [PropertyImageController::class, 'main'])->name('properties.images.main');
    Route::delete('properties/{property}/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
    Route::patch('properties/{property}/images/reorder', [PropertyImageController::class, 'reorder'])->name('properties.images.reorder');
    Route::resource('contacts', AdminContactController::class)->except('show');
    Route::resource('inquiries', AdminInquiryController::class)->only(['index', 'update', 'destroy']);
    Route::resource('rent-payments', AdminRentPaymentController::class)->except('show');
    Route::resource('maintenance-requests', AdminMaintenanceRequestController::class)->except('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
