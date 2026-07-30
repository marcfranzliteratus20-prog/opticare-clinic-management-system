<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'appointment_date',
        'appointment_time',
        'doctor_name',
        'type',
        'status',
        'source'
    ];

    // Each appointment belongs to one patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}