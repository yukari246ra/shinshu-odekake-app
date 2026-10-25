<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class MyPage extends Component
{
    public function mount()
    {
        // ログインしていない場合は 403
        abort_unless(Auth::check(), 403);
    }

    public function render()
    {
        // ログインユーザーのお気に入り一覧を取得（N+1なし）
        $favorites = Favorite::where('user_id', Auth::id())
            ->with('spot')
            ->get();

        return view('livewire.my-page', [
            'favorites' => $favorites,
        ]);
    }
}
