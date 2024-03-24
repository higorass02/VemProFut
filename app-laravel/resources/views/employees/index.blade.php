<!-- resources/views/employees/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Employee List</h1>

    <!-- Display a table with employee data -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>
                    <a href="{{ route('employees.show', $employee->id) }}">View</a>
                    <a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('employees.create') }}">Create New Employee</a>
@endsection
