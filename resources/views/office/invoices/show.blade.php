@extends('layouts.office')

@section('title', $invoice->invoice_number . ' | FieldOps Office')
@section('page_title', $invoice->invoice_number)

@section('content')
    <section class="panel">
        <div class="detail-header">
            <h2>{{ $invoice->title }}</h2>
            <p>{{ $invoice->customer?->display_name }} • Status: {{ $invoice->status }}</p>
            <p>Total: <strong>${{ number_format($invoice->total, 2) }}</strong> • Balance: <strong>${{ number_format($invoice->balance, 2) }}</strong></p>
        </div>

        @if ($invoice->notes)
            <p>{{ $invoice->notes }}</p>
        @endif
    </section>

    <div style="height:18px"></div>

    <div class="table-card">
        <table class="office-table">
            <thead><tr><th>Description</th><th>Qty</th><th>Unit</th><th>Total</th></tr></thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ number_format($item->quantity, 2) }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr><td colspan="3"><strong>Subtotal</strong></td><td>${{ number_format($invoice->subtotal, 2) }}</td></tr>
                <tr><td colspan="3"><strong>Tax</strong></td><td>${{ number_format($invoice->tax, 2) }}</td></tr>
                <tr><td colspan="3"><strong>Total</strong></td><td><strong>${{ number_format($invoice->total, 2) }}</strong></td></tr>
                <tr><td colspan="3"><strong>Paid</strong></td><td>${{ number_format($invoice->amount_paid, 2) }}</td></tr>
                <tr><td colspan="3"><strong>Balance</strong></td><td><strong>${{ number_format($invoice->balance, 2) }}</strong></td></tr>
            </tbody>
        </table>
    </div>
@endsection
