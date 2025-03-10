@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Management</h2>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
    <table class="table mt-3">
        <tr>
            <th>Name</th><th>Email</th><th>Role</th><th>Actions</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->roles->pluck('name')->first() }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
