<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Livewire\ShowSpots;
use App\Livewire\CreateSpot;
use App\Livewire\ShowSpot;
use App\Livewire\EditSpot;
use App\Livewire\SearchSpots;
use App\Livewire\MyPage;
use App\Livewire\MyPage\Favorites;   // ★ 追加（忘れずに）

// ▼ トップページはサインイン画面へ
Route::redirect('/', '/login');

// ▼ ログイン後の最初の画面（検索画面）
Route::get('/home', SearchSpots::class)->name('home');

Route::middleware(['auth'])->group(function () {

    // ▼ マイページ（トップ）
    Route::get('/mypage', MyPage::class)->name('mypage');

    // ▼ お気に入り一覧（新規追加）
    Route::get('/mypage/favorites', Favorites::class)->name('mypage.favorites');  // ★ これが必要

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    // ▼ スポット作成・編集
    Route::get('/spots/create', CreateSpot::class)->name('spots.create');
    Route::get('/spots/{spot}/edit', EditSpot::class)->name('spots.edit');
    Route::delete('/spots/{spot}', [\App\Livewire\EditSpot::class, 'delete'])->name('spots.delete');
});

// ▼ スポット一覧・詳細
Route::get('/spots', ShowSpots::class)->name('spots');
Route::get('/spots/{spot}', ShowSpot::class)->name('spot');

// ▼ 検索ページ（ログイン後に使う）
Route::get('/search', SearchSpots::class)->name('spots.search');
