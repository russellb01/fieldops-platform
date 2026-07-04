<?php

namespace App\Models\FieldOps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'fieldops_customers';

    protected $fillable = [
        'customer_type',
        'company_name',
        'first_name',
        'last_name',
        'display_name',
        'email',
        'phone',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'status',
        'notes',
    ];

    public function locations(): HasMany
    {
        return $this->hasMany(ServiceLocation::class);
    }

    public function equipmentAssets(): HasMany
    {
        return $this->hasMany(EquipmentAsset::class);
    }

    public function estimates(): HasMany
    {
        return $this->hasMany(Estimate::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function pmContracts(): HasMany
    {
        return $this->hasMany(PmContract::class);
    }
}
