<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Notifications\EmployeeNotification;

class NotificationController extends Controller
{

    
    public function index()
    {
        $employee = Auth::user();  
     
        if (!$employee) {
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }
     
        if ($employee->role === 'RH' || $employee->role === 'Manager') {
            $notifications = $employee->notifications()->whereJsonContains('data->message', 'New leave request')->get();
        } else {
            $notifications = $employee->notifications;  
        }
    
        return view('notifications.index', compact('notifications'));
    }
    


    public function notifyLeaveRequest($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $hr = Employee::where('role', 'RH')->first();
        $manager = Employee::where('id', $employee->manager_id)->first();

        if ($hr) {
            $hr->notify(new EmployeeNotification("New leave request submitted by {$employee->name}."));
        }
        if ($manager) {
            $manager->notify(new EmployeeNotification("New leave request submitted by {$employee->name}."));
        }

        return response()->json(['message' => 'Notification sent successfully']);
    }

    public function notifyLeaveResponse($employee_id, $status)
    {
        $employee = Employee::findOrFail($employee_id);
        $message = ($status === 'approved') ? "Your leave request has been approved." : "Your leave request has been rejected.";
        $employee->notify(new EmployeeNotification($message));

        return response()->json(['message' => 'Notification sent successfully']);
    }

    public function notifyFormationEnrollment($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee->notify(new EmployeeNotification("You have been enrolled in a new formation."));

        return response()->json(['message' => 'Notification sent successfully']);
    }

    public function notifyFormationResult($employee_id, $status)
    {
        $employee = Employee::findOrFail($employee_id);
        $message = ($status === 'passed') ? "Congratulations! You passed the formation." : "Unfortunately, you failed the formation.";
        $employee->notify(new EmployeeNotification($message));

        return response()->json(['message' => 'Notification sent successfully']);
    }

    public function markAsRead($id)
    {
        Auth::user()->notifications->where('id', $id)->markAsRead();
        return redirect()->back();
    }
}
