<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Spot extends Model
{
    protected $fillable = [
        'name',
        'category',
        'area',
        'description',
        'address',
        'image_path',
        'image_path_2',
        'scene',
        'business_hours',
        'closed_days',
        'phone',
        'parking',
        'website_url',
    ];

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

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