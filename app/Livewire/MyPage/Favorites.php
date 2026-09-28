<?php

namespace App\Livewire\MyPage;

use Livewire\Component;
use App\Models\Favorite;

class Favorites extends Component
{
    public function render()
    {
        $favorites = Favorite::with('spot')
            ->where('user_id', auth()->id())
            ->get();

        return view('livewire.my-page.favorites', [
            'favorites' => $favorites,
        ]);
    }
}
