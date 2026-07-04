<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $table = 'fieldops_invoice_items';

    protected $fillable = [
        'invoice_id',
        'line_type',
        'description',
        'quantity',
        'unit_price',
        'total',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
