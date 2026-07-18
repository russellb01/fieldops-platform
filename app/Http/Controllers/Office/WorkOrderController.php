<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\EquipmentAsset;
use App\Models\FieldOps\Estimate;
use App\Models\FieldOps\ServiceLocation;
use App\Models\FieldOps\WorkOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkOrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = WorkOrder::with(['customer', 'serviceLocation'])->orderByRaw('scheduled_start IS NULL')->orderBy('scheduled_start')->latest('id');

        if ($request->filled('status')) $query->where('status', $request->string('status'));
        if ($request->filled('q')) {
            $term = '%'.$request->string('q').'%';
            $query->where(fn ($q) => $q->where('work_order_number', 'like', $term)->orWhere('title', 'like', $term)->orWhereHas('customer', fn ($c) => $c->where('display_name', 'like', $term)));
        }

        return view('office.work-orders.index', ['workOrders' => $query->paginate(25)->withQueryString()]);
    }

    public function create(Request $request): View
    {
        return view('office.work-orders.create', $this->formData() + [
            'selectedCustomerId' => $request->integer('customer_id') ?: null,
            'selectedLocationId' => $request->integer('service_location_id') ?: null,
            'selectedEstimateId' => $request->integer('estimate_id') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $workOrder = WorkOrder::create($this->validated($request) + ['work_order_number' => $this->nextNumber()]);
        return redirect()->route('office.work-orders.show', $workOrder)->with('success', 'Work order created and added to the schedule.');
    }

    public function show(WorkOrder $workOrder): View
    {
        $workOrder->load(['customer', 'serviceLocation', 'equipmentAsset', 'estimate']);
        return view('office.work-orders.show', compact('workOrder'));
    }

    public function edit(WorkOrder $workOrder): View
    {
        return view('office.work-orders.edit', $this->formData() + compact('workOrder'));
    }

    public function update(Request $request, WorkOrder $workOrder): RedirectResponse
    {
        $data = $this->validated($request);
        $data['completed_at'] = $data['status'] === 'completed' ? ($workOrder->completed_at ?: now()) : null;
        $workOrder->update($data);
        return redirect()->route('office.work-orders.show', $workOrder)->with('success', 'Work order updated.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:fieldops_customers,id'],
            'service_location_id' => ['nullable', 'exists:fieldops_service_locations,id'],
            'equipment_asset_id' => ['nullable', 'exists:fieldops_equipment_assets,id'],
            'estimate_id' => ['nullable', 'exists:fieldops_estimates,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:new,scheduled,dispatched,in_progress,on_hold,completed,cancelled'],
            'priority' => ['required', 'in:low,normal,high,emergency'],
            'service_type' => ['nullable', 'string', 'max:100'],
            'assigned_to' => ['nullable', 'string', 'max:120'],
            'scheduled_start' => ['nullable', 'date'],
            'scheduled_end' => ['nullable', 'date', 'after_or_equal:scheduled_start'],
            'customer_request' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'work_performed' => ['nullable', 'string'],
            'internal_notes' => ['nullable', 'string'],
        ]);
    }

    private function formData(): array
    {
        return [
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
            'equipmentAssets' => EquipmentAsset::with('customer')->orderBy('name')->get(),
            'estimates' => Estimate::with('customer')->whereIn('status', ['draft', 'sent', 'approved'])->latest()->get(),
        ];
    }

    private function nextNumber(): string
    {
        return 'WO-'.now()->format('Y').'-'.str_pad((string) ((WorkOrder::max('id') ?? 0) + 1), 5, '0', STR_PAD_LEFT);
    }
}
