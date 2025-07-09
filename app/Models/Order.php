<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'health_history',
        'weight_management_history',
        'medication_requests',
        'add_ons',
        'shipping_options',
        'consent',
        'payment_details',
    ];

    protected $casts = [
        'health_history' => 'array',
        'weight_management_history' => 'array',
        'medication_requests' => 'string', // Changed to string since it's a single value
        'add_ons' => 'array',
        'shipping_options' => 'array',
        'consent' => 'array',
        'payment_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
