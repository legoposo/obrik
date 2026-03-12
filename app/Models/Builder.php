<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Builder extends Model
{
    protected $fillable = [
        'name',
        'cnpj',
        'email',
        'phone',
        'city',
        'state',
        'address',
        'responsible',
    ];

    public function developments(): HasMany
    {
        return $this->hasMany(Development::class);
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'construtora_id');
    }
}
