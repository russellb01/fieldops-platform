@extends('layouts.office')

@section('title', 'New PM Contract | FieldOps Office')
@section('page_title', 'New PM Contract')

@section('content')
    <form class="form-card" method="post" action="{{ route('office.pm-contracts.store') }}">
        @csrf
        <h2>PM Contract Details</h2>

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

            <div class="field"><label>Title</label><input name="title" required placeholder="Quarterly refrigeration PM"></div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="paused">Paused</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>

            <div class="field">
                <label>Frequency</label>
                <select name="frequency">
                    <option value="monthly">Monthly</option>
                    <option value="quarterly" selected>Quarterly</option>
                    <option value="semiannual">Semiannual</option>
                    <option value="annual">Annual</option>
                </select>
            </div>

            <div class="field"><label>Start Date</label><input name="start_date" type="date"></div>
            <div class="field"><label>End Date</label><input name="end_date" type="date"></div>
            <div class="field"><label>Next Service Date</label><input name="next_service_date" type="date"></div>

            <div class="field"><label>Monthly Price</label><input name="monthly_price" type="number" step="0.01" value="0.00"></div>
            <div class="field"><label>Annual Value</label><input name="annual_value" type="number" step="0.01" value="0.00"></div>

            <div class="field full"><label>Scope</label><textarea name="scope" placeholder="Coil cleaning, filter checks, temperature checks, ice machine cleaning, refrigeration inspection..."></textarea></div>
            <div class="field full"><label>Notes</label><textarea name="notes"></textarea></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Create PM Contract</button>
        </div>
    </form>
@endsection
