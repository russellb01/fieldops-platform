@extends('layouts.office')

@section('title', 'Edit Estimate | FieldOps Office')
@section('page_title', 'Edit Estimate')

@section('top_actions')
    <a class="btn btn-secondary" href="{{ route('office.estimates.show', $estimate) }}">Back to Estimate</a>
    <a class="btn btn-secondary" href="{{ route('office.estimates.print', $estimate) }}" target="_blank">Print</a>
@endsection

@section('content')
    <form class="form-card" method="post" action="{{ route('office.estimates.update', $estimate) }}">
        @csrf
        @method('put')

        <h2>{{ $estimate->estimate_number }}</h2>

        <div class="form-grid">
            <div class="field">
                <label>Customer</label>
                <select name="customer_id" required>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id', $estimate->customer_id) == $customer->id)>{{ $customer->display_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Service Location</label>
                <select name="service_location_id">
                    <option value="">No location selected</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('service_location_id', $estimate->service_location_id) == $location->id)>
                            {{ $location->customer?->display_name }} — {{ $location->location_name ?: $location->address }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Title</label><input name="title" value="{{ old('title', $estimate->title) }}" required></div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    @foreach (['draft', 'sent', 'approved', 'declined', 'expired'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $estimate->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Tax</label><input name="tax" type="number" step="0.01" value="{{ old('tax', $estimate->tax) }}"></div>
            <div class="field"><label>Valid Until</label><input name="valid_until" type="date" value="{{ old('valid_until', optional($estimate->valid_until)->format('Y-m-d')) }}"></div>

            <div class="field full"><label>Issue Summary</label><textarea name="issue_summary">{{ old('issue_summary', $estimate->issue_summary) }}</textarea></div>
            <div class="field full"><label>Scope of Work</label><textarea name="scope_of_work">{{ old('scope_of_work', $estimate->scope_of_work) }}</textarea></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Save Estimate</button>
        </div>
    </form>
@endsection
