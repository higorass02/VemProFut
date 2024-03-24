<!-- resources/views/customers/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create New Customer</h1>

    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <button type="submit">Save</button>
    </form>

    <a href="{{ route('customers.index') }}">Back to List</a>
@endsection
