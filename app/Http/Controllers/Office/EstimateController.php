<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\Estimate;
use App\Models\FieldOps\ServiceLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstimateController extends Controller
{
    public function index(): View
    {
        return view('office.estimates.index', [
            'estimates' => Estimate::with('customer')->latest()->paginate(25),
        ]);
    }

    public function create(): View
    {
        return view('office.estimates.create', [
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:fieldops_customers,id'],
            'service_location_id' => ['nullable', 'exists:fieldops_service_locations,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
            'issue_summary' => ['nullable', 'string'],
            'scope_of_work' => ['nullable', 'string'],
            'valid_until' => ['nullable', 'date'],
            'line_description' => ['required', 'string'],
            'quantity' => ['nullable', 'numeric', 'min:0'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
        ]);

        $quantity = (float) ($data['quantity'] ?? 1);
        $unitPrice = (float) ($data['unit_price'] ?? 0);
        $lineTotal = round($quantity * $unitPrice, 2);
        $tax = round((float) ($data['tax'] ?? 0), 2);

        $estimate = Estimate::create([
            'estimate_number' => $this->nextNumber(),
            'customer_id' => $data['customer_id'],
            'service_location_id' => $data['service_location_id'] ?? null,
            'title' => $data['title'],
            'status' => $data['status'],
            'issue_summary' => $data['issue_summary'] ?? null,
            'scope_of_work' => $data['scope_of_work'] ?? null,
            'valid_until' => $data['valid_until'] ?? null,
            'subtotal' => $lineTotal,
            'tax' => $tax,
            'total' => $lineTotal + $tax,
        ]);

        $estimate->items()->create([
            'description' => $data['line_description'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $lineTotal,
        ]);

        return redirect()->route('office.estimates.show', $estimate)->with('success', 'Estimate created.');
    }

    public function show(Estimate $estimate): View
    {
        $estimate->load(['customer', 'serviceLocation', 'items']);

        return view('office.estimates.show', compact('estimate'));
    }

    private function nextNumber(): string
    {
        return 'EST-' . now()->format('Y') . '-' . str_pad((string) ((Estimate::max('id') ?? 0) + 1), 5, '0', STR_PAD_LEFT);
    }
}
