<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'FieldOps Office')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="/css/fieldops-office.css?v=office-foundation-20260703">
</head>
<body>
    <div class="office-shell">
        <aside class="office-sidebar">
            <a class="office-brand" href="{{ route('office.dashboard') }}">
                <strong>FieldOps Office</strong>
                <span>Loudon Mechanical Services</span>
            </a>

            <nav class="office-nav">
                <a href="{{ route('office.dashboard') }}">Dashboard</a>
                <a href="{{ route('office.customers.index') }}">Customers</a>
                <a href="{{ route('office.customers.create') }}">Add Customer</a>
                <a href="{{ route('office.estimates.index') }}">Estimates</a>
                <a href="{{ route('office.estimates.create') }}">New Estimate</a>
                <a href="{{ route('office.invoices.index') }}">Invoices</a>
                <a href="{{ route('office.invoices.create') }}">New Invoice</a>
                <a href="{{ route('office.pm-contracts.index') }}">PM Contracts</a>
                <a href="{{ route('office.pm-contracts.create') }}">New PM Contract</a>
                <a href="/" target="_blank">Public Site</a>
                <form method="post" action="{{ route('office.logout') }}">
                    @csrf
                    <button type="submit">Sign Out</button>
                </form>
            </nav>
        </aside>

        <main class="office-main">
            <header class="office-topbar">
                <h1>@yield('page_title', 'FieldOps Office')</h1>
                <div class="actions">
                    @yield('top_actions')
                </div>
            </header>

            <div class="office-content">
                @if (session('success'))
                    <div class="flash">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="errors">
                        <strong>Please fix the following:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
