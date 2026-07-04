@extends('layouts.office')

@section('title', 'PM Contracts | FieldOps Office')
@section('page_title', 'PM Contracts')

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.pm-contracts.create') }}">New PM Contract</a>
@endsection

@section('content')
    <div class="table-card">
        <table class="office-table">
            <thead>
                <tr>
                    <th>Contract</th>
                    <th>Customer</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Frequency</th>
                    <th>Next Service</th>
                    <th>Annual Value</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contracts as $contract)
                    <tr>
                        <td><strong>{{ $contract->contract_number }}</strong></td>
                        <td>{{ $contract->customer?->display_name }}</td>
                        <td>{{ $contract->title }}</td>
                        <td><span class="badge green">{{ $contract->status }}</span></td>
                        <td>{{ ucfirst($contract->frequency) }}</td>
                        <td>{{ optional($contract->next_service_date)->format('m/d/Y') ?: 'Not set' }}</td>
                        <td>${{ number_format($contract->annual_value, 2) }}</td>
                        <td><a class="btn btn-secondary" href="{{ route('office.pm-contracts.edit', $contract) }}">Edit</a></td>
                    </tr>
                @empty
                    <tr><td colspan="8">No PM contracts yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px">{{ $contracts->links() }}</div>
@endsection
