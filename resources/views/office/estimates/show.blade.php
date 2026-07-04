@extends('layouts.office')

@section('title', $estimate->estimate_number . ' | FieldOps Office')
@section('page_title', $estimate->estimate_number)

@section('content')
    <section class="panel">
        <div class="detail-header">
            <h2>{{ $estimate->title }}</h2>
            <p>{{ $estimate->customer?->display_name }} • Status: {{ $estimate->status }}</p>
            <p>Total: <strong>${{ number_format($estimate->total, 2) }}</strong></p>
        </div>

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
            <thead><tr><th>Description</th><th>Qty</th><th>Unit</th><th>Total</th></tr></thead>
            <tbody>
                @foreach ($estimate->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ number_format($item->quantity, 2) }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
                <tr><td colspan="3"><strong>Subtotal</strong></td><td>${{ number_format($estimate->subtotal, 2) }}</td></tr>
                <tr><td colspan="3"><strong>Tax</strong></td><td>${{ number_format($estimate->tax, 2) }}</td></tr>
                <tr><td colspan="3"><strong>Total</strong></td><td><strong>${{ number_format($estimate->total, 2) }}</strong></td></tr>
            </tbody>
        </table>
    </div>
@endsection
