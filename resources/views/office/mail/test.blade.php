@extends('layouts.office')

@section('title', 'Mail Test | FieldOps Office')
@section('page_title', 'Mail Test')

@section('content')
    <section class="panel">
        <h2>Current Mail Settings</h2>

        <div class="table-card">
            <table class="office-table">
                <tbody>
                    <tr>
                        <th>Mailer</th>
                        <td>{{ $mailer ?: 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>SMTP Host</th>
                        <td>{{ $host ?: 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>SMTP Port</th>
                        <td>{{ $port ?: 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>From Address</th>
                        <td>{{ $fromAddress ?: 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>From Name</th>
                        <td>{{ $fromName ?: 'Not set' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="print-note" style="margin-top:18px">
            If this page shows SMTP values but the test does not arrive, the issue is usually SMTP credentials, domain verification, spam filtering, or the provider blocking the send.
        </div>
    </section>

    <div style="height:18px"></div>

    <form class="form-card" method="post" action="{{ route('office.mail-test.send') }}">
        @csrf

        <h2>Send Test Email</h2>

        <div class="form-grid">
            <div class="field">
                <label>Send Test To</label>
                <input name="to" type="email" value="{{ old('to') }}" placeholder="your@email.com" required>
            </div>
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Send Test Email</button>
        </div>
    </form>
@endsection
