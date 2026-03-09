<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
