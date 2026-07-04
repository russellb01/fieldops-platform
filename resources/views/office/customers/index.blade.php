@extends('layouts.office')

@section('title', 'Customers | FieldOps Office')
@section('page_title', 'Customers')

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.customers.create') }}">Add Customer</a>
@endsection

@section('content')
    <form class="search-row" method="get">
        <input name="search" value="{{ $search }}" placeholder="Search customer name, company, phone, email">
        <button class="btn btn-secondary" type="submit">Search</button>
    </form>

    <div class="table-card">
        <table class="office-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Type</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td><a href="{{ route('office.customers.show', $customer) }}"><strong>{{ $customer->display_name }}</strong></a></td>
                        <td>{{ ucfirst($customer->customer_type) }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->email }}</td>
                        <td><span class="badge">{{ ucfirst($customer->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5">No customers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px">{{ $customers->links() }}</div>
@endsection
