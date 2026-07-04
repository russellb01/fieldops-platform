@extends('layouts.office')

@section('title', 'Edit PM Contract | FieldOps Office')
@section('page_title', 'Edit PM Contract')

@section('top_actions')
    <a class="btn btn-secondary" href="{{ route('office.pm-contracts.index') }}">Back to PM Contracts</a>
@endsection

@section('content')
    <form class="form-card" method="post" action="{{ route('office.pm-contracts.update', $contract) }}">
        @csrf
        @method('put')
        <h2>{{ $contract->contract_number }}</h2>

        <div class="form-grid">
            <div class="field">
                <label>Customer</label>
                <select name="customer_id" required>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @selected(old('customer_id', $contract->customer_id) == $customer->id)>{{ $customer->display_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Service Location</label>
                <select name="service_location_id">
                    <option value="">No location selected</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" @selected(old('service_location_id', $contract->service_location_id) == $location->id)>
                            {{ $location->customer?->display_name }} — {{ $location->location_name ?: $location->address }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Title</label><input name="title" value="{{ old('title', $contract->title) }}" required></div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    @foreach (['active', 'pending', 'paused', 'cancelled'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $contract->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Frequency</label>
                <select name="frequency">
                    @foreach (['monthly', 'quarterly', 'semiannual', 'annual'] as $frequency)
                        <option value="{{ $frequency }}" @selected(old('frequency', $contract->frequency) === $frequency)>{{ ucfirst($frequency) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Start Date</label><input name="start_date" type="date" value="{{ old('start_date', optional($contract->start_date)->format('Y-m-d')) }}"></div>
            <div class="field"><label>End Date</label><input name="end_date" type="date" value="{{ old('end_date', optional($contract->end_date)->format('Y-m-d')) }}"></div>
            <div class="field"><label>Next Service Date</label><input name="next_service_date" type="date" value="{{ old('next_service_date', optional($contract->next_service_date)->format('Y-m-d')) }}"></div>
            <div class="field"><label>Monthly Price</label><input name="monthly_price" type="number" step="0.01" value="{{ old('monthly_price', $contract->monthly_price) }}"></div>
            <div class="field"><label>Annual Value</label><input name="annual_value" type="number" step="0.01" value="{{ old('annual_value', $contract->annual_value) }}"></div>
            <div class="field full"><label>Scope</label><textarea name="scope">{{ old('scope', $contract->scope) }}</textarea></div>
            <div class="field full"><label>Notes</label><textarea name="notes">{{ old('notes', $contract->notes) }}</textarea></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Save PM Contract</button>
        </div>
    </form>
@endsection
