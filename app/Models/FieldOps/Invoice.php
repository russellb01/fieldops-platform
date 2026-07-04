<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    protected $table = 'fieldops_invoices';

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'service_location_id',
        'estimate_id',
        'title',
        'status',
        'service_date',
        'due_date',
        'subtotal',
        'tax',
        'total',
        'amount_paid',
        'balance',
        'notes',
    ];

    protected $casts = [
        'service_date' => 'date',
        'due_date' => 'date',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function serviceLocation(): BelongsTo
    {
        return $this->belongsTo(ServiceLocation::class);
    }

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(Estimate::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
