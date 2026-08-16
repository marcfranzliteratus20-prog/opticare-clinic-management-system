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
         'location',
        'status',
        'message',
        'source',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    /**
     * Appointment belongs to a patient.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}