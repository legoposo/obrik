<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevelopmentPhoto extends Model
{
    protected $fillable = [
        'development_id',
        'title',
        'description',
        'date',
        'image_path',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }
}
