<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    public function create()
    {
        $managers = Employee::whereHas('role', function ($query) {
            $query->where('name', 'Manager');
        })->get(['id', 'name']);

        $employee = Employee::where('user_id', auth()->id())->first();
        $leaveRequests = $employee ? LeaveRequest::where('employee_id', $employee->id)->paginate(10) : collect();

        $leaveBalance = $employee ? LeaveBalance::where('employee_id', $employee->id)->first() : null;

        return view('leave.create', compact('managers', 'leaveRequests', 'leaveBalance'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type'  => 'required|string',
            'start_date'  => 'required|date|after_or_equal:today',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'reason'      => 'required|string',
        ]);

        $employee = Employee::where('user_id', auth()->id())->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee record not found.');
        }

        $leaveBalance = LeaveBalance::where('employee_id', $employee->id)->first();
        if (!$leaveBalance) {
            return redirect()->back()->with('error', 'No leave balance found.');
        }

        $requestedDays = Carbon::parse($request->start_date)->diffInDays(Carbon::parse($request->end_date)) + 1;

        if ($leaveBalance->remaining_leave_days < $requestedDays) {
            return redirect()->back()->with('error', 'Insufficient leave balance.');
        }

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type'  => $request->leave_type,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'reason'      => $request->reason,
            'status'      => 'pending',
        ]);

        return redirect()->route('leave.requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function updateAnnualLeaveBalance()
    {
        $employees = Employee::all();
        foreach ($employees as $employee) {
            $leaveBalance = LeaveBalance::firstOrCreate(
                ['employee_id' => $employee->id],
                ['total_leave_days' => 18, 'used_leave_days' => 0, 'remaining_leave_days' => 18]
            );

            $lastUpdate = $leaveBalance->updated_at;
            if (!$lastUpdate || $lastUpdate->diffInYears(now()) >= 1) {
                $leaveBalance->total_leave_days += 18; 
                $leaveBalance->remaining_leave_days += 18;
                $leaveBalance->save();
            }
        }
    }

    public function index()
    {
        $employee = Employee::where('user_id', Auth::id())->first();
        $leaveRequests = $employee ? LeaveRequest::where('employee_id', $employee->id)->paginate(10) : collect();

        return view('leave.requests', compact('leaveRequests'));
    }

    public function show($id)
    {
        $leaveRequest = LeaveRequest::with(['manager:id,name', 'employee:id,name'])->findOrFail($id);
        return view('leave.show', compact('leaveRequest'));
    }

    public function update(Request $request, $id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $validated = $request->validate([
            'leave_type'  => 'sometimes|required|string',
            'start_date'  => 'sometimes|required|date',
            'end_date'    => 'sometimes|required|date|after_or_equal:start_date',
            'reason'      => 'sometimes|required|string',
            'manager_id'  => 'sometimes|required|exists:employees,id',
            'status'      => 'sometimes|required|in:pending,approved,rejected',
        ]);

        $leaveRequest->update($request->all());

        return redirect()->route('leave.requests.index')
            ->with('success', 'Leave request updated successfully.');
    }

    public function destroy($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        if ($leaveRequest->status !== 'pending') {
            return redirect()->back()->with('error', 'This request has already been processed.');
        }

        if ($leaveRequest->employee_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You can only delete your own requests.');
        }

        $leaveRequest->delete();

        return redirect()->route('leave.requests.index')
            ->with('success', 'Leave request deleted successfully.');
    }

    public function hrIndex()
    {
        $leaveRequests = LeaveRequest::with('employee')->paginate(10);
        return view('leave.rhRequest', compact('leaveRequests'));
    }

    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);

        $leaveBalance = LeaveBalance::where('employee_id', $leaveRequest->employee_id)->first();
        if ($leaveBalance) {
            $requestedDays = Carbon::parse($leaveRequest->start_date)->diffInDays(Carbon::parse($leaveRequest->end_date)) + 1;
            $leaveBalance->used_leave_days += $requestedDays;
            $leaveBalance->remaining_leave_days -= $requestedDays;
            $leaveBalance->save();
        }

        $leaveRequest->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Leave request approved.');
    }

    public function reject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Leave request rejected.');
    }

    public function managerIndex()
    {
        $managerId = Auth::id();
        $leaveRequests = LeaveRequest::with('employee')
            ->whereHas('employee', function ($query) use ($managerId) {
                $query->where('manager_id', $managerId);
            })->get();
        return view('leave.managerRequest', compact('leaveRequests'));
    }

    public function managerApprove($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Leave request approved by Manager.');
    }

    public function managerReject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Leave request rejected by Manager.');
    }
}
