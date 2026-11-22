<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spot extends Model
{
    // 利用シーンの固定選択肢
    public const SCENES = ['家族', 'カップル', '友達', 'ひとり'];

    protected $fillable = [
        'name',
        'category',
        'area',
        'description',
        'address',
        'latitude',
        'longitude',
        'image_path',
        'image_path_2',
        'scene',
        'business_hours',
        'closed_days',
        'phone',
        'parking',
        'website_url',
    ];

    // お気に入りとの紐づけ
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    // 利用シーンとの紐づけ（複数）
    public function sceneSpots(): HasMany
    {
        return $this->hasMany(SceneSpot::class);
    }

    // 表示用。scene_spot が空の既存データだけ spots.scene を使う
    public function sceneNames(): array
    {
        $stored = $this->sceneSpots->pluck('scene');

        if ($stored->isEmpty() && filled($this->scene)) {
            $stored = collect([$this->scene]);
        }

        return array_values(array_intersect(self::SCENES, $stored->all()));
    }

    // 選択された利用シーンを重複なく同期する
    public function syncScenes(array $scenes): void
    {
        $scenes = array_values(array_unique(array_intersect(self::SCENES, $scenes)));

        // 選択解除されたシーンを削除
        $this->sceneSpots()->whereNotIn('scene', $scenes)->delete();

        // 既存のシーンを取得
        $existing = $this->sceneSpots()->pluck('scene')->all();

        // 新しいシーンだけ追加
        foreach (array_diff($scenes, $existing) as $scene) {
            $this->sceneSpots()->create(['scene' => $scene]);
        }
    }

    // 選択シーンのいずれかに一致するスポットを検索
    // scene_spot 優先。未移行データは spots.scene を使用
    public function scopeMatchingScenes($query, array $scenes)
    {
        $scenes = array_values(array_intersect(self::SCENES, $scenes));

        if ($scenes === []) {
            return $query;
        }

        return $query->where(function ($q) use ($scenes) {
            $q->whereHas('sceneSpots', fn ($sq) => $sq->whereIn('scene', $scenes))
                ->orWhere(function ($legacy) use ($scenes) {
                    $legacy->whereDoesntHave('sceneSpots')
                        ->whereIn('scene', $scenes);
                });
        });
    }

    // 1枚目の画像URL
    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : asset('images/no-image.jpg');
    }

    // 2枚目がなければ null
    public function getImageUrl2Attribute(): ?string
    {
        return $this->image_path_2
            ? asset('storage/' . $this->image_path_2)
            : null;
    }
}
