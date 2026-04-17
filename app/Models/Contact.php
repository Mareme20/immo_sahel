<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'type',
        'preferred_channel',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function ownedProperties()
    {
        return $this->hasMany(Property::class, 'owner_contact_id');
    }

    public function tenancyProperties()
    {
        return $this->hasMany(Property::class, 'tenant_contact_id');
    }

    public function inquiries()
    {
        return $this->hasMany(PropertyInquiry::class);
    }

    public function rentPayments()
    {
        return $this->hasMany(RentPayment::class, 'tenant_contact_id');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}
