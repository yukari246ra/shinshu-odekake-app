<?php

namespace App\Livewire;

use Livewire\Component;
//use App\Models\Favorite;
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
        return view('livewire.my-page')
            ->title('マイページ | 信州おでかけアプリ');
    }
}
