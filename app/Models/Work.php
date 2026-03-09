<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
