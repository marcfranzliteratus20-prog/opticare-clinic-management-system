<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'age',
        'gender',
        'contact_number',
        'address',
        'eye_grade',
    ];

    // One patient can have many appointments
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // Added: one patient can have many billing records --
    // useful for a patient detail page or reports later.
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}