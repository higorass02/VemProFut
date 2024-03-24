<!-- resources/views/customers/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Customer Details</h1>

    <p><strong>Name:</strong> {{ $customer->name }}</p>
    <p><strong>Phone:</strong> {{ $customer->phone }}</p>
    <p><strong>Address:</strong> {{ $customer->address }}</p>

    <a href="{{ route('customers.index') }}">Back to List</a>
@endsection
