@extends('layouts.office')

@section('title', 'Edit Invoice | FieldOps Office')
@section('page_title', 'Edit Invoice')

@section('top_actions')
    <a class="btn btn-secondary" href="{{ route('office.invoices.show', $invoice) }}">Back to Invoice</a>
    <a class="btn btn-secondary" href="{{ route('office.invoices.print', $invoice) }}" target="_blank">Print</a>
@endsection

@section('content')
    <form class="form-card" method="post" action="{{ route('office.invoices.update', $invoice) }}">
        @csrf
        @method('put')

        <h2>{{ $invoice->invoice_number }}</h2>

        <div class="form-grid">
            <div class="field">
                <label>Customer</label>
                <select name="customer_id" required>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id', $invoice->customer_id) == $customer->id)>{{ $customer->display_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Service Location</label>
                <select name="service_location_id">
                    <option value="">No location selected</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('service_location_id', $invoice->service_location_id) == $location->id)>
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
                        <option value="{{ $estimate->id }}" @selected(old('estimate_id', $invoice->estimate_id) == $estimate->id)>
                            {{ $estimate->estimate_number }} — {{ $estimate->customer?->display_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Title</label><input name="title" value="{{ old('title', $invoice->title) }}" required></div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    @foreach (['draft', 'sent', 'partial', 'paid', 'overdue', 'void'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $invoice->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Service Date</label><input name="service_date" type="date" value="{{ old('service_date', optional($invoice->service_date)->format('Y-m-d')) }}"></div>
            <div class="field"><label>Due Date</label><input name="due_date" type="date" value="{{ old('due_date', optional($invoice->due_date)->format('Y-m-d')) }}"></div>
            <div class="field"><label>Tax</label><input name="tax" type="number" step="0.01" value="{{ old('tax', $invoice->tax) }}"></div>
            <div class="field"><label>Amount Paid</label><input name="amount_paid" type="number" step="0.01" value="{{ old('amount_paid', $invoice->amount_paid) }}"></div>

            <div class="field full"><label>Notes</label><textarea name="notes">{{ old('notes', $invoice->notes) }}</textarea></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Save Invoice</button>
        </div>
    </form>
@endsection
