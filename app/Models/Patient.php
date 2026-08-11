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

    public function appointments()
    {
        return $this->hasMany(
            Appointment::class
        );
    }

    public function billings()
    {
        return $this->hasMany(
            Billing::class
        );
    }
}