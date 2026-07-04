<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $estimate->estimate_number }} | Loudon Mechanical Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <style>
        body { font-family: Arial, sans-serif; color:#111827; margin:0; background:#f3f6fb; }
        .page { width:min(900px, calc(100% - 32px)); margin:24px auto; background:#fff; padding:42px; border-radius:18px; box-shadow:0 20px 70px rgba(0,0,0,.10); }
        .top { display:flex; justify-content:space-between; gap:24px; border-bottom:4px solid #ff7a1a; padding-bottom:22px; margin-bottom:24px; }
        h1,h2,h3,p { margin-top:0; }
        h1 { font-size:34px; letter-spacing:-.04em; margin-bottom:4px; }
        .muted { color:#637084; }
        .meta { text-align:right; }
        .grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; margin:24px 0; }
        .box { border:1px solid #e5e7eb; border-radius:14px; padding:18px; }
        table { width:100%; border-collapse:collapse; margin-top:22px; }
        th,td { padding:12px; border-bottom:1px solid #e5e7eb; text-align:left; vertical-align:top; }
        th { font-size:12px; text-transform:uppercase; letter-spacing:.08em; color:#637084; }
        .totals { width:min(340px,100%); margin-left:auto; margin-top:20px; }
        .totals div { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #e5e7eb; }
        .total { font-size:22px; font-weight:bold; }
        .actions { text-align:center; margin:18px; }
        .btn { display:inline-block; padding:10px 14px; border-radius:999px; background:#0e8fe8; color:white; text-decoration:none; font-weight:bold; border:0; cursor:pointer; }
        @media print { body { background:#fff; } .page { box-shadow:none; width:auto; margin:0; border-radius:0; } .actions { display:none; } }
    </style>
</head>
<body>
    <div class="actions"><button class="btn" onclick="window.print()">Print Estimate</button></div>
    <div class="page">
        <div class="top">
            <div>
                <h1>Loudon Mechanical Services</h1>
                <p class="muted">HVAC • Refrigeration • Ice Machines • Restaurant Equipment</p>
                <p><strong>Phone:</strong> 865-964-6348</p>
            </div>
            <div class="meta">
                <h2>Estimate</h2>
                <p><strong>{{ $estimate->estimate_number }}</strong></p>
                <p>Status: {{ ucfirst($estimate->status) }}</p>
                @if ($estimate->valid_until)
                    <p>Valid Until: {{ $estimate->valid_until->format('m/d/Y') }}</p>
                @endif
            </div>
        </div>

        <div class="grid">
            <div class="box">
                <h3>Customer</h3>
                <p><strong>{{ $estimate->customer?->display_name }}</strong></p>
                <p>{{ $estimate->customer?->phone }}</p>
                <p>{{ $estimate->customer?->email }}</p>
            </div>
            <div class="box">
                <h3>Service Location</h3>
                @if ($estimate->serviceLocation)
                    <p>{{ $estimate->serviceLocation->location_name }}</p>
                    <p>{{ $estimate->serviceLocation->address }}</p>
                    <p>{{ $estimate->serviceLocation->city }} {{ $estimate->serviceLocation->state }} {{ $estimate->serviceLocation->postal_code }}</p>
                @else
                    <p class="muted">No service location selected.</p>
                @endif
            </div>
        </div>

        <h2>{{ $estimate->title }}</h2>

        @if ($estimate->issue_summary)
            <p><strong>Issue Summary:</strong> {{ $estimate->issue_summary }}</p>
        @endif

        @if ($estimate->scope_of_work)
            <p><strong>Scope of Work:</strong> {{ $estimate->scope_of_work }}</p>
        @endif

        <table>
            <thead>
                <tr><th>Description</th><th>Qty</th><th>Unit</th><th>Total</th></tr>
            </thead>
            <tbody>
                @foreach ($estimate->items as $item)
                    <tr>
                        <td>{{ $item->description }}</td>
                        <td>{{ number_format($item->quantity, 2) }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div><span>Subtotal</span><strong>${{ number_format($estimate->subtotal, 2) }}</strong></div>
            <div><span>Tax</span><strong>${{ number_format($estimate->tax, 2) }}</strong></div>
            <div class="total"><span>Total</span><strong>${{ number_format($estimate->total, 2) }}</strong></div>
        </div>

        <p class="muted" style="margin-top:32px">Estimate terms and availability may vary. Financing, if discussed, is subject to approval and provider terms. LMS is not a lender.</p>
    </div>
</body>
</html>
