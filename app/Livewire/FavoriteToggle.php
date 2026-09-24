<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteToggle extends Component
{
    public $spotId;
    public $isFavorited = false;

    public function mount($spotId)
    {
        $this->spotId = $spotId;

        // すでにお気に入り済みかどうか判定
        $this->isFavorited = Favorite::where('user_id', Auth::id())
            ->where('spot_id', $spotId)
            ->exists();
    }

    public function toggle()
    {
        if ($this->isFavorited) {
            // お気に入り解除
            Favorite::where('user_id', Auth::id())
                ->where('spot_id', $this->spotId)
                ->delete();

            $this->isFavorited = false;

        } else {
            // お気に入り追加
            Favorite::create([
                'user_id' => Auth::id(),
                'spot_id' => $this->spotId,
            ]);

            $this->isFavorited = true;
        }
    }

    public function render()
    {
        return view('livewire.favorite-toggle');
    }
}
