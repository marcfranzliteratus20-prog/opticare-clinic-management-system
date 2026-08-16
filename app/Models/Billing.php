<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use SoftDeletes;

    /**
     * `payment_status` is the canonical payment status field ('Paid' / 'Unpaid').
     *
     * The database also has a legacy `status` column (re-added by migration 2026_08_08)
     * that is never read or written by any application code. It always stays on its
     * default value 'Unpaid'. Do NOT add `status` to $fillable or use it in queries.
     * All billing payment logic must use `payment_status`.
     */
    protected $fillable = [
        'patient_id',
        'amount',
        'service_type',
        'warranty_months',
        'warranty_expiry',
        'payment_status',
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