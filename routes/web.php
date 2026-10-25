<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Livewire\CreateSpot;
use App\Livewire\ShowSpot;
use App\Livewire\EditSpot;
use App\Livewire\SearchSpots;
use App\Livewire\MyPage;
use App\Livewire\MyPage\Favorites;

// ★ SpotList を使うためにインポート
use App\Livewire\SpotList;

// ★ AdminMiddleware を使うためにインポート
use App\Http\Middleware\AdminMiddleware;

// ▼ トップページはサインイン画面へ
Route::redirect('/', '/login');

// ▼ ログイン後の最初の画面（検索画面）
Route::get('/home', SearchSpots::class)->name('home');

Route::middleware(['auth'])->group(function () {

    // ▼ マイページ（トップ）
    Route::get('/mypage', MyPage::class)->name('mypage');

    // ▼ お気に入り一覧
    Route::get('/mypage/favorites', Favorites::class)->name('mypage.favorites');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    // ▼ スポット作成・編集（管理者専用）
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/spots/create', CreateSpot::class)->name('spots.create');
        Route::get('/spots/{spot}/edit', EditSpot::class)->name('spots.edit');
        Route::delete('/spots/{spot}', [EditSpot::class, 'delete'])->name('spots.delete');
    });
});

// ▼ スポット一覧ページ（SpotList）
Route::get('/spots', SpotList::class)->name('spots');

// ▼ スポット詳細ページ
Route::get('/spots/{spot}', ShowSpot::class)->name('spot');

// ▼ 検索ページ
Route::get('/search', SearchSpots::class)->name('spots.search');
