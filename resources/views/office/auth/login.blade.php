<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>FieldOps Office Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <link rel="stylesheet" href="/css/fieldops-office.css?v=office-foundation-20260703">
</head>
<body class="login-page">
    <form class="login-card" method="post" action="{{ route('office.login.store') }}">
        @csrf
        <h1>FieldOps Office</h1>
        <p>Enter the office PIN to manage LMS customers, estimates, invoices, equipment, and PM contracts.</p>

        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="errors">{{ $errors->first() }}</div>
        @endif

        <div class="field">
            <label for="pin">Office PIN</label>
            <input id="pin" name="pin" type="password" autocomplete="current-password" required autofocus>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit" style="width:100%">Enter Office</button>
        </div>
    </form>
</body>
</html>
