@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
            <h1 class="text-3xl font-bold text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Team Leave Requests
            </h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                    <tr>
                        @php 
                        $headers = ['ID', 'Employee Name', 'Leave Type', 'Start Date', 'End Date', 'Status', 'Actions'];
                        @endphp
                        @foreach($headers as $header)
                            <th class="p-3 text-sm font-semibold tracking-wide text-left">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($leaveRequests as $request)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="p-3 text-sm text-gray-700">{{ $request->id }}</td>
                            <td class="p-3 text-sm text-gray-700">
                                <div class="flex items-center">
                                    <div class="bg-blue-100 text-blue-800 p-2 rounded-full mr-2 w-10 h-10 flex items-center justify-center">
                                        {{ substr($request->employee->name, 0, 1) }}
                                    </div>
                                    {{ $request->employee->name }}
                                </div>
                            </td>
                            <td class="p-3 text-sm text-gray-700">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                    {{ $request->leave_type }}
                                </span>
                            </td>
                            <td class="p-3 text-sm text-gray-700">{{ $request->start_date }}</td>
                            <td class="p-3 text-sm text-gray-700">{{ $request->end_date }}</td>
                            <td class="p-3 text-sm">
                                @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                                $color = $statusColors[$request->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="{{ $color }} px-2 py-1 rounded-full text-xs">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td class="p-3 text-sm">
                                @if($request->status == 'pending')
                                    <div class="flex space-x-2">
                                        <form action="{{ route('manager.leave.approve', $request->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md transition duration-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('manager.leave.reject', $request->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md transition duration-300 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($leaveRequests->isEmpty())
            <div class="text-center p-6 bg-gray-50">
                <p class="text-gray-600">No leave requests found.</p>
            </div>
        @endif
    </div>
</div>
@endsection