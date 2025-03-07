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
            'hr_approval' => false,
            'manager_approval' => false,
        ]);

        return redirect()->route('leave.requests.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function index()
    {
        $employee = Employee::where('user_id', Auth::id())->first();
        $leaveRequests = $employee ? LeaveRequest::where('employee_id', $employee->id)->paginate(10) : collect();

        return view('leave.requests', compact('leaveRequests'));
    }

    public function hrIndex()
    {
        $leaveRequests = LeaveRequest::with('employee')->where('status', 'pending')->paginate(10);
        return view('leave.rhRequest', compact('leaveRequests'));
    }

    public function managerIndex()
    {
        $managerId = Auth::id();
        $leaveRequests = LeaveRequest::with('employee')
            ->whereHas('employee', function ($query) use ($managerId) {
                $query->where('manager_id', $managerId);
            })
            ->where('status', 'pending')
            ->get();

        return view('leave.managerRequest', compact('leaveRequests'));
    }

    public function approveByHR($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['hr_approval' => true]);

        if ($leaveRequest->manager_approval) {
            $this->finalizeApproval($leaveRequest);
        }

        return redirect()->back()->with('success', 'Leave request approved by HR.');
    }

    public function approveByManager($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['manager_approval' => true]);

        if ($leaveRequest->hr_approval) {
            $this->finalizeApproval($leaveRequest);
        }

        return redirect()->back()->with('success', 'Leave request approved by Manager.');
    }

    private function finalizeApproval(LeaveRequest $leaveRequest)
    {
        $leaveBalance = LeaveBalance::where('employee_id', $leaveRequest->employee_id)->first();
        if ($leaveBalance) {
            $requestedDays = Carbon::parse($leaveRequest->start_date)->diffInDays(Carbon::parse($leaveRequest->end_date)) + 1;
            $leaveBalance->used_leave_days += $requestedDays;
            $leaveBalance->remaining_leave_days -= $requestedDays;
            $leaveBalance->save();
        }

        $leaveRequest->update(['status' => 'approved']);
    }

    public function rejectByHR($id)
    {
        $this->rejectLeave($id);
        return redirect()->back()->with('success', 'Leave request rejected by HR.');
    }

    public function rejectByManager($id)
    {
        $this->rejectLeave($id);
        return redirect()->back()->with('success', 'Leave request rejected by Manager.');
    }

    private function rejectLeave($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'rejected']);
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
}
