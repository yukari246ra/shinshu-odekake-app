<?php

namespace App\Livewire;

use App\Models\Favorite;
use App\Models\Spot;
use Livewire\Attributes\Url;
use Livewire\Component;

class Home extends Component
{
    #[Url(as: 'category', except: '')]
    public string $category = '';

    #[Url(as: 'area', except: '')]
    public string $area = '';

    public string $keyword = '';

    public array $categories = [
        'レストラン'   => '🍴',
        'カフェ'       => '☕',
        '公園'         => '🌳',
        '観光地'       => '🏯',
        'ショッピング' => '🛍️',
        '温泉'         => '♨️',
    ];

    public array $areas = ['北信', '中信', '東信', '南信'];

    public function selectCategory(string $name): void
    {
        $this->category = $this->category === $name ? '' : $name;
    }

    public function selectArea(string $name): void
    {
        $this->area = $this->area === $name ? '' : $name;
    }

    public function resetFilters(): void
    {
        $this->reset(['category', 'area', 'keyword']);
    }

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

    private function filtered()
    {
        return Spot::query()
            ->when($this->category !== '', fn ($q) => $q->where('category', $this->category))
            ->when($this->area !== '', fn ($q) => $q->where('area', $this->area))
            ->when($this->keyword !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->keyword}%")
                      ->orWhere('description', 'like', "%{$this->keyword}%")
                      ->orWhere('address', 'like', "%{$this->keyword}%");
                });
            });
    }

    public function render()
    {
        $recommended = $this->filtered()
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->latest()
            ->limit(8)
            ->get();

        $latest = $this->filtered()
            ->withCount('favorites')
            ->latest()
            ->limit(6)
            ->get();

        $favoriteIds = auth()->check()
            ? Favorite::where('user_id', auth()->id())->pluck('spot_id')->all()
            : [];

        return view('livewire.home', compact('recommended', 'latest', 'favoriteIds'))
            ->title('信州おでかけアプリ');
    }
}