@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employees with Role: {{ $role->name }}</h2>
    <table class="table mt-3">
        <tr><th>Name</th><th>Department</th></tr>
        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->department->name }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
