@extends('layouts.office')

@section('title', 'New Invoice | FieldOps Office')
@section('page_title', 'New Invoice')

@section('content')
    <form class="form-card" method="post" action="{{ route('office.invoices.store') }}">
        @csrf
        <h2>Invoice Details</h2>

        <div class="form-grid">
            <div class="field">
                <label>Customer</label>
                <select name="customer_id" required>
                    <option value="">Select customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected((int) old('customer_id', $selectedCustomerId) === $customer->id)>{{ $customer->display_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Service / Rental Location</label>
                <select name="service_location_id">
                    <option value="">Use billing address / no location selected</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected((int) old('service_location_id', $selectedLocationId) === $location->id)>
                            {{ $location->customer?->display_name }} — {{ $location->location_name ?: $location->address }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Related Estimate</label>
                <select name="estimate_id">
                    <option value="">No estimate selected</option>
                    @foreach ($estimates as $estimate)
                        <option value="{{ $estimate->id }}" @selected((int) old('estimate_id', $selectedEstimateId) === $estimate->id)>
                            {{ $estimate->estimate_number }} — {{ $estimate->customer?->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Title</label><input name="title" required placeholder="HVAC service invoice"></div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    <option value="draft">Draft</option>
                    <option value="sent">Sent</option>
                    <option value="paid">Paid</option>
                    <option value="partial">Partial</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>

            <div class="field"><label>Service Date</label><input name="service_date" type="date"></div>
            <div class="field"><label>Due Date</label><input name="due_date" type="date"></div>
            <div class="field"><label>Tax</label><input name="tax" type="number" step="0.01" value="0.00"></div>
            <div class="field"><label>Amount Paid</label><input name="amount_paid" type="number" step="0.01" value="0.00"></div>

            <div class="field full"><label>Notes</label><textarea name="notes"></textarea></div>
        </div>

        <h2 style="margin-top:26px">Line Items</h2>
        <p class="muted-help">Add labor, parts, equipment, trip charges, maintenance, discounts, or anything else needed on the invoice.</p>

        <div class="line-item-stack">
            @for ($i = 0; $i < 5; $i++)
                <div class="line-item-row">
                    <div class="field">
                        <label>Type</label>
                        <select name="line_type[]">
                            <option value="service">Service</option>
                            <option value="labor">Labor</option>
                            <option value="part">Part</option>
                            <option value="equipment">Equipment</option>
                            <option value="trip_charge">Trip Charge</option>
                            <option value="discount">Discount</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="field line-description">
                        <label>Description</label>
                        <input name="line_description[]" placeholder="{{ $i === 0 ? 'Service work, labor, part, equipment...' : 'Optional additional line item' }}">
                    </div>
                    <div class="field">
                        <label>Qty</label>
                        <input name="quantity[]" type="number" step="0.01" value="{{ $i === 0 ? '1' : '' }}">
                    </div>
                    <div class="field">
                        <label>Unit Price</label>
                        <input name="unit_price[]" type="number" step="0.01" value="{{ $i === 0 ? '0.00' : '' }}">
                    </div>
                </div>
            @endfor
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Create Invoice</button>
        </div>
    </form>
@endsection
