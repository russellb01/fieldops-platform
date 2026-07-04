<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\FieldOps\Customer;
use App\Models\FieldOps\EquipmentAsset;
use App\Models\FieldOps\ServiceLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $customers = Customer::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('display_name', 'like', "%{$search}%")
                        ->orWhere('company_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('office.customers.index', compact('customers', 'search'));
    }

    public function create(): View
    {
        return view('office.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'customer_type' => ['required', 'string', 'max:40'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'display_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:80'],
            'billing_email' => ['nullable', 'email', 'max:255'],
            'billing_phone' => ['nullable', 'string', 'max:80'],
            'billing_address' => ['nullable', 'string', 'max:255'],
            'billing_city' => ['nullable', 'string', 'max:120'],
            'billing_state' => ['nullable', 'string', 'max:20'],
            'billing_postal_code' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['display_name'] = $data['display_name']
            ?: ($data['company_name'] ?: trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')));

        if ($data['display_name'] === '') {
            return back()->withInput()->withErrors(['display_name' => 'Enter a company name, customer name, or display name.']);
        }

        $customer = Customer::create($data);

        return redirect()->route('office.customers.show', $customer)->with('success', 'Customer created.');
    }

    public function show(Customer $customer): View
    {
        $customer->load([
            'locations' => fn ($query) => $query->latest(),
            'equipmentAssets' => fn ($query) => $query->with('serviceLocation')->latest(),
            'estimates' => fn ($query) => $query->latest(),
            'invoices' => fn ($query) => $query->latest(),
            'pmContracts' => fn ($query) => $query->latest(),
        ]);

        return view('office.customers.show', compact('customer'));
    }

    public function storeLocation(Request $request, Customer $customer): RedirectResponse
    {
        $data = $request->validate([
            'location_name' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:120'],
            'state' => ['nullable', 'string', 'max:20'],
            'postal_code' => ['nullable', 'string', 'max:30'],
            'access_notes' => ['nullable', 'string'],
            'site_notes' => ['nullable', 'string'],
        ]);

        $customer->locations()->create($data);

        return back()->with('success', 'Service location added.');
    }

    public function storeEquipment(Request $request, Customer $customer): RedirectResponse
    {
        $data = $request->validate([
            'service_location_id' => ['nullable', 'exists:fieldops_service_locations,id'],
            'asset_type' => ['required', 'string', 'max:80'],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:120'],
            'model' => ['nullable', 'string', 'max:120'],
            'serial_number' => ['nullable', 'string', 'max:120'],
            'install_date' => ['nullable', 'date'],
            'warranty_expires_at' => ['nullable', 'date'],
            'refrigerant_type' => ['nullable', 'string', 'max:80'],
            'filter_size' => ['nullable', 'string', 'max:80'],
            'belt_size' => ['nullable', 'string', 'max:80'],
            'voltage' => ['nullable', 'string', 'max:80'],
            'phase' => ['nullable', 'string', 'max:80'],
            'notes' => ['nullable', 'string'],
        ]);

        $data['customer_id'] = $customer->id;

        EquipmentAsset::create($data);

        return back()->with('success', 'Equipment added.');
    }
}
