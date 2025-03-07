@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex flex-col">
        <!-- Title Section -->
        <div class="mb-4">
            <h1 class="text-2xl font-semibold flex items-center gap-2">
                <i class="fas fa-calendar-plus text-primary"></i> Submit Leave Request
            </h1>
        </div>

        <!-- Display Leave Balance -->
        @if($leaveBalance)
            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <h4 class="text-lg font-bold">Your Leave Balance</h4>
                <p>Total Leave Days: {{ $leaveBalance->total_leave_days }}</p>
                <p>Used Leave Days: {{ $leaveBalance->used_leave_days }}</p>
                <p>Remaining Leave Days: {{ $leaveBalance->remaining_leave_days }}</p>
            </div>
        @else
            <div class="bg-red-100 p-4 rounded-lg mb-4">
                <p class="text-red-600">Leave balance information not available.</p>
            </div>
        @endif

        <!-- Leave Request Form -->
        <div class="bg-white shadow-md rounded-lg mb-5">
            <div class="bg-blue-500 text-white py-3 px-4 rounded-t-lg">
                <h4 class="mb-0 flex items-center">
                    <i class="fas fa-file-alt mr-2"></i> Leave Request Form
                </h4>
            </div>
            <div class="p-4">
                <form action="{{ route('leave.requests.store') }}" method="POST" id="leaveRequestForm">
                    @csrf
                    
                    <!-- Employee ID (auto-populated) -->
                    <input type="hidden" name="employee_id" value="{{ auth()->id() }}">
                    
                    <div class="mb-4">
                        <!-- Leave Type -->
                        <label for="leave_type" class="block font-bold">Leave Type</label>
                        <select 
                            name="leave_type" 
                            id="leave_type" 
                            required 
                            class="form-select rounded border-gray-300 shadow-sm"
                        >
                            <option value="">Select Leave Type</option>
                            <option value="sick">Sick Leave</option>
                            <option value="vacation">Vacation</option>
                            <option value="emergency">Emergency Leave</option>
                        </select>
                        @error('leave_type')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Date -->
                        <div class="mb-4">
                            <label for="start_date" class="block font-bold">Start Date</label>
                            <input type="date" name="start_date" id="start_date" required class="form-input rounded border-gray-300 shadow-sm">
                            @error('start_date')
                                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="mb-4">
                            <label for="end_date" class="block font-bold">End Date</label>
                            <input type="date" name="end_date" id="end_date" required class="form-input rounded border-gray-300 shadow-sm">
                            @error('end_date')
                                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Reason for Leave -->
                    <div class="mb-4">
                        <label for="reason" class="block font-bold">Reason for Leave</label>
                        <textarea 
                            name="reason" 
                            id="reason" 
                            rows="4" 
                            required 
                            class="form-textarea rounded border-gray-300 shadow-sm"
                            placeholder="Briefly explain the reason for your leave request"
                        ></textarea>
                        @error('reason')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Hidden Status Field -->
                    <input type="hidden" name="status" value="pending">

                    <!-- Submit Button -->
                    <div class="text-right">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow-sm hover:bg-blue-600 transition">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Leave Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Leave History Section -->
        <div class="bg-white shadow-md rounded-lg">
            <div class="bg-gray-200 text-gray-800 py-3 px-4 rounded-t-lg">
                <h4 class="mb-0 flex items-center">
                    <i class="fas fa-history mr-2"></i> Leave History
                </h4>
            </div>
            <div class="p-4">
                @if($leaveRequests->isEmpty())
                    <p class="text-gray-500">No previous leave requests found.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($leaveRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($request->leave_type) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($leaveRequests->hasPages())
                        <div class="mt-4">
                            {{ $leaveRequests->links('pagination::tailwind') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    // Restrict date selection to future dates
    const today = new Date().toISOString().split('T')[0];
    startDateInput.setAttribute('min', today);
    endDateInput.setAttribute('min', today);

    // Remove any totalDays references since the DB does not have that column

    // Form validation with improved UX
    document.getElementById('leaveRequestForm').addEventListener('submit', function(e) {
        const leaveType = document.getElementById('leave_type').value;
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        const reason = document.getElementById('reason').value.trim();

        if (!leaveType || !startDate || !endDate || !reason) {
            e.preventDefault();
            
            let missingFields = [];
            if (!leaveType) missingFields.push('Leave Type');
            if (!startDate) missingFields.push('Start Date');
            if (!endDate) missingFields.push('End Date');
            if (!reason) missingFields.push('Reason for Leave');

            Swal.fire({
                icon: 'warning',
                title: 'Missing Information',
                html: `Please complete the following required fields: <br><strong>${missingFields.join(', ')}</strong>`,
                confirmButtonColor: '#3085d6'
            });
            return;
        }
        
        Swal.fire({
            title: 'Submitting Request...',
            html: 'Please wait while we process your leave request.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });
});
</script>
@endpush
