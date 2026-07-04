@extends('layouts.office')

@section('title', 'Email Estimate | FieldOps Office')
@section('page_title', 'Email Estimate')

@section('top_actions')
    <a class="btn btn-secondary" href="{{ route('office.estimates.show', $estimate) }}">Back to Estimate</a>
@endsection

@section('content')
    <form class="form-card" method="post" action="{{ route('office.estimates.email.send', $estimate) }}">
        @csrf
        <h2>Email {{ $estimate->estimate_number }}</h2>

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
            The estimate details and line items will be included in the email body. If emails do not arrive, SMTP mail settings need to be configured.
        </div>

        <div style="margin-top:18px">
            <button class="btn btn-primary" type="submit">Send Estimate Email</button>
        </div>
    </form>
@endsection
