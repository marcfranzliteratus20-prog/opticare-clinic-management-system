<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        return view('public.book-appointment');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|in:Male,Female,Other',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',

            'type' => [
                'required',
                'in:Comprehensive Eye Examination,Prescription Eyeglasses,Contact Lens Fitting and Assessment,Ishihara Color Vision Test,Eye Condition Certification,Eyewear Accessories,Eyewear Repair and Maintenance,Other',
            ],

            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        /*
        |--------------------------------------------------------------------------
        | FIND OR CREATE PATIENT
        |--------------------------------------------------------------------------
        */

        $patient = Patient::updateOrCreate(
            [
                'contact_number' => $validated['contact_number'],
            ],
            [
                'full_name' => $validated['full_name'],
                'age' => $validated['age'],
                'gender' => $validated['gender'],
                'address' => $validated['address'],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | CREATE APPOINTMENT
        |--------------------------------------------------------------------------
        */

        $appointment = Appointment::create([
            'patient_id' => $patient->id,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'doctor_name' => 'To be assigned',
            'type' => $validated['type'],
            'status' => 'Pending',
            'source' => 'Online',
        ]);

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('booking.create')
            ->with(
                'success',
                'Your appointment request has been submitted! Our staff will contact you at '
                . $validated['contact_number']
                . ' to confirm your schedule.'
            );
    }

    public function showStatusForm()
    {
        return view('public.check-status');
    }

    public function checkStatus(Request $request)
    {
        $validated = $request->validate([
            'contact_number' => 'required|string|max:20',
        ]);

        $patient = Patient::where(
            'contact_number',
            $validated['contact_number']
        )->first();

        $appointments = $patient
            ? $patient->appointments()
                ->latest('appointment_date')
                ->latest('appointment_time')
                ->get()
            : collect();

        return view('public.check-status', [
            'searched' => true,
            'contact_number' => $validated['contact_number'],
            'appointments' => $appointments,
        ]);
    }
}