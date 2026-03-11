<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Development extends Model
{
    use HasFactory;

    protected $fillable = [
        'builder_id',
        'name',
        'type',
        'city',
        'state',
        'address',
        'start_date',
        'expected_delivery_date',
        'status',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_delivery_date' => 'date',
    ];

    public function builder()
    {
        return $this->belongsTo(Builder::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}
