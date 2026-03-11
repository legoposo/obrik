<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'development_id',
        'identifier',
        'type',
        'block',
        'floor',
        'private_area',
        'total_area',
        'price',
        'status',
        'notes',
    ];

    protected $casts = [
        'private_area' => 'decimal:2',
        'total_area' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function development()
    {
        return $this->belongsTo(Development::class);
    }
}
