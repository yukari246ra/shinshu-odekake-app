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
    ];
}
