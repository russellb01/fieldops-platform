<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estimate extends Model
{
    protected $table = 'fieldops_estimates';

    protected $fillable = [
        'estimate_number',
        'customer_id',
        'service_location_id',
        'title',
        'status',
        'issue_summary',
        'scope_of_work',
        'subtotal',
        'tax',
        'total',
        'valid_until',
        'sent_at',
        'approved_at',
    ];

    protected $casts = [
        'valid_until' => 'date',
        'sent_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceLocation(): BelongsTo
    {
        return $this->belongsTo(ServiceLocation::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(EstimateItem::class);
    }
}
