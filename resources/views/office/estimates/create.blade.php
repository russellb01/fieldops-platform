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
                        <option value="{{ $customer->id }}">{{ $customer->display_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Service Location</label>
                <select name="service_location_id">
                    <option value="">No location selected</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->customer?->display_name }} — {{ $location->location_name ?: $location->address }}</option>
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

            <div class="field full"><label>Issue Summary</label><textarea name="issue_summary"></textarea></div>
            <div class="field full"><label>Scope of Work</label><textarea name="scope_of_work"></textarea></div>

            <div class="field full"><label>Line Description</label><textarea name="line_description" required placeholder="Labor, parts, repair, replacement, PM work..."></textarea></div>

            <div class="field"><label>Quantity</label><input name="quantity" type="number" step="0.01" value="1"></div>
            <div class="field"><label>Unit Price</label><input name="unit_price" type="number" step="0.01" value="0.00"></div>
            <div class="field"><label>Tax</label><input name="tax" type="number" step="0.01" value="0.00"></div>
            <div class="field"><label>Valid Until</label><input name="valid_until" type="date"></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Create Estimate</button>
        </div>
    </form>
@endsection
