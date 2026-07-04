<!doctype html>
<html>
<body style="font-family:Arial,sans-serif;color:#111827;line-height:1.5">
    <p>{!! nl2br(e($bodyMessage)) !!}</p>

    <hr>

    <h2 style="margin-bottom:4px">Loudon Mechanical Services</h2>
    <p style="margin-top:0;color:#64748b">HVAC • Refrigeration • Ice Machines • Restaurant Equipment</p>

    <h3>Invoice {{ $invoice->invoice_number }}</h3>
    <p><strong>Customer:</strong> {{ $invoice->customer?->display_name }}</p>
    <p><strong>Title:</strong> {{ $invoice->title }}</p>

    @if ($invoice->serviceLocation)
        <p><strong>Service Location:</strong> {{ $invoice->serviceLocation->location_name ?: $invoice->serviceLocation->address }} — {{ $invoice->serviceLocation->address }}, {{ $invoice->serviceLocation->city }}</p>
    @endif

    @if ($invoice->notes)
        <p><strong>Notes:</strong> {{ $invoice->notes }}</p>
    @endif

    <table width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;border:1px solid #e5e7eb">
        <thead>
            <tr style="background:#f8fafc">
                <th align="left">Description</th>
                <th align="right">Qty</th>
                <th align="right">Unit</th>
                <th align="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td style="border-top:1px solid #e5e7eb">{{ $item->description }}</td>
                    <td align="right" style="border-top:1px solid #e5e7eb">{{ number_format($item->quantity, 2) }}</td>
                    <td align="right" style="border-top:1px solid #e5e7eb">${{ number_format($item->unit_price, 2) }}</td>
                    <td align="right" style="border-top:1px solid #e5e7eb">${{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p align="right"><strong>Subtotal:</strong> ${{ number_format($invoice->subtotal, 2) }}</p>
    <p align="right"><strong>Tax:</strong> ${{ number_format($invoice->tax, 2) }}</p>
    <p align="right"><strong>Total:</strong> ${{ number_format($invoice->total, 2) }}</p>
    <p align="right"><strong>Paid:</strong> ${{ number_format($invoice->amount_paid, 2) }}</p>
    <p align="right" style="font-size:20px"><strong>Balance:</strong> ${{ number_format($invoice->balance, 2) }}</p>

    <p>Questions? Call Loudon Mechanical Services at <strong>865-964-6348</strong>.</p>
</body>
</html>
