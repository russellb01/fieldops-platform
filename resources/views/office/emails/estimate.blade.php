<!doctype html>
<html>
<body style="font-family:Arial,sans-serif;color:#111827;line-height:1.5">
    <p>{!! nl2br(e($bodyMessage)) !!}</p>

    <hr>

    <h2 style="margin-bottom:4px">Loudon Mechanical Services</h2>
    <p style="margin-top:0;color:#64748b">HVAC • Refrigeration • Ice Machines • Restaurant Equipment</p>

    <h3>Estimate {{ $estimate->estimate_number }}</h3>
    <p><strong>Customer:</strong> {{ $estimate->customer?->display_name }}</p>
    <p><strong>Title:</strong> {{ $estimate->title }}</p>

    @if ($estimate->serviceLocation)
        <p><strong>Service Location:</strong> {{ $estimate->serviceLocation->location_name ?: $estimate->serviceLocation->address }} — {{ $estimate->serviceLocation->address }}, {{ $estimate->serviceLocation->city }}</p>
    @endif

    @if ($estimate->issue_summary)
        <p><strong>Issue:</strong> {{ $estimate->issue_summary }}</p>
    @endif

    @if ($estimate->scope_of_work)
        <p><strong>Scope:</strong> {{ $estimate->scope_of_work }}</p>
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
            @foreach ($estimate->items as $item)
                <tr>
                    <td style="border-top:1px solid #e5e7eb">{{ $item->description }}</td>
                    <td align="right" style="border-top:1px solid #e5e7eb">{{ number_format($item->quantity, 2) }}</td>
                    <td align="right" style="border-top:1px solid #e5e7eb">${{ number_format($item->unit_price, 2) }}</td>
                    <td align="right" style="border-top:1px solid #e5e7eb">${{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p align="right"><strong>Subtotal:</strong> ${{ number_format($estimate->subtotal, 2) }}</p>
    <p align="right"><strong>Tax:</strong> ${{ number_format($estimate->tax, 2) }}</p>
    <p align="right" style="font-size:20px"><strong>Total:</strong> ${{ number_format($estimate->total, 2) }}</p>

    <p>Questions? Call Loudon Mechanical Services at <strong>865-964-6348</strong>.</p>
</body>
</html>
