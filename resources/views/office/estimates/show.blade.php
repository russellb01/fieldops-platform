@extends('layouts.office')

@section('title', $estimate->estimate_number . ' | FieldOps Office')
@section('page_title', $estimate->estimate_number)

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.estimates.edit', $estimate) }}">Edit</a>
    <a class="btn btn-secondary" href="{{ route('office.estimates.print', $estimate) }}" target="_blank">Print</a>
    <a class="btn btn-secondary" href="{{ route('office.estimates.email', $estimate) }}">Email</a>
    <form method="post" action="{{ route('office.estimates.convert-to-invoice', $estimate) }}">
        @csrf
        <button class="btn btn-secondary" type="submit">Convert to Invoice</button>
    </form>
@endsection

@section('content')
    <section class="panel">
        <div class="detail-header">
            <h2>{{ $estimate->title }}</h2>
            <p>{{ $estimate->customer?->display_name }} • Status: {{ $estimate->status }}</p>
            <p>Total: <strong>${{ number_format($estimate->total, 2) }}</strong></p>
        </div>

        @if ($estimate->serviceLocation)
            <p><strong>Location:</strong> {{ $estimate->serviceLocation->location_name ?: $estimate->serviceLocation->address }}</p>
        @endif

        @if ($estimate->issue_summary)
            <p><strong>Issue:</strong> {{ $estimate->issue_summary }}</p>
        @endif

        @if ($estimate->scope_of_work)
            <p><strong>Scope:</strong> {{ $estimate->scope_of_work }}</p>
        @endif
    </section>

    <div style="height:18px"></div>

    <div class="table-card">
        <table class="office-table">
            <thead><tr><th>Description</th><th>Type</th><th>Qty</th><th>Unit</th><th>Total</th><th></th></tr></thead>
            <tbody>
                @foreach ($estimate->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->line_type }}</td>
                        <td>{{ number_format($item->quantity, 2) }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                        <td>
                            <form method="post" action="{{ route('office.estimates.items.destroy', [$estimate, $item]) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr><td colspan="4"><strong>Subtotal</strong></td><td colspan="2">${{ number_format($estimate->subtotal, 2) }}</td></tr>
                <tr><td colspan="4"><strong>Tax</strong></td><td colspan="2">${{ number_format($estimate->tax, 2) }}</td></tr>
                <tr><td colspan="4"><strong>Total</strong></td><td colspan="2"><strong>${{ number_format($estimate->total, 2) }}</strong></td></tr>
            </tbody>
        </table>
    </div>

    <div style="height:18px"></div>

    <form class="form-card" method="post" action="{{ route('office.estimates.items.store', $estimate) }}">
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
