<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Spot;

class SearchSpots extends Component
{
    public $scene = '';
    public $area = '';
    public $category = '';

    // ▼ 条件をすべてクリアする
    public function resetFilters()
    {
        $this->scene = '';
        $this->area = '';
        $this->category = '';
    }

    // ▼ カード上のハートでお気に入りを切り替える
    public function toggleFavorite(int $spotId)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

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
        // ▼ 条件が1つでも選ばれているか
        $hasFilter = $this->scene !== '' || $this->area !== '' || $this->category !== '';

        $results = collect();

        if ($hasFilter) {
            $results = Spot::query()
                ->withCount('favorites')
                ->when($this->scene !== '', fn($q) => $q->where('scene', $this->scene))
                ->when($this->area !== '', fn($q) => $q->where('area', $this->area))
                ->when($this->category !== '', fn($q) => $q->where('category', $this->category))
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // ▼ ログイン中ユーザーのお気に入り済みスポットID
        $favoriteIds = Auth::check()
            ? \App\Models\Favorite::where('user_id', Auth::id())->pluck('spot_id')->all()
            : [];

        return view('livewire.search-spots', [
            'results' => $results,
            'hasFilter' => $hasFilter,
            'favoriteIds' => $favoriteIds,
        ])->title('絞り込み検索 | 信州おでかけアプリ');
    }
}