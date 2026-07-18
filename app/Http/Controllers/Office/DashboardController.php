<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\EquipmentAsset;
use App\Models\FieldOps\Estimate;
use App\Models\FieldOps\Invoice;
use App\Models\FieldOps\PmContract;
use App\Models\FieldOps\WorkOrder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('office.dashboard', [
            'customerCount' => Customer::count(),
            'equipmentCount' => EquipmentAsset::count(),
            'estimateCount' => Estimate::count(),
            'invoiceCount' => Invoice::count(),
            'pmCount' => PmContract::count(),
            'openWorkOrderCount' => WorkOrder::whereNotIn('status', ['completed', 'cancelled'])->count(),
            'recentCustomers' => Customer::latest()->limit(6)->get(),
            'recentInvoices' => Invoice::with('customer')->latest()->limit(6)->get(),
            'upcomingPm' => PmContract::with('customer')
                ->whereNotNull('next_service_date')
                ->orderBy('next_service_date')
                ->limit(6)
                ->get(),
            'scheduledWorkOrders' => WorkOrder::with(['customer', 'serviceLocation'])
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->orderByRaw('scheduled_start IS NULL')
                ->orderBy('scheduled_start')
                ->limit(8)
                ->get(),
        ]);
    }
}
