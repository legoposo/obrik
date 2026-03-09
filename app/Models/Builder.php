<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
