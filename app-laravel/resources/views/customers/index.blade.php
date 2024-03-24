<!-- resources/views/customers/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Customer List</h1>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                    <a href="{{ route('customers.show', $customer->id) }}">View</a>
                    <a href="{{ route('customers.edit', $customer->id) }}">Edit</a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('customers.create') }}">Create New Customer</a>
@endsection
