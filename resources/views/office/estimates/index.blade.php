@extends('layouts.office')

@section('title', 'Estimates | FieldOps Office')
@section('page_title', 'Estimates')

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.estimates.create') }}">New Estimate</a>
@endsection

@section('content')
    <div class="table-card">
        <table class="office-table">
            <thead>
                <tr>
                    <th>Estimate</th>
                    <th>Customer</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($estimates as $estimate)
                    <tr>
                        <td><a href="{{ route('office.estimates.show', $estimate) }}"><strong>{{ $estimate->estimate_number }}</strong></a></td>
                        <td>{{ $estimate->customer?->display_name }}</td>
                        <td>{{ $estimate->title }}</td>
                        <td><span class="badge">{{ $estimate->status }}</span></td>
                        <td>${{ number_format($estimate->total, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">No estimates yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px">{{ $estimates->links() }}</div>
@endsection
