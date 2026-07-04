@extends('layouts.office')

@section('title', 'New Estimate | FieldOps Office')
@section('page_title', 'New Estimate')

@section('content')
    <form class="form-card" method="post" action="{{ route('office.estimates.store') }}">
        @csrf
        <h2>Estimate Details</h2>

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

            <div class="field"><label>Title</label><input name="title" required placeholder="Walk-in cooler repair estimate"></div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    <option value="draft">Draft</option>
                    <option value="sent">Sent</option>
                    <option value="approved">Approved</option>
                    <option value="declined">Declined</option>
                </select>
            </div>

            <div class="field"><label>Tax</label><input name="tax" type="number" step="0.01" value="0.00"></div>
            <div class="field"><label>Valid Until</label><input name="valid_until" type="date"></div>

            <div class="field full"><label>Issue Summary</label><textarea name="issue_summary"></textarea></div>
            <div class="field full"><label>Scope of Work</label><textarea name="scope_of_work"></textarea></div>
        </div>

        <h2 style="margin-top:26px">Line Items</h2>
        <p class="muted-help">Add labor, parts, equipment, trip charges, maintenance, discounts, or anything else needed on the estimate.</p>

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
            <button class="btn btn-primary" type="submit">Create Estimate</button>
        </div>
    </form>
@endsection
