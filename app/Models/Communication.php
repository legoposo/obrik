<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Communication extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'development_id',
        'title',
        'message',
        'type',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }
}
