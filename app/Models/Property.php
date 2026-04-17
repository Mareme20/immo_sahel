<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'owner_contact_id',
        'tenant_contact_id',
        'title',
        'slug',
        'description',
        'price',
        'location',
        'address_line',
        'city',
        'district',
        'latitude',
        'longitude',
        'type',
        'status',
        'area',
        'rooms',
        'bathrooms',
        'parking_spaces',
        'featured',
        'is_published',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    // Valeur par défaut pour is_published
    protected $attributes = [
        'is_published' => true,
    ];

    protected $casts = [
        'featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ownerContact()
    {
        return $this->belongsTo(Contact::class, 'owner_contact_id');
    }

    public function tenantContact()
    {
        return $this->belongsTo(Contact::class, 'tenant_contact_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function mainImage()
    {
        // Retourne l'image principale ou la première image de la liste
        return $this->hasOne(PropertyImage::class)->orderBy('is_main', 'desc')->orderBy('sort_order', 'asc');
    }

    public function inquiries()
    {
        return $this->hasMany(PropertyInquiry::class)->latest();
    }

    public function rentPayments()
    {
        return $this->hasMany(RentPayment::class)->latest('due_date');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class)->latest();
    }
}
