<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Show all appointments
    public function index(Request $request)
    {
        $search = trim((string) $request->search);

        $appointments = Appointment::with('patient')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('doctor_name', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhereHas('patient', function ($pq) use ($search) {
                          $pq->where('full_name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest('appointment_date')
            ->paginate(5)
            ->withQueryString();

        return view('appointments.index', compact('appointments', 'search'));
    }

    // Show create form
    public function create()
    {
        $patients = Patient::all();
        return view('appointments.create', compact('patients'));
    }

    // Save new appointment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'doctor_name' => 'required|string|max:100',
            'type' => 'nullable|in:New Checkup,Follow-up,Frame Fitting,Contact Lens Fitting',
        ]);

        Appointment::create([
            ...$validated,
            'type' => $validated['type'] ?? 'New Checkup',
            'status' => 'Pending',
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment added successfully.');
    }

    // Show edit form -- FIX: use route model binding, consistent with the rest
    public function edit(Appointment $appointment)
    {
        $patients = Patient::all();

        return view('appointments.edit', compact('appointment', 'patients'));
    }

    // Update appointment
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'doctor_name' => 'required|string|max:100',
            'type' => 'nullable|in:New Checkup,Follow-up,Frame Fitting,Contact Lens Fitting',
            'status' => 'nullable|in:Pending,Completed,Cancelled',
        ]);

        $appointment->update([
            ...$validated,
            'type' => $validated['type'] ?? $appointment->type,
            'status' => $validated['status'] ?? $appointment->status,
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    // Delete appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    public function complete(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'Completed',
        ]);

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment marked as completed.');
    }
}