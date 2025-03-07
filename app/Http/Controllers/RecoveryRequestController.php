<?php

namespace App\Http\Controllers;

use App\Models\RecoveryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecoveryRequestController extends Controller
{
    public function create()
    {
        return view('recovery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'recovery_date' => 'required|date',
            'hours_worked'  => 'required|integer|min:1',
        ]);

        $recoveryRequest = new RecoveryRequest();
        $recoveryRequest->employee_id = Auth::id();
        $recoveryRequest->recovery_date = $request->recovery_date;
        $recoveryRequest->hours_worked  = $request->hours_worked;
        $recoveryRequest->status        = 'pending';
        $recoveryRequest->save();

        return redirect()->route('recovery.requests')
                         ->with('success', 'Recovery request submitted successfully.');
    }

    public function index()
    {
        $user = Auth::user();
        $requests = RecoveryRequest::where('employee_id', $user->id)->get();
        return view('recovery.requests', compact('requests'));
    }

    public function hrIndex()
    {
        $recoveryRequests = RecoveryRequest::with('employee')->get();
        return view('hr.recovery_requests', compact('recoveryRequests'));
    }

    public function managerIndex()
    {
        $managerId = Auth::id();
        $recoveryRequests = RecoveryRequest::with('employee')
            ->whereHas('employee', function ($query) use ($managerId) {
                $query->where('manager_id', $managerId);
            })->get();
        return view('manager.recovery_requests', compact('recoveryRequests'));
    }

    public function approve($id)
    {
        $recoveryRequest = RecoveryRequest::findOrFail($id);
        $recoveryRequest->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Recovery request approved.');
    }

    public function reject($id)
    {
        $recoveryRequest = RecoveryRequest::findOrFail($id);
        $recoveryRequest->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Recovery request rejected.');
    }

    public function managerApprove($id)
    {
        $recoveryRequest = RecoveryRequest::findOrFail($id);
        $recoveryRequest->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Recovery request approved by Manager.');
    }

    public function managerReject($id)
    {
        $recoveryRequest = RecoveryRequest::findOrFail($id);
        $recoveryRequest->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Recovery request rejected by Manager.');
    }

    public function show($id)
    {
        $recoveryRequest = RecoveryRequest::findOrFail($id);
        return view('recovery.show', compact('recoveryRequest'));
    }
}
