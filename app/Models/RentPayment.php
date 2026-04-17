<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'tenant_contact_id',
        'amount',
        'due_date',
        'paid_date',
        'status',
        'period_label',
        'reference',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenantContact()
    {
        return $this->belongsTo(Contact::class, 'tenant_contact_id');
    }
}
