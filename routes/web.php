<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InterestController;
use Illuminate\Support\Facades\Route;

// Public routes (accessible without login)
Route::get('/', [HomeController::class, 'landing']);
Route::get('/home', [HomeController::class, 'index'])->name('homepage');
Route::view('/contacts', 'contacts.index');
Route::view('/help-center', 'helpcenter.index');

// Authentication routes
Route::view('/account/create', 'account.create');
Route::view('/account/login', 'account.login')->name('login');
Route::post('/account/login', [AccountController::class, 'login'])->name('account.login');
Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');

// Public search - anyone can search
Route::get('/search/page', fn () => view('account-view.search-page'));
Route::get('/search', [EventController::class, 'search'])->name('events.search');

// PROTECTED ROUTES - require login (same as your create event)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    
    // Event CRUD routes
    Route::get('/events/create', function () {
        return view('events.create');
    })->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    
    // User Dashboard - require login
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $userEvents = $user->events()->latest()->take(5)->get();
        return view('dashboard.index', compact('user', 'userEvents'));
    })->name('dashboard');
    
    // Profile management - require login
    Route::get('/profile', function () {
        return view('profile.show', ['user' => auth()->user()]);
    })->name('profile');
    Route::put('/profile', [AccountController::class, 'updateProfile'])->name('profile.update');
    
    // Saved Events - require login
    Route::get('/saved-events', function () {
        $savedEvents = auth()->user()->savedEvents ?? collect();
        return view('saved-events.index', compact('savedEvents'));
    })->name('saved-events');
    
    // My Events - require login
    Route::get('/my-events', function () {
        $events = auth()->user()->events()->latest()->paginate(10);
        return view('my-events.index', compact('events'));
    })->name('my-events');
    
    // Settings - require login
    Route::get('/settings', function () {
        return view('settings.index', ['user' => auth()->user()]);
    })->name('settings');
    
    // Interests management - require login
    Route::post('/interests/save', [InterestController::class, 'save'])->name('interests.save');
    Route::get('/interests', function () {
        $interests = auth()->user()->interests ?? collect();
        return view('interests.index', compact('interests'));
    })->name('interests.index');
    
    Route::post('/interests/toggle', [InterestController::class, 'toggle'])->name('interests.toggle');
    Route::get('/interests/recommended-events', [InterestController::class, 'getRecommendedEvents'])->name('interests.recommended');


    // Event actions - require login
    Route::post('/events/{event}/save', function ($eventId) {
        // Save event logic
        return response()->json(['success' => true, 'message' => 'Event saved!']);
    })->name('events.save');
    
    Route::delete('/events/{event}/unsave', function ($eventId) {
        // Unsave event logic
        return response()->json(['success' => true, 'message' => 'Event removed!']);
    })->name('events.unsave');
});