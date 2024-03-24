<!-- resources/views/employees/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Create New Employee</h1>

    <!-- Form to create a new employee -->
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Save</button>
    </form>

    <a href="{{ route('employees.index') }}">Back to List</a>
@endsection
