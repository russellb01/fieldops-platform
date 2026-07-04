@extends('layouts.office')

@section('title', 'Edit Customer | FieldOps Office')
@section('page_title', 'Edit Customer')

@section('top_actions')
    <a class="btn btn-secondary" href="{{ route('office.customers.show', $customer) }}">Back to Customer</a>
@endsection

@section('content')
    <form class="form-card" method="post" action="{{ route('office.customers.update', $customer) }}">
        @csrf
        @method('put')
        <h2>Customer Details</h2>

        <div class="form-grid">
            <div class="field">
                <label>Customer Type</label>
                <select name="customer_type" required>
                    @foreach (['residential', 'commercial', 'restaurant', 'facility'] as $type)
                        <option value="{{ $type }}" @selected(old('customer_type', $customer->customer_type) === $type)>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Status</label>
                <select name="status">
                    @foreach (['active', 'inactive', 'lead'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $customer->status) === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field"><label>Display Name</label><input name="display_name" value="{{ old('display_name', $customer->display_name) }}"></div>
            <div class="field"><label>Company Name</label><input name="company_name" value="{{ old('company_name', $customer->company_name) }}"></div>
            <div class="field"><label>First Name</label><input name="first_name" value="{{ old('first_name', $customer->first_name) }}"></div>
            <div class="field"><label>Last Name</label><input name="last_name" value="{{ old('last_name', $customer->last_name) }}"></div>
            <div class="field"><label>Phone</label><input name="phone" value="{{ old('phone', $customer->phone) }}"></div>
            <div class="field"><label>Email</label><input name="email" type="email" value="{{ old('email', $customer->email) }}"></div>
            <div class="field"><label>Billing Email</label><input name="billing_email" type="email" value="{{ old('billing_email', $customer->billing_email) }}"></div>
            <div class="field"><label>Billing Phone</label><input name="billing_phone" value="{{ old('billing_phone', $customer->billing_phone) }}"></div>
            <div class="field full"><label>Billing Address</label><input name="billing_address" value="{{ old('billing_address', $customer->billing_address) }}"></div>
            <div class="field"><label>Billing City</label><input name="billing_city" value="{{ old('billing_city', $customer->billing_city) }}"></div>
            <div class="field"><label>Billing State</label><input name="billing_state" value="{{ old('billing_state', $customer->billing_state ?: 'TN') }}"></div>
            <div class="field"><label>Billing ZIP</label><input name="billing_postal_code" value="{{ old('billing_postal_code', $customer->billing_postal_code) }}"></div>
            <div class="field full"><label>Notes</label><textarea name="notes">{{ old('notes', $customer->notes) }}</textarea></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Save Customer</button>
        </div>
    </form>
@endsection
