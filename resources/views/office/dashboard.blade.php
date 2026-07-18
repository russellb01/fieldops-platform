@extends('layouts.office')

@section('title', 'FieldOps Office Dashboard')
@section('page_title', 'Dashboard')

@section('top_actions')
    <a class="btn btn-primary" href="{{ route('office.customers.create') }}">Add Customer</a>
    <a class="btn btn-primary" href="{{ route('office.work-orders.create') }}">New Work Order</a>
    <a class="btn btn-secondary" href="{{ route('office.estimates.create') }}">New Estimate</a>
    <a class="btn btn-secondary" href="{{ route('office.invoices.create') }}">New Invoice</a>
@endsection

@section('content')
    <div class="stats-grid">
        <div class="stat-card"><strong>{{ $openWorkOrderCount }}</strong><span>Open Work Orders</span></div>
        <div class="stat-card"><strong>{{ $customerCount }}</strong><span>Customers</span></div>
        <div class="stat-card"><strong>{{ $equipmentCount }}</strong><span>Equipment Assets</span></div>
        <div class="stat-card"><strong>{{ $estimateCount }}</strong><span>Estimates</span></div>
        <div class="stat-card"><strong>{{ $invoiceCount }}</strong><span>Invoices</span></div>
        <div class="stat-card"><strong>{{ $pmCount }}</strong><span>PM Contracts</span></div>
    </div>

    <section class="panel" style="margin-bottom:18px">
        <h2>Service Schedule</h2>
        <div class="office-grid">
            @forelse ($scheduledWorkOrders as $workOrder)
                <a class="badge {{ $workOrder->priority === 'emergency' ? 'red' : ($workOrder->priority === 'high' ? 'orange' : '') }}" href="{{ route('office.work-orders.show', $workOrder) }}">
                    {{ $workOrder->scheduled_start?->format('m/d/Y g:i A') ?: 'Unscheduled' }} — {{ $workOrder->work_order_number }} — {{ $workOrder->customer?->display_name }} — {{ $workOrder->title }}
                </a>
            @empty
                <p>No open work orders yet.</p>
            @endforelse
        </div>
    </section>

    <div class="two-col">
        <section class="panel">
            <h2>Recent Customers</h2>
            <div class="office-grid">
                @forelse ($recentCustomers as $customer)
                    <a class="badge" href="{{ route('office.customers.show', $customer) }}">{{ $customer->display_name }}</a>
                @empty
                    <p>No customers yet. Start by adding your first LMS customer.</p>
                @endforelse
            </div>
        </section>

        <section class="panel">
            <h2>Recent Invoices</h2>
            <div class="office-grid">
                @forelse ($recentInvoices as $invoice)
                    <a class="badge orange" href="{{ route('office.invoices.show', $invoice) }}">
                        {{ $invoice->invoice_number }} — {{ $invoice->customer?->display_name }} — ${{ number_format($invoice->total, 2) }}
                    </a>
                @empty
                    <p>No invoices yet.</p>
                @endforelse
            </div>
        </section>
    </div>

    <div style="height:18px"></div>

    <section class="panel">
        <h2>Upcoming PM Contracts</h2>
        <div class="office-grid">
            @forelse ($upcomingPm as $pm)
                <span class="badge green">
                    {{ $pm->contract_number }} — {{ $pm->customer?->display_name }} — Next: {{ optional($pm->next_service_date)->format('m/d/Y') ?: 'Not set' }}
                </span>
            @empty
                <p>No PM contracts scheduled yet.</p>
            @endforelse
        </div>
    </section>
@endsection
