<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'contact_id',
        'name',
        'email',
        'phone',
        'preferred_contact',
        'preferred_visit_date',
        'budget',
        'status',
        'source',
        'message',
    ];

    protected $casts = [
        'preferred_visit_date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
