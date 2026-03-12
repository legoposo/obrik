<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Work extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'start_date',
        'expected_end_date',
        'status',
        'budget',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(WorkStage::class);
    }
}
