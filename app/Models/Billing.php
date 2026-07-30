<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'amount',
        'service_type',
        'warranty_months',
        'warranty_expiry',
        'payment_status'
    ];

    protected $casts = [
        'warranty_expiry' => 'date',
    ];

    // FIX: this was missing -- without it, views can't show the patient's
    // name and have to fall back to showing the raw patient_id.
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}