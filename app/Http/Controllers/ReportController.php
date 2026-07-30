<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Build all the report data. Shared by the on-screen view and the
     * PDF export so both always show the exact same numbers.
     */
    private function buildReportData(): array
    {
        $totalRevenue = Billing::where('payment_status', 'Paid')->sum('amount');
        $totalUnpaid = Billing::where('payment_status', 'Unpaid')->sum('amount');
        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();
        $completedAppointments = Appointment::where('status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('status', 'Cancelled')->count();

        // Total worth of everything currently in stock (quantity x price, summed)
        $inventoryValuation = Inventory::selectRaw('SUM(quantity * price) as total')->value('total') ?? 0;
        $lowStockCount = Inventory::whereColumn('quantity', '<=', 'reorder_level')->count();

        // Revenue grouped by month (paid billings only)
        $monthlyRevenue = Billing::where('payment_status', 'Paid')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderByDesc('month')
            ->limit(12)
            ->get();

        // New patients grouped by month
        $monthlyPatients = Patient::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderByDesc('month')
            ->limit(12)
            ->get();

        // Most availed services (from billing service_type)
        $topServices = Billing::selectRaw('service_type, COUNT(*) as total, SUM(amount) as revenue')
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

    public function index()
    {
        return view('reports.index', $this->buildReportData());
    }

    public function exportPdf()
    {
        $data = $this->buildReportData();

        $pdf = Pdf::loadView('reports.pdf', $data)->setPaper('a4', 'portrait');

        return $pdf->download('optiCare-report-' . now()->format('Y-m-d') . '.pdf');
    }
}