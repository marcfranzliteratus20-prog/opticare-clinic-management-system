<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Patient;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->search);

        $billings = Billing::with('patient')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('service_type', 'like', "%{$search}%")
                      ->orWhere('payment_status', 'like', "%{$search}%")
                      ->orWhereHas('patient', function ($pq) use ($search) {
                          $pq->where('full_name', 'like', "%{$search}%");
                      });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('billing.index', compact('billings', 'search'));
    }

    public function create()
    {
        $patients = Patient::all();

        return view('billing.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'service_type' => 'required|string|max:100',
            'warranty_months' => 'nullable|integer|min:0|max:60',
            'payment_status' => 'required|in:Paid,Unpaid',
        ]);

        // If a warranty period was given, compute its expiry date from today
        // (the date of sale/service) so staff don't have to calculate it manually.
        // NOTE: cast to (int) -- form values are always strings even after
        // 'integer' validation, and Carbon's addMonths() requires a real int.
        $validated['warranty_expiry'] = !empty($validated['warranty_months'])
            ? now()->addMonths((int) $validated['warranty_months'])->toDateString()
            : null;

        Billing::create($validated);

        return redirect()
            ->route('billing.index')
            ->with('success', 'Billing record created successfully.');
    }

    public function edit(Billing $billing)
    {
        $patients = Patient::all();

        return view('billing.edit', compact('billing', 'patients'));
    }

    public function update(Request $request, Billing $billing)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'amount' => 'required|numeric|min:0',
            'service_type' => 'required|string|max:100',
            'warranty_months' => 'nullable|integer|min:0|max:60',
            'payment_status' => 'required|in:Paid,Unpaid',
        ]);

        // Recompute from the original billing date (not today) so editing a
        // record later doesn't shift the warranty coverage period.
        // NOTE: cast to (int) -- form values are always strings even after
        // 'integer' validation, and Carbon's addMonths() requires a real int.
        $validated['warranty_expiry'] = !empty($validated['warranty_months'])
            ? $billing->created_at->copy()->addMonths((int) $validated['warranty_months'])->toDateString()
            : null;

        $billing->update($validated);

        return redirect()
            ->route('billing.index')
            ->with('success', 'Billing updated successfully.');
    }

    public function markPaid(Billing $billing)
    {
        $billing->update([
            'payment_status' => 'Paid',
        ]);

        return redirect()
            ->route('billing.index')
            ->with('success', 'Billing marked as paid.');
    }

    public function destroy(Billing $billing)
    {
        $billing->delete();

        return redirect()
            ->route('billing.index')
            ->with('success', 'Billing deleted successfully.');
    }

    public function receipt(Billing $billing)
    {
        $billing->load('patient');

        return view('billing.receipt', compact('billing'));
    }
}