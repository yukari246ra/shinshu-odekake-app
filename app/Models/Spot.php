<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    protected $fillable = [
        'name',
        'category',
        'area',
        'description',
        'address',
        'image_path',
        'scene',

        // ▼ 追加項目（保存されるように必須）
        'business_hours',
        'closed_days',
        'phone',
        'parking',
        'website_url',
    ];
}
