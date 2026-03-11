<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'development_id',
        'unit_id',
        'client_id',
        'contract_number',
        'sale_date',
        'contract_date',
        'unit_price',
        'discount',
        'negotiated_value',
        'down_payment',
        'financed_amount',
        'installments_count',
        'status',
        'notes',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'contract_date' => 'date',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'negotiated_value' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'financed_amount' => 'decimal:2',
        'installments_count' => 'integer',
    ];

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function shouldSyncUnitStatus(): bool
    {
        return in_array($this->status, ['ativo', 'assinado', 'concluido'], true);
    }
}
