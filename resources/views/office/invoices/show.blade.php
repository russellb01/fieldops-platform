@extends('layouts.office')

@section('title', $invoice->invoice_number . ' | FieldOps Office')
@section('page_title', $invoice->invoice_number)

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.invoices.edit', $invoice) }}">Edit</a>
    <a class="btn btn-secondary" href="{{ route('office.invoices.print', $invoice) }}" target="_blank">Print</a>
    <a class="btn btn-secondary" href="{{ route('office.invoices.email', $invoice) }}">Email</a>
@endsection

@section('content')
    <section class="panel">
        <div class="detail-header">
            <h2>{{ $invoice->title }}</h2>
            <p>{{ $invoice->customer?->display_name }} • Status: {{ $invoice->status }}</p>
            <p>Total: <strong>${{ number_format($invoice->total, 2) }}</strong> • Paid: <strong>${{ number_format($invoice->amount_paid, 2) }}</strong> • Balance: <strong>${{ number_format($invoice->balance, 2) }}</strong></p>
        </div>

        @if ($invoice->serviceLocation)
            <p><strong>Location:</strong> {{ $invoice->serviceLocation->location_name ?: $invoice->serviceLocation->address }}</p>
        @endif

        @if ($invoice->estimate)
            <p><strong>From Estimate:</strong> {{ $invoice->estimate->estimate_number }}</p>
        @endif

        @if ($invoice->notes)
            <p>{{ $invoice->notes }}</p>
        @endif
    </section>

    <div style="height:18px"></div>

    <div class="table-card">
        <table class="office-table">
            <thead><tr><th>Description</th><th>Type</th><th>Qty</th><th>Unit</th><th>Total</th><th></th></tr></thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->line_type }}</td>
                        <td>{{ number_format($item->quantity, 2) }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                        <td>
                            <form method="post" action="{{ route('office.invoices.items.destroy', [$invoice, $item]) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr><td colspan="4"><strong>Subtotal</strong></td><td colspan="2">${{ number_format($invoice->subtotal, 2) }}</td></tr>
                <tr><td colspan="4"><strong>Tax</strong></td><td colspan="2">${{ number_format($invoice->tax, 2) }}</td></tr>
                <tr><td colspan="4"><strong>Total</strong></td><td colspan="2"><strong>${{ number_format($invoice->total, 2) }}</strong></td></tr>
                <tr><td colspan="4"><strong>Paid</strong></td><td colspan="2">${{ number_format($invoice->amount_paid, 2) }}</td></tr>
                <tr><td colspan="4"><strong>Balance</strong></td><td colspan="2"><strong>${{ number_format($invoice->balance, 2) }}</strong></td></tr>
            </tbody>
        </table>
    </div>

    <div style="height:18px"></div>

    <form class="form-card" method="post" action="{{ route('office.invoices.items.store', $invoice) }}">
        @csrf
        <h2>Add Line Item</h2>

        <div class="form-grid">
            <div class="field">
                <label>Line Type</label>
                <select name="line_type">
                    <option value="service">Service</option>
                    <option value="labor">Labor</option>
                    <option value="part">Part</option>
                    <option value="equipment">Equipment</option>
                    <option value="trip_charge">Trip Charge</option>
                    <option value="discount">Discount</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="field"><label>Quantity</label><input name="quantity" type="number" step="0.01" value="1" required></div>
            <div class="field"><label>Unit Price</label><input name="unit_price" type="number" step="0.01" value="0.00" required></div>
            <div class="field full"><label>Description</label><textarea name="description" required></textarea></div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Add Item</button>
        </div>
    </form>
@endsection
