<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'construtora_id',
        'name',
        'email',
        'phone',
        'cpf',
        'rg',
        'document',
        'birth_date',
        'address',
        'city',
        'state',
        'zip_code',
        'notes',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function builder(): BelongsTo
    {
        return $this->belongsTo(Builder::class, 'construtora_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }

    public function developments(): BelongsToMany
    {
        return $this->belongsToMany(Development::class, 'contracts')
            ->withPivot(['id', 'unit_id', 'status', 'value', 'contract_date', 'notes'])
            ->withTimestamps();
    }
}
