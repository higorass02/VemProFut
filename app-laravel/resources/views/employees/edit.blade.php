<!-- resources/views/employees/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Edit Employee</h1>

    <!-- Form to edit an existing employee -->
    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $employee->name }}" required>

        <label for="email">Email:</label>
        <input type="email" name="email" value="{{ $employee->email }}" required>

        <label for="password">Password:</label>
        <input type="password" name="password">

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('employees.index') }}">Back to List</a>
@endsection
