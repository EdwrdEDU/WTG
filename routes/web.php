<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'landing');

Route::view('/home', 'homepage');

Route::view('/contacts', 'contacts.index');

Route::view('/help-center', 'helpcenter.index');

Route::view('/account/create', 'account.create');
Route::view('/account/login', 'account.login');
Route::post('/account/login', [AccountController::class, 'login'])->name('account.login');
Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');
Route::post('/account/logout', [AccountController::class, 'logout'])->name('account.logout');


Route::get('/events/create', function () {return view('events.create');})->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->name('events.store');

Route::get('/search/page', fn () => view('account-view.search-page'));
Route::get('/search', [EventController::class, 'search'])->name('events.search');