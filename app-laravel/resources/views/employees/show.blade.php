<!-- resources/views/employees/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Employee Details</h1>

    <p><strong>Name:</strong> {{ $employee->name }}</p>
    <p><strong>Email:</strong> {{ $employee->email }}</p>

    <a href="{{ route('employees.index') }}">Back to List</a>
@endsection
