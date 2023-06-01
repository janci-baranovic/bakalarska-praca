<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;

    protected $table = 'video';
    public $timestamps = false;

    protected $fillable = [
        'youtubeVideoId',
        'lection_id'
    ];

    public function lection(): BelongsTo
    {
        return $this->belongsTo(Lection::class);
    }
}
