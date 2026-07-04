<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentAsset extends Model
{
    protected $table = 'fieldops_equipment_assets';

    protected $fillable = [
        'customer_id',
        'service_location_id',
        'asset_type',
        'name',
        'brand',
        'model',
        'serial_number',
        'install_date',
        'warranty_expires_at',
        'refrigerant_type',
        'filter_size',
        'belt_size',
        'voltage',
        'phase',
        'status',
        'notes',
    ];

    protected $casts = [
        'install_date' => 'date',
        'warranty_expires_at' => 'date',
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
