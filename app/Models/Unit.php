<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'development_id',
        'identifier',
        'block',
        'floor',
        'private_area',
        'total_area',
        'block_or_tower',
        'unit_number',
        'type',
        'area',
        'bedrooms',
        'parking_spaces',
        'price',
        'status',
        'notes',
    ];

    protected $casts = [
        'private_area' => 'decimal:2',
        'total_area' => 'decimal:2',
        'area' => 'decimal:2',
        'price' => 'decimal:2',
        'bedrooms' => 'integer',
        'parking_spaces' => 'integer',
    ];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
