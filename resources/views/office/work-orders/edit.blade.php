@extends('layouts.office')
@section('title', 'Edit '.$workOrder->work_order_number.' | FieldOps Office')
@section('page_title', 'Edit '.$workOrder->work_order_number)
@section('content')
<form class="form-card" method="post" action="{{ route('office.work-orders.update', $workOrder) }}">@csrf @method('PUT')<h2>Work Order Details</h2>@include('office.work-orders._form')</form>
@endsection
