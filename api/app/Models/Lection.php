<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image'
    ];

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
