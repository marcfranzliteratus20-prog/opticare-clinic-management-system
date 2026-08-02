<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Get database-specific month format.
     */
    private function monthFormat(): string
    {
        return DB::connection()->getDriverName() === 'pgsql'
            ? "TO_CHAR(created_at, 'YYYY-MM')"
            : "DATE_FORMAT(created_at, '%Y-%m')";
    }

    /**
     * Build report data.
     */
    private function buildReportData(): array
    {
        $month = $this->monthFormat();

        $totalRevenue = Billing::where('payment_status', 'Paid')->sum('amount');
        $totalUnpaid = Billing::where('payment_status', 'Unpaid')->sum('amount');

        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $completedAppointments = Appointment::where('status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('status', 'Cancelled')->count();

        $inventoryValuation = Inventory::selectRaw('SUM(quantity * price) as total')->value('total') ?? 0;

        $lowStockCount = Inventory::whereColumn('quantity', '<=', 'reorder_level')->count();

        $monthlyRevenue = Billing::where('payment_status', 'Paid')
            ->selectRaw("$month as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderByDesc('month')
            ->limit(12)
            ->get();

        $monthlyPatients = Patient::selectRaw("$month as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderByDesc('month')
            ->limit(12)
            ->get();

        $topServices = Billing::selectRaw("
                service_type,
                COUNT(*) as total,
                SUM(amount) as revenue
            ")
            ->groupBy('service_type')
            ->orderByDesc('total')
            ->get();

        return compact(
            'totalRevenue',
            'totalUnpaid',
            'totalPatients',
            'totalAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'inventoryValuation',
            'lowStockCount',
            'monthlyRevenue',
            'monthlyPatients',
            'topServices'
        );
    }

    /**
     * Show Reports page.
     */
    public function index()
    {
        return view('reports.index', $this->buildReportData());
    }

    /**
     * Export PDF.
     */
    public function exportPdf()
    {
        $data = $this->buildReportData();

        $pdf = Pdf::loadView('reports.pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download(
            'OptiCare_Report_' . now()->format('Y-m-d') . '.pdf'
        );
    }
}