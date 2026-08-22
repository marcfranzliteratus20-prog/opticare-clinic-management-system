<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = trim((string) $request->search);

        $appointments = Appointment::with('patient')
            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('doctor_name', 'like', "%{$search}%")

                        ->orWhere('status', 'like', "%{$search}%")

                        ->orWhere('type', 'like', "%{$search}%")

                        ->orWhere('source', 'like', "%{$search}%")

                        ->orWhereHas('patient', function ($pq) use ($search) {

                            $pq->where(
                                'full_name',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'contact_number',
                                'like',
                                "%{$search}%"
                            )

                            ->orWhere(
                                'address',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })
            ->latest('appointment_date')
            ->latest('appointment_time')
            ->paginate(10)
            ->withQueryString();

        return view(
            'appointments.index',
            compact(
                'appointments',
                'search'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $patients = Patient::orderBy('full_name')->get();

        return view(
            'appointments.create',
            compact('patients')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'patient_id' => [
                'required',
                'exists:patients,id',
            ],

            'appointment_date' => [
                'required',
                'date',
            ],

            'appointment_time' => [
                'required',
            ],

            'doctor_name' => [
                'required',
                'string',
                'max:100',
            ],

            'type' => [
                'required',
                'in:Comprehensive Eye Examination,Prescription Eyeglasses,Contact Lens Fitting and Assessment,Ishihara Color Vision Test,Eye Condition Certification,Eyewear Accessories,Eyewear Repair and Maintenance,Frame Fitting,Other',
            ],

            'status' => [
                'nullable',
                'in:Pending,Approved,Completed,Cancelled',
            ],

            'message' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);


        Appointment::create([

            'patient_id' =>
                $validated['patient_id'],

            'appointment_date' =>
                $validated['appointment_date'],

            'appointment_time' =>
                $validated['appointment_time'],

            'doctor_name' =>
                $validated['doctor_name'],

            'type' =>
                $validated['type'],

            'status' =>
                $validated['status'] ?? 'Pending',

            'source' =>
                'Walk-in',

            'message' =>
                $validated['message'] ?? null,
        ]);


        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment added successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('full_name')->get();

        return view(
            'appointments.edit',
            compact(
                'appointment',
                'patients'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Appointment $appointment
    ) {

        $validated = $request->validate([

            'patient_id' => [
                'required',
                'exists:patients,id',
            ],

            'appointment_date' => [
                'required',
                'date',
            ],

            'appointment_time' => [
                'required',
            ],

            'doctor_name' => [
                'required',
                'string',
                'max:100',
            ],

            'type' => [
                'required',
                'in:Comprehensive Eye Examination,Prescription Eyeglasses,Contact Lens Fitting and Assessment,Ishihara Color Vision Test,Eye Condition Certification,Eyewear Accessories,Eyewear Repair and Maintenance,Frame Fitting,Other',
            ],

            'status' => [
                'required',
                'in:Pending,Approved,Completed,Cancelled',
            ],

            'message' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);


        $appointment->update([

            'patient_id' =>
                $validated['patient_id'],

            'appointment_date' =>
                $validated['appointment_date'],

            'appointment_time' =>
                $validated['appointment_time'],

            'doctor_name' =>
                $validated['doctor_name'],

            'type' =>
                $validated['type'],

            'status' =>
                $validated['status'],

            'message' =>
                $validated['message'] ?? null,
        ]);


        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */

    public function approve(Appointment $appointment)
    {
        if ($appointment->status !== 'Pending') {

            return redirect()
                ->route('appointments.index')
                ->with(
                    'error',
                    'Only pending appointments can be approved.'
                );
        }


        $appointment->update([

            'status' => 'Approved',

            'message' =>
                'Your appointment has been approved. Please come to the clinic on your scheduled date and time.',
        ]);


        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment approved successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */

    public function reject(
        Request $request,
        Appointment $appointment
    ) {

        $validated = $request->validate([

            'message' => [
                'required',
                'string',
                'max:500',
            ],

        ]);


        if ($appointment->status !== 'Pending') {

            return redirect()
                ->route('appointments.index')
                ->with(
                    'error',
                    'Only pending appointments can be rejected.'
                );
        }


        $appointment->update([

            'status' => 'Cancelled',

            'message' =>
                $validated['message'],
        ]);


        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment rejected successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPLETE
    |--------------------------------------------------------------------------
    */

    public function complete(Appointment $appointment)
    {
        if ($appointment->status !== 'Approved') {

            return redirect()
                ->route('appointments.index')
                ->with(
                    'error',
                    'Only approved appointments can be marked as completed.'
                );
        }


        $appointment->update([

            'status' => 'Completed',

            'message' =>
                'Your appointment has been completed successfully.',
        ]);


        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment marked as completed.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with(
                'success',
                'Appointment deleted successfully.'
            );
    }
}