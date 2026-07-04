@extends('layouts.office')

@section('title', 'Email Invoice | FieldOps Office')
@section('page_title', 'Email Invoice')

@section('top_actions')
    <a class="btn btn-secondary" href="{{ route('office.invoices.show', $invoice) }}">Back to Invoice</a>
@endsection

@section('content')
    <form class="form-card" method="post" action="{{ route('office.invoices.email.send', $invoice) }}">
        @csrf
        <h2>Email {{ $invoice->invoice_number }}</h2>

        <div class="form-grid">
            <div class="field">
                <label>To</label>
                <input name="to" type="email" value="{{ old('to', $defaultTo) }}" required>
            </div>

            <div class="field">
                <label>Subject</label>
                <input name="subject" value="{{ old('subject', $defaultSubject) }}" required>
            </div>

            <div class="field full">
                <label>Message</label>
                <textarea name="message" required>{{ old('message', $defaultMessage) }}</textarea>
            </div>
        </div>

        <div class="print-note" style="margin-top:18px">
            The invoice details, line items, totals, paid amount, and balance will be included in the email body. If emails do not arrive, SMTP mail settings need to be configured.
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Send Invoice Email</button>
        </div>
    </form>
@endsection
