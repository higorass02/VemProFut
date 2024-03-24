<!-- resources/views/customers/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Edit Customer</h1>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $customer->name }}" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="{{ $customer->phone }}" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ $customer->email }}" required>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('customers.index') }}">Back to List</a>
@endsection
