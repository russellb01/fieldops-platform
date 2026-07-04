@extends('layouts.office')

@section('title', 'Invoices | FieldOps Office')
@section('page_title', 'Invoices')

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.invoices.create') }}">New Invoice</a>
@endsection

@section('content')
    <div class="table-card">
        <table class="office-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr>
                        <td><a href="{{ route('office.invoices.show', $invoice) }}"><strong>{{ $invoice->invoice_number }}</strong></a></td>
                        <td>{{ $invoice->customer?->display_name }}</td>
                        <td>{{ $invoice->title }}</td>
                        <td><span class="badge orange">{{ $invoice->status }}</span></td>
                        <td>${{ number_format($invoice->total, 2) }}</td>
                        <td>${{ number_format($invoice->balance, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No invoices yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px">{{ $invoices->links() }}</div>
@endsection
