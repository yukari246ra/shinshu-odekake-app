<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Spot;

class SpotList extends Component
{
    use WithPagination;

    public $search = '';
    public array $scenes = [];
    public $area = '';
    public $category = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedScenes()
    {
        $this->resetPage();
    }

    public function updatedArea()
    {
        $this->resetPage();
    }

    public function updatedCategory()
    {
        $this->resetPage();
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
        $spots = Spot::query()
            ->with('sceneSpots')
            ->withCount('favorites')
            ->when($this->search, function ($query) {
                $keyword = '%' . $this->search . '%';

                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', $keyword)
                        ->orWhere('description', 'like', $keyword)
                        ->orWhere('address', 'like', $keyword)
                        ->orWhere('area', 'like', $keyword)
                        ->orWhere('category', 'like', $keyword)
                        ->orWhereHas('sceneSpots', fn ($sq) => $sq->where('scene', 'like', $keyword))
                        ->orWhere(function ($legacy) use ($keyword) {
                            $legacy->whereDoesntHave('sceneSpots')
                                ->where('scene', 'like', $keyword);
                        });
                });
            })
            ->matchingScenes($this->scenes)
            ->when($this->area !== '', fn($q) => $q->where('area', $this->area))
            ->when($this->category !== '', fn($q) => $q->where('category', $this->category))
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // ▼ ログイン中ユーザーのお気に入り済みスポットID
        $favoriteIds = Auth::check()
            ? \App\Models\Favorite::where('user_id', Auth::id())->pluck('spot_id')->all()
            : [];

        return view('livewire.spot-list', [
            'spots' => $spots,
            'favoriteIds' => $favoriteIds,
        ])->title('スポット一覧 | 信州おでかけアプリ');
    }
}