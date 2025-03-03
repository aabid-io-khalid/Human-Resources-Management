@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Leave Requests Management</h1>
            <div class="flex items-center space-x-2">
                <a href="{{ route('leave.requests.create') }}" class="bg-white text-blue-600 px-4 py-2 rounded-md hover:bg-blue-50 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Submit Leave Request
                </a>
            </div>
        </div>

        <div class="p-4">
            <div class="flex items-center justify-between mb-4">
                <div class="flex space-x-2">
                    <select id="status-filter" class="form-select block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <select id="leave-type-filter" class="form-select block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">All Leave Types</option>
                        <option value="sick">Sick Leave</option>
                        <option value="vacation">Vacation</option>
                        <option value="emergency">Emergency Leave</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="text" id="search-input" placeholder="Search employees..." class="form-input block w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>
            </div>

            <div class="overflow-x-auto">
                @if($leaveRequests->count() > 0)
                    <table class="w-full" id="leave-requests-table">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($leaveRequests as $request)
                                <tr class="hover:bg-gray-50 transition duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        #{{ $request->id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                <img class="h-10 w-10 rounded-full" 
                                                     src="{{ $request->employee->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($request->employee->name) }}" 
                                                     alt="{{ $request->employee->name }}">
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $request->employee->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $request->employee->department ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($request->leave_type == 'sick') bg-red-100 text-red-800
                                            @elseif($request->leave_type == 'vacation') bg-green-100 text-green-800
                                            @elseif($request->leave_type == 'emergency') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($request->leave_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }} 
                                        - 
                                        {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($request->start_date)->diffInDays(\Carbon\Carbon::parse($request->end_date)) + 1 }} days
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($request->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->status == 'approved') bg-green-100 text-green-800
                                            @elseif($request->status == 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-2">
                                        @if($request->status == 'pending')
                                            <form action="{{ route('hr.leave.approve', $request->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 
                                                    bg-green-100 hover:bg-green-200 px-3 py-1 rounded-md 
                                                    transition duration-300 flex items-center">
                                                    Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('hr.leave.reject', $request->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900 
                                                    bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md 
                                                    transition duration-300 flex items-center">
                                                    Reject
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">No Actions</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-12 px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">No Leave Requests</h3>
                        <p class="text-gray-400 text-center">There are no leave requests at the moment.</p>
                    </div>
                @endif
            </div>
        </div>

        @if($leaveRequests->hasPages())
            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                {{ $leaveRequests->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('status-filter');
    const leaveTypeFilter = document.getElementById('leave-type-filter');
    const searchInput = document.getElementById('search-input');
    const table = document.getElementById('leave-requests-table');
    const rows = table.querySelectorAll('tbody tr');

    function filterTable() {
        const statusValue = statusFilter.value.toLowerCase();
        const leaveTypeValue = leaveTypeFilter.value.toLowerCase();
        const searchValue = searchInput.value.toLowerCase();

        rows.forEach(row => {
            const statusCell = row.querySelector('td:nth-child(6) span');
            const leaveTypeCell = row.querySelector('td:nth-child(3) span');
            const employeeCell = row.querySelector('td:nth-child(2) .text-sm.font-medium');

            const statusMatch = statusValue === '' || statusCell.textContent.toLowerCase().includes(statusValue);
            const leaveTypeMatch = leaveTypeValue === '' || leaveTypeCell.textContent.toLowerCase().includes(leaveTypeValue);
            const searchMatch = searchValue === '' || employeeCell.textContent.toLowerCase().includes(searchValue);

            row.style.display = statusMatch && leaveTypeMatch && searchMatch ? '' : 'none';
        });
    }

    statusFilter.addEventListener('change', filterTable);
    leaveTypeFilter.addEventListener('change', filterTable);
    searchInput.addEventListener('input', filterTable);
});
</script>
@endsection