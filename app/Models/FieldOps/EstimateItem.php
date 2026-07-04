<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EstimateItem extends Model
{
    protected $table = 'fieldops_estimate_items';

    protected $fillable = [
        'estimate_id',
        'line_type',
        'description',
        'quantity',
        'unit_price',
        'total',
    ];

    public function estimate(): BelongsTo
    {
        return $this->belongsTo(Estimate::class);
    }
}
