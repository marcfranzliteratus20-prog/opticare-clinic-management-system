<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Inventory;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    private function modelFor(string $type): string
    {
        return match ($type) {
            'patients' => Patient::class,
            'appointments' => Appointment::class,
            'billings' => Billing::class,
            'inventory' => Inventory::class,
            default => abort(404, 'Unknown archive type.'),
        };
    }

    public function index()
    {
        $patients = Patient::onlyTrashed()->latest('deleted_at')->get();

        $appointments = Appointment::onlyTrashed()
            ->with('patient')
            ->latest('deleted_at')
            ->get();

        $billings = Billing::onlyTrashed()
            ->with('patient')
            ->latest('deleted_at')
            ->get();

        $inventory = Inventory::onlyTrashed()->latest('deleted_at')->get();

        return view('archive.index', compact('patients', 'appointments', 'billings', 'inventory'));
    }

    public function restore(string $type, int $id)
    {
        $modelClass = $this->modelFor($type);
        $record = $modelClass::onlyTrashed()->findOrFail($id);
        $record->restore();

        return back()->with('success', 'Record restored successfully.');
    }

    public function forceDelete(string $type, int $id)
    {
        $modelClass = $this->modelFor($type);
        $record = $modelClass::onlyTrashed()->findOrFail($id);

        // Inventory items may have an image file on disk -- clean it up
        // now, since this is the point of no return for this record.
        if ($type === 'inventory' && $record->image) {
            Storage::disk('public')->delete($record->image);
        }

        $record->forceDelete();

        return back()->with('success', 'Record permanently deleted. This cannot be undone.');
    }
}