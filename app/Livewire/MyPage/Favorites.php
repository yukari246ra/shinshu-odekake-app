<?php

namespace App\Livewire\MyPage;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Spot;

class Favorites extends Component
{
    // ▼ ハートを押すとお気に入りから外れる（このページには外す操作だけ用意）
    public function toggleFavorite(int $spotId)
    {
        $spot = Spot::findOrFail($spotId);
        $favorite = $spot->favorites()->where('user_id', Auth::id())->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            $spot->favorites()->create(['user_id' => Auth::id()]);
        }
    }

    public function render()
    {
        // ▼ 自分がお気に入りにしたスポットだけを取得
        $spots = Spot::query()
            ->withCount('favorites')
            ->whereHas('favorites', fn($q) => $q->where('user_id', Auth::id()))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.my-page.favorites', [
            'spots' => $spots,
            // ▼ このページに出るスポットはすべてお気に入り済み
            'favoriteIds' => $spots->pluck('id')->all(),
        ])->title('お気に入りスポット | 信州おでかけアプリ');
    }
}