<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'spot_id',
        'rating',
        'body',
    ];

    // 投稿したユーザー
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 口コミの対象のスポット
    public function spot(): BelongsTo
    {
        return $this->belongsTo(Spot::class);
    }
}