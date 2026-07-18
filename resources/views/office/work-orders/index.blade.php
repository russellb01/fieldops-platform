@extends('layouts.office')
@section('title', 'Work Orders | FieldOps Office')
@section('page_title', 'Work Orders & Schedule')
@section('top_actions')<a class="btn btn-primary" href="{{ route('office.work-orders.create') }}">New Work Order</a>@endsection
@section('content')
<form class="search-row" method="get"><input name="q" value="{{ request('q') }}" placeholder="Search work order, customer, or title"><select name="status"><option value="">All statuses</option>@foreach(['new','scheduled','dispatched','in_progress','on_hold','completed','cancelled'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucwords(str_replace('_',' ',$status)) }}</option>@endforeach</select><button class="btn btn-secondary">Filter</button></form>
<div class="table-card"><table class="office-table"><thead><tr><th>Schedule</th><th>Work Order</th><th>Customer</th><th>Status</th><th>Priority</th><th>Assigned</th></tr></thead><tbody>@forelse($workOrders as $workOrder)<tr><td>{{ $workOrder->scheduled_start?->format('m/d/Y g:i A') ?: 'Unscheduled' }}</td><td><a href="{{ route('office.work-orders.show',$workOrder) }}"><strong>{{ $workOrder->work_order_number }}</strong><br>{{ $workOrder->title }}</a></td><td>{{ $workOrder->customer?->display_name }}</td><td><span class="badge">{{ ucwords(str_replace('_',' ',$workOrder->status)) }}</span></td><td><span class="badge {{ $workOrder->priority === 'emergency' ? 'red' : ($workOrder->priority === 'high' ? 'orange' : '') }}">{{ ucfirst($workOrder->priority) }}</span></td><td>{{ $workOrder->assigned_to ?: 'Unassigned' }}</td></tr>@empty<tr><td colspan="6">No work orders yet. Create the first LMS service call.</td></tr>@endforelse</tbody></table></div>
<div style="margin-top:18px">{{ $workOrders->links() }}</div>
@endsection
