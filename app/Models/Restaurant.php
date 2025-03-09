<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    // Since the id is manually set, disable auto-increment.
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'id', // manual input for restaurant id
        'name',
        'average_rating',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
