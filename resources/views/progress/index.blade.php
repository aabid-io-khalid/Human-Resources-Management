@extends('layouts.app')

@section('content')
<h2>Employee Progress</h2>
<ul>
    @foreach($progress as $event)
    <li>
        <!-- Check if employee exists before accessing the name -->
        {{ $event->employee ? $event->employee->name : 'No Employee' }} - 
        {{ $event->type }}: {{ $event->description }} ({{ $event->date }})
    </li>
    @endforeach
</ul>
@endsection
