@extends('layouts.office')
@section('title', 'New Work Order | FieldOps Office')
@section('page_title', 'New Work Order')
@section('content')
<form class="form-card" method="post" action="{{ route('office.work-orders.store') }}">@csrf<h2>Service Call & Schedule</h2>@include('office.work-orders._form')</form>
@endsection
