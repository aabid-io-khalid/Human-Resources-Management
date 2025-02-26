<?php

namespace App\Http\Controllers;

use App\Models\EmployeeProgress;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeProgressController extends Controller
{
    public function index()
    {
        $progress = EmployeeProgress::with('employee')->get();
        return view('progress.index', compact('progress'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('progress.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:Promotion,Training,New Contract',
            'description' => 'required|string',
            'date' => 'required|date'
        ]);

        EmployeeProgress::create($request->all());
        return redirect()->route('employee-progress.index')->with('success', 'Progress added.');
    }
}
