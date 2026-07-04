<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\PmContract;
use App\Models\FieldOps\ServiceLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PmContractController extends Controller
{
    public function index(): View
    {
        return view('office.pm-contracts.index', [
            'contracts' => PmContract::with('customer')->latest()->paginate(25),
        ]);
    }

    public function create(): View
    {
        return view('office.pm-contracts.create', [
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        $contract = PmContract::create([
            'contract_number' => $this->nextNumber(),
            ...$data,
        ]);

        return redirect()->route('office.pm-contracts.index')->with('success', 'PM contract created: ' . $contract->contract_number);
    }

    public function edit(PmContract $pmContract): View
    {
        return view('office.pm-contracts.edit', [
            'contract' => $pmContract,
            'customers' => Customer::orderBy('display_name')->get(),
            'locations' => ServiceLocation::with('customer')->orderBy('address')->get(),
        ]);
    }

    public function update(Request $request, PmContract $pmContract): RedirectResponse
    {
        $pmContract->update($this->validatedData($request));

        return redirect()->route('office.pm-contracts.index')->with('success', 'PM contract updated.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'customer_id' => ['required', 'exists:fieldops_customers,id'],
            'service_location_id' => ['nullable', 'exists:fieldops_service_locations,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:40'],
            'frequency' => ['required', 'string', 'max:40'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'next_service_date' => ['nullable', 'date'],
            'monthly_price' => ['nullable', 'numeric', 'min:0'],
            'annual_value' => ['nullable', 'numeric', 'min:0'],
            'scope' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function nextNumber(): string
    {
        return 'PM-' . now()->format('Y') . '-' . str_pad((string) ((PmContract::max('id') ?? 0) + 1), 5, '0', STR_PAD_LEFT);
    }
}
