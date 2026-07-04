@extends('layouts.office')

@section('title', 'Add Customer | FieldOps Office')
@section('page_title', 'Add Customer')

@section('content')
    <form class="form-card" method="post" action="{{ route('office.customers.store') }}">
        @csrf
        <h2>Customer Details</h2>

        <div class="form-grid">
            <div class="field">
                <label>Customer Type</label>
                <select name="customer_type" required>
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                    <option value="restaurant">Restaurant</option>
                    <option value="facility">Facility</option>
                </select>
            </div>

            <div class="field">
                <label>Display Name</label>
                <input name="display_name" value="{{ old('display_name') }}" placeholder="How this customer should show up">
            </div>

            <div class="field">
                <label>Company Name</label>
                <input name="company_name" value="{{ old('company_name') }}">
            </div>

            <div class="field">
                <label>Phone</label>
                <input name="phone" value="{{ old('phone') }}">
            </div>

            <div class="field">
                <label>First Name</label>
                <input name="first_name" value="{{ old('first_name') }}">
            </div>

            <div class="field">
                <label>Last Name</label>
                <input name="last_name" value="{{ old('last_name') }}">
            </div>

            <div class="field">
                <label>Email</label>
                <input name="email" type="email" value="{{ old('email') }}">
            </div>

            <div class="field">
                <label>Billing Email</label>
                <input name="billing_email" type="email" value="{{ old('billing_email') }}">
            </div>

            <div class="field full">
                <label>Billing Address</label>
                <input name="billing_address" value="{{ old('billing_address') }}">
            </div>

            <div class="field">
                <label>Billing City</label>
                <input name="billing_city" value="{{ old('billing_city') }}">
            </div>

            <div class="field">
                <label>Billing State</label>
                <input name="billing_state" value="{{ old('billing_state', 'TN') }}">
            </div>

            <div class="field">
                <label>Billing ZIP</label>
                <input name="billing_postal_code" value="{{ old('billing_postal_code') }}">
            </div>

            <div class="field full">
                <label>Notes</label>
                <textarea name="notes">{{ old('notes') }}</textarea>
            </div>

            <div class="field full check-field">
                <label>
                    <input type="checkbox" name="create_service_location_from_billing" value="1" @checked(old('create_service_location_from_billing'))>
                    Also create a service location from the billing address
                </label>
                <small>Use this when the customer billing address is also the service address. Rental properties can be added later from the customer profile.</small>
            </div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Create Customer</button>
        </div>
    </form>
@endsection
