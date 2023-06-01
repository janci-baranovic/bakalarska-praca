<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $table = 'test';

    protected $fillable = [
        'title'
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function userAnswers(): hasMany
    {
        return $this->hasMany(UserAnswer::class);
    }
}
