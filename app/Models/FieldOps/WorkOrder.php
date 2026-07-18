<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model
{
    protected $table = 'fieldops_work_orders';

    protected $fillable = [
        'work_order_number', 'customer_id', 'service_location_id', 'equipment_asset_id',
        'estimate_id', 'title', 'status', 'priority', 'service_type', 'assigned_to',
        'scheduled_start', 'scheduled_end', 'customer_request', 'diagnosis',
        'work_performed', 'internal_notes', 'completed_at',
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function serviceLocation(): BelongsTo { return $this->belongsTo(ServiceLocation::class); }
    public function equipmentAsset(): BelongsTo { return $this->belongsTo(EquipmentAsset::class); }
    public function estimate(): BelongsTo { return $this->belongsTo(Estimate::class); }
}
