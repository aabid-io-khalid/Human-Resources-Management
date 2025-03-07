<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLeaveRequest
{
    public function handle(Request $request, Closure $next)
    {
        $employee = Employee::find($request->employee_id);
        $leaveBalance = $employee->leaveBalance;

        $requestedDays = Carbon::parse($request->start_date)->diffInDays($request->end_date) + 1;

        if ($leaveBalance->remaining_leave_days < $requestedDays) {
            return response()->json(['error' => 'Insufficient leave balance.'], 403);
        }

        return $next($request);
    }
}
