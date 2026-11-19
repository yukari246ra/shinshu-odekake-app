<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SceneSpot extends Model
{
    // 使用するテーブル名
    protected $table = 'scene_spot';

    // 登録・更新を許可するカラム
    protected $fillable = [
        'spot_id',
        'scene',
    ];

    // スポットとの紐づけ
    public function spot(): BelongsTo
    {
        return $this->belongsTo(Spot::class);
    }
}