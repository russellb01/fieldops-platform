@extends('layouts.office')

@section('title', $customer->display_name . ' | FieldOps Office')
@section('page_title', 'Customer Profile')

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.customers.edit', $customer) }}">Edit Customer</a>
    <a class="btn btn-secondary" href="{{ route('office.estimates.create') }}">New Estimate</a>
    <a class="btn btn-secondary" href="{{ route('office.invoices.create') }}">New Invoice</a>
    <a class="btn btn-primary" href="{{ route('office.pm-contracts.create') }}">New PM Contract</a>
@endsection

@section('content')
    <section class="panel">
        <div class="detail-header">
            <h2>{{ $customer->display_name }}</h2>
            <p>{{ ucfirst($customer->customer_type) }} customer • {{ $customer->phone }} • {{ $customer->email }}</p>
            @if ($customer->billing_address)
                <p>{{ $customer->billing_address }}, {{ $customer->billing_city }} {{ $customer->billing_state }} {{ $customer->billing_postal_code }}</p>
            @endif
            @if ($customer->notes)
                <p>{{ $customer->notes }}</p>
            @endif
        </div>

        @if ($customer->billing_address)
            <form method="post" action="{{ route('office.customers.billing-location.store', $customer) }}" style="margin-top:14px">
                @csrf
                <button class="btn btn-secondary" type="submit">Use Billing Address as Service Location</button>
            </form>
        @endif
    </section>

    <div style="height:18px"></div>

    <div class="two-col">
        <section class="form-card">
            <h2>Add Service Location</h2>
            <form method="post" action="{{ route('office.customers.locations.store', $customer) }}">
                @csrf
                <div class="form-grid">
                    <div class="field"><label>Location Name</label><input name="location_name" placeholder="Main store, Home, Kitchen, Roof units"></div>
                    <div class="field"><label>Address</label><input name="address" required></div>
                    <div class="field"><label>City</label><input name="city"></div>
                    <div class="field"><label>State</label><input name="state" value="TN"></div>
                    <div class="field"><label>ZIP</label><input name="postal_code"></div>
                    <div class="field full"><label>Access Notes</label><textarea name="access_notes" placeholder="Gate code, roof access, back door, manager contact"></textarea></div>
                    <div class="field full"><label>Site Notes</label><textarea name="site_notes"></textarea></div>
                </div>
                <div style="margin-top:14px"><button class="btn btn-primary">Add Location</button></div>
            </form>
        </section>

        <section class="form-card">
            <h2>Add Equipment / Asset</h2>
            <form method="post" action="{{ route('office.customers.equipment.store', $customer) }}">
                @csrf
                <div class="form-grid">
                    <div class="field">
                        <label>Location</label>
                        <select name="service_location_id">
                            <option value="">No location selected</option>
                            @foreach ($customer->locations as $location)
                                <option value="{{ $location->id }}">{{ $location->location_name ?: $location->address }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Asset Type</label>
                        <select name="asset_type" required>
                            <option value="hvac">HVAC</option>
                            <option value="walk_in_cooler">Walk-in Cooler</option>
                            <option value="walk_in_freezer">Walk-in Freezer</option>
                            <option value="ice_machine">Ice Machine</option>
                            <option value="restaurant_equipment">Restaurant Equipment</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="field"><label>Name</label><input name="name" required placeholder="Kitchen walk-in cooler, RTU #1, Hoshizaki ice machine"></div>
                    <div class="field"><label>Brand</label><input name="brand"></div>
                    <div class="field"><label>Model</label><input name="model"></div>
                    <div class="field"><label>Serial Number</label><input name="serial_number"></div>
                    <div class="field"><label>Install Date</label><input name="install_date" type="date"></div>
                    <div class="field"><label>Warranty Expires</label><input name="warranty_expires_at" type="date"></div>
                    <div class="field"><label>Refrigerant</label><input name="refrigerant_type"></div>
                    <div class="field"><label>Filter Size</label><input name="filter_size"></div>
                    <div class="field"><label>Belt Size</label><input name="belt_size"></div>
                    <div class="field"><label>Voltage / Phase</label><input name="voltage" placeholder="208/230"><input name="phase" placeholder="1 phase / 3 phase" style="margin-top:8px"></div>
                    <div class="field full"><label>Notes</label><textarea name="notes"></textarea></div>
                </div>
                <div style="margin-top:14px"><button class="btn btn-primary">Add Equipment</button></div>
            </form>
        </section>
    </div>

    <div style="height:18px"></div>

    <div class="two-col">
        <section class="table-card">
            <table class="office-table">
                <thead><tr><th>Service / Rental Location</th><th>Address</th><th>Access Notes</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($customer->locations as $location)
                        <tr>
                            <td><strong>{{ $location->location_name ?: 'Location' }}</strong></td>
                            <td>{{ $location->address }}, {{ $location->city }} {{ $location->state }} {{ $location->postal_code }}</td>
                            <td>{{ $location->access_notes }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-secondary" href="{{ route('office.estimates.create', ['customer_id' => $customer->id, 'service_location_id' => $location->id]) }}">Estimate</a>
                                    <a class="btn btn-secondary" href="{{ route('office.invoices.create', ['customer_id' => $customer->id, 'service_location_id' => $location->id]) }}">Invoice</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No locations yet. Add the main service address or rental properties above.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="table-card">
            <table class="office-table">
                <thead><tr><th colspan="4">Equipment / Assets</th></tr></thead>
                <tbody>
                    @forelse ($customer->equipmentAssets as $asset)
                        <tr>
                            <td><strong>{{ $asset->name }}</strong><br><span class="badge">{{ $asset->asset_type }}</span></td>
                            <td>{{ $asset->brand }} {{ $asset->model }}</td>
                            <td>{{ $asset->serial_number }}</td>
                            <td>{{ $asset->serviceLocation?->location_name ?: $asset->serviceLocation?->address }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No equipment yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>

    <div style="height:18px"></div>

    <div class="two-col">
        <section class="table-card">
            <table class="office-table">
                <thead><tr><th colspan="4">Estimates</th></tr></thead>
                <tbody>
                    @forelse ($customer->estimates as $estimate)
                        <tr>
                            <td><a href="{{ route('office.estimates.show', $estimate) }}"><strong>{{ $estimate->estimate_number }}</strong></a></td>
                            <td>{{ $estimate->title }}</td>
                            <td><span class="badge">{{ $estimate->status }}</span></td>
                            <td>${{ number_format($estimate->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No estimates yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>

        <section class="table-card">
            <table class="office-table">
                <thead><tr><th colspan="4">Invoices</th></tr></thead>
                <tbody>
                    @forelse ($customer->invoices as $invoice)
                        <tr>
                            <td><a href="{{ route('office.invoices.show', $invoice) }}"><strong>{{ $invoice->invoice_number }}</strong></a></td>
                            <td>{{ $invoice->title }}</td>
                            <td><span class="badge orange">{{ $invoice->status }}</span></td>
                            <td>${{ number_format($invoice->balance, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No invoices yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </div>

    <div style="height:18px"></div>

    <section class="table-card">
        <table class="office-table">
            <thead><tr><th colspan="5">PM Contracts</th></tr></thead>
            <tbody>
                @forelse ($customer->pmContracts as $pm)
                    <tr>
                        <td><strong>{{ $pm->contract_number }}</strong></td>
                        <td>{{ $pm->title }}</td>
                        <td><span class="badge green">{{ $pm->status }}</span></td>
                        <td>{{ $pm->frequency }}</td>
                        <td>Next: {{ optional($pm->next_service_date)->format('m/d/Y') ?: 'Not set' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">No PM contracts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
@endsection
