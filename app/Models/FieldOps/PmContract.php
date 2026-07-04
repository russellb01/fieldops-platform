<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PmContract extends Model
{
    protected $table = 'fieldops_pm_contracts';

    protected $fillable = [
        'contract_number',
        'customer_id',
        'service_location_id',
        'title',
        'status',
        'frequency',
        'start_date',
        'end_date',
        'next_service_date',
        'monthly_price',
        'annual_value',
        'scope',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'next_service_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceLocation(): BelongsTo
    {
        return $this->belongsTo(ServiceLocation::class);
    }
}
