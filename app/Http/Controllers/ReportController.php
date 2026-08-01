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
     * Build all report data.
     */
    private function buildReportData(): array
    {
        $driver = DB::connection()->getDriverName();

        $totalRevenue = Billing::where('payment_status', 'Paid')->sum('amount');
        $totalUnpaid = Billing::where('payment_status', 'Unpaid')->sum('amount');

        $totalPatients = Patient::count();
        $totalAppointments = Appointment::count();

        $completedAppointments = Appointment::where('status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('status', 'Cancelled')->count();

        $inventoryValuation = Inventory::selectRaw('SUM(quantity * price) as total')
            ->value('total') ?? 0;

        $lowStockCount = Inventory::whereColumn('quantity', '<=', 'reorder_level')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Monthly Revenue
        |--------------------------------------------------------------------------
        */

        if ($driver == 'pgsql') {

            $monthlyRevenue = Billing::where('payment_status', 'Paid')
                ->selectRaw("TO_CHAR(created_at,'YYYY-MM') as month, SUM(amount) as total")
                ->groupByRaw("TO_CHAR(created_at,'YYYY-MM')")
                ->orderByRaw("TO_CHAR(created_at,'YYYY-MM') DESC")
                ->limit(12)
                ->get();

        } else {

            $monthlyRevenue = Billing::where('payment_status', 'Paid')
                ->selectRaw("DATE_FORMAT(created_at,'%Y-%m') as month, SUM(amount) as total")
                ->groupByRaw("DATE_FORMAT(created_at,'%Y-%m')")
                ->orderByRaw("DATE_FORMAT(created_at,'%Y-%m') DESC")
                ->limit(12)
                ->get();

        }

        /*
        |--------------------------------------------------------------------------
        | Monthly Patients
        |--------------------------------------------------------------------------
        */

        if ($driver == 'pgsql') {

            $monthlyPatients = Patient::selectRaw("TO_CHAR(created_at,'YYYY-MM') as month, COUNT(*) as total")
                ->groupByRaw("TO_CHAR(created_at,'YYYY-MM')")
                ->orderByRaw("TO_CHAR(created_at,'YYYY-MM') DESC")
                ->limit(12)
                ->get();

        } else {

            $monthlyPatients = Patient::selectRaw("DATE_FORMAT(created_at,'%Y-%m') as month, COUNT(*) as total")
                ->groupByRaw("DATE_FORMAT(created_at,'%Y-%m')")
                ->orderByRaw("DATE_FORMAT(created_at,'%Y-%m') DESC")
                ->limit(12)
                ->get();

        }

        /*
        |--------------------------------------------------------------------------
        | Top Services
        |--------------------------------------------------------------------------
        */

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
     * Display reports.
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
            'OptiCare-Report-' . now()->format('Y-m-d') . '.pdf'
        );
    }
}