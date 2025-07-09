<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tel_no',
        'second_address',
        'fax_no',
    ];

    /**
     * Get the user that owns the pharmacy details.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
