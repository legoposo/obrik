<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkStage extends Model
{
    protected $fillable = [
        'work_id',
        'name',
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

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }
}
