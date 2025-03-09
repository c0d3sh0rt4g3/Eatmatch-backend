<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'reviewer_id',
        'rating',
        'title',
        'body',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
