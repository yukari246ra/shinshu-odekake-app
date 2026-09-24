<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class MyPage extends Component
{
    public $favorites;

    public function mount()
    {
        // ログインユーザーのお気に入り一覧を取得
        $this->favorites = Favorite::where('user_id', Auth::id())
            ->with('spot')
            ->get();
    }

    public function render()
    {
        return view('livewire.my-page');
    }
}
