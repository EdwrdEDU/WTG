<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\SavedEventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::get('/', [HomeController::class, 'landing']);
Route::get('/home', [HomeController::class, 'index'])->name('homepage');
Route::get('/contacts', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');
Route::view('/help-center', 'helpcenter.index');

Route::view('/account/create', 'account.create');
Route::view('/account/login', 'account.login')->name('login');
Route::post('/account/login', [AccountController::class, 'login'])->name('account.login');
Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');

Route::get('/search/page', fn () => view('account-view.search-page'));
Route::get('/search', [EventController::class, 'search'])->name('events.search');

// ✅ Forgot/Reset Password (Public)
Route::get('/forgot-password', [AccountController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::post('/forgot-password', [AccountController::class, 'sendResetLink'])->name('forgot.password.send');
Route::get('/reset-password/{token}', [AccountController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AccountController::class, 'resetPassword'])->name('password.update');

// PROTECTED ROUTES (Require Login)
Route::middleware('auth')->group(function () {
    Route::post('/account/logout', [AccountController::class, 'logout'])->name('account.logout');

    // Event CRUD
    Route::get('/events/create', fn () => view('events.create'))->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Saved Events
    Route::get('/saved-events', [SavedEventController::class, 'index'])->name('saved-events');
    Route::post('/saved-events/external', [SavedEventController::class, 'saveExternalEvent'])->name('saved-events.external');
    Route::delete('/saved-events/external', [SavedEventController::class, 'unsaveExternalEvent'])->name('saved-events.external.delete');
    Route::post('/saved-events/check', [SavedEventController::class, 'checkSaved'])->name('saved-events.check');
    Route::delete('/saved-events/{savedEvent}', [SavedEventController::class, 'destroy'])->name('saved-events.destroy');
    Route::post('/events/{event}/save', [SavedEventController::class, 'saveLocalEvent'])->name('events.save');
    Route::delete('/events/{event}/unsave', [SavedEventController::class, 'unsaveLocalEvent'])->name('events.unsave');

    // Dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $userEvents = $user->events()->latest()->take(5)->get();
        $savedEventsCount = $user->savedEvents()->count(); 
        return view('dashboard.index', compact('user', 'userEvents', 'savedEventsCount'));
    })->name('dashboard');

    // My Events
    Route::get('/my-events', function () {
        $events = auth()->user()->events()->latest()->paginate(10);
        return view('my-events.index', compact('events'));
    })->name('my-events');

    // Account
    Route::get('/account/edit', fn () => view('account.edit', ['user' => auth()->user()]))->name('account.edit');
    Route::put('/account/edit', [AccountController::class, 'update'])->name('account.edit');

    // Interests
    Route::post('/interests/save', [InterestController::class, 'save'])->name('interests.save');
    Route::get('/interests', fn () => view('interests.index', ['interests' => auth()->user()->interests ?? collect()]))->name('interests.index');
    Route::post('/interests/toggle', [InterestController::class, 'toggle'])->name('interests.toggle');
    Route::get('/interests/recommended-events', [InterestController::class, 'getRecommendedEvents'])->name('interests.recommended');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread'])->name('notifications.unread');
    Route::get('/notifications/stats', [NotificationController::class, 'getStats'])->name('notifications.stats');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
    Route::get('/notifications/settings', [NotificationController::class, 'settings'])->name('notifications.settings');
    Route::post('/notifications/settings', [NotificationController::class, 'updateSettings'])->name('notifications.settings.update');
    Route::post('/notifications/test', [NotificationController::class, 'test'])->name('notifications.test');
});
