<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Development extends Model
{
    use HasFactory;

    protected $fillable = [
        'builder_id',
        'name',
        'type',
        'description',
        'location',
        'address',
        'city',
        'state',
        'status',
        'launch_date',
        'start_date',
        'expected_delivery',
        'expected_delivery_date',
        'notes',
    ];

    protected $casts = [
        'launch_date' => 'date',
        'start_date' => 'date',
        'expected_delivery' => 'date',
        'expected_delivery_date' => 'date',
    ];

    public function builder(): BelongsTo
    {
        return $this->belongsTo(Builder::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'contracts')
            ->withPivot(['id', 'unit_id', 'status', 'value', 'contract_date', 'notes'])
            ->withTimestamps();
    }

    public function stages(): HasMany
    {
        return $this->hasMany(DevelopmentStage::class);
    }

    public function communications(): HasMany
    {
        return $this->hasMany(Communication::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(DevelopmentPhoto::class);
    }
}
