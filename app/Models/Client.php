<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'cpf',
        'rg',
        'birth_date',
        'address',
        'city',
        'state',
        'zip_code',
    ];

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
