<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceLocation extends Model
{
    protected $table = 'fieldops_service_locations';

    protected $fillable = [
        'customer_id',
        'location_name',
        'address',
        'city',
        'state',
        'postal_code',
        'latitude',
        'longitude',
        'access_notes',
        'site_notes',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function equipmentAssets(): HasMany
    {
        return $this->hasMany(EquipmentAsset::class);
    }
}
