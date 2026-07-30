<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Inventory;
use App\Models\Billing;
use App\Models\Appointment;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->search);

        // If search is empty, don't run any queries -- avoids the
        // "LIKE '%%'" bug where every record matches.
        if ($search === '') {
            return view('search.index', [
                'search' => $search,
                'patients' => collect(),
                'inventories' => collect(),
                'billings' => collect(),
                'appointments' => collect(),
            ]);
        }

        // FIX: wrap each field pair in a closure so the OR conditions
        // stay grouped together and don't leak into unrelated queries.
        $patients = Patient::where(function ($query) use ($search) {
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
        })->get();

        $inventories = Inventory::where(function ($query) use ($search) {
            $query->where('product_name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        })->get();

        $billings = Billing::with('patient')
            ->where(function ($query) use ($search) {
                $query->where('service_type', 'like', "%{$search}%")
                      ->orWhere('payment_status', 'like', "%{$search}%");
            })->get();

        $appointments = Appointment::with('patient')
            ->where(function ($query) use ($search) {
                $query->where('doctor_name', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
            })->get();

        return view('search.index', compact(
            'search',
            'patients',
            'inventories',
            'billings',
            'appointments'
        ));
    }
}