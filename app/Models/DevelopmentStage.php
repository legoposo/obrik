<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DevelopmentStage extends Model
{
    protected $fillable = [
        'development_id',
        'stage_name',
        'status',
        'start_date',
        'expected_date',
        'finished_date',
        'responsible',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_date' => 'date',
        'finished_date' => 'date',
    ];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }
}
