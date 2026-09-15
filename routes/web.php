<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
//use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
//use Laravel\Fortify\Features;
use App\Livewire\CreatePost;
use App\Livewire\Dashboard;
use App\Livewire\EditPost;
use App\Livewire\MyPosts;
use App\Livewire\ShowPosts;
use App\Livewire\ShowPost;
use App\Livewire\ShowSpots;
use App\Livewire\CreateSpot;
use App\Livewire\ShowSpot;
use App\Livewire\EditSpot;
use App\Livewire\SearchSpots;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('/posts/create', CreatePost::class)->name('posts.create');
    Route::get('/posts/{post}', ShowPost::class)->name('post');
    Route::get('/posts/{post}/edit', EditPost::class)->name('posts.edit');

    Route::get('/my-posts', MyPosts::class)->name('my-posts');
    Route::get('/spots/create', CreateSpot::class)->name('spots.create');
    Route::get('/spots/{spot}/edit', EditSpot::class)->name('spots.edit');
    Route::delete('/spots/{spot}', [\App\Livewire\EditSpot::class, 'delete'])->name('spots.delete');

});

Route::get('/posts', ShowPosts::class)->name('posts');
Route::get('/spots', ShowSpots::class)->name('spots');
Route::get('/spots/{spot}', ShowSpot::class)->name('spot');
Route::get('/search', SearchSpots::class)->name('spots.search');

