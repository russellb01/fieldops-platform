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

            <div class="field">
                <label>Related Estimate</label>
                <select name="estimate_id">
                    <option value="">No estimate selected</option>
                    @foreach ($estimates as $estimate)
                        <option value="{{ $estimate->id }}">{{ $estimate->estimate_number }} — {{ $estimate->customer?->display_name }}</option>
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

            <div class="field full"><label>Line Description</label><textarea name="line_description" required></textarea></div>

            <div class="field"><label>Quantity</label><input name="quantity" type="number" step="0.01" value="1"></div>
            <div class="field"><label>Unit Price</label><input name="unit_price" type="number" step="0.01" value="0.00"></div>
            <div class="field"><label>Tax</label><input name="tax" type="number" step="0.01" value="0.00"></div>
            <div class="field"><label>Amount Paid</label><input name="amount_paid" type="number" step="0.01" value="0.00"></div>

            <div class="field full"><label>Notes</label><textarea name="notes"></textarea></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Create Invoice</button>
        </div>
    </form>
@endsection
