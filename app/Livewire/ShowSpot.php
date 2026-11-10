<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Models\Spot;
use Livewire\Component;

class ShowSpot extends Component
{
    public Spot $spot;

    public function mount(Spot $spot)
    {
        $this->spot = $spot;
    }

    // 下の「関連スポット」のカードのハート用
    public function toggleFavorite(int $spotId): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);
            return;
        }

        $deleted = Favorite::where('user_id', auth()->id())
            ->where('spot_id', $spotId)
            ->delete();

        if (! $deleted) {
            Favorite::create(['user_id' => auth()->id(), 'spot_id' => $spotId]);
        }
    }

    public function render()
    {
        // 同じエリアのスポット（自分自身は除く・人気順）
        $sameArea = $this->spot->area
            ? Spot::query()
                ->withCount('favorites')
                ->where('id', '!=', $this->spot->id)
                ->where('area', $this->spot->area)
                ->orderByDesc('favorites_count')
                ->latest()
                ->limit(4)
                ->get()
            : collect();

        // 同じカテゴリのスポット
        $sameCategory = $this->spot->category
            ? Spot::query()
                ->withCount('favorites')
                ->where('id', '!=', $this->spot->id)
                ->where('category', $this->spot->category)
                ->orderByDesc('favorites_count')
                ->latest()
                ->limit(4)
                ->get()
            : collect();

        $favoriteIds = auth()->check()
            ? Favorite::where('user_id', auth()->id())->pluck('spot_id')->all()
            : [];

        return view('livewire.show-spot', compact('sameArea', 'sameCategory', 'favoriteIds'))
            ->title($this->spot->name . ' | 信州おでかけアプリ');
    }
}