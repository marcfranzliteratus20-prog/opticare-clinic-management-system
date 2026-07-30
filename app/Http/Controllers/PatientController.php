<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->search);

        $patients = Patient::when($search !== '', function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        })->paginate(5)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|in:Male,Female,Other',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'eye_grade' => 'nullable|string|max:50',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')
                         ->with('success', 'Patient added successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'age' => 'required|integer|min:0|max:120',
            'gender' => 'required|in:Male,Female,Other',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string',
            'eye_grade' => 'nullable|string|max:50',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')
                         ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
                         ->with('success', 'Patient deleted successfully.');
    }
}