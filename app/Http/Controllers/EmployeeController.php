<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function show(Employee $employee)
{
    // Load departments for dropdown
    $departments = \App\Models\Department::all();
    
    // Load career steps and order them by date
    $careerSteps = $employee->careerSteps()
        ->orderBy('step_date', 'asc')
        ->get();
    
    // Get current career step if any
    $currentStep = $employee->careerSteps()
        ->where('is_current', true)
        ->first();
        
    return view('employees.show', compact('employee', 'departments', 'careerSteps', 'currentStep'));
}



public function index()
{
    $departments = Department::all(); // Assuming you have a Department model
    $employees = Employee::all(); // Assuming you have an Employee model

    return view('employees.index', compact('departments', 'employees'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();  // Fetch departments
        $roles = Role::all();  // Fetch roles
        return view('employees.create', compact('departments', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation (adjust the rules as necessary)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Store the new employee
        Employee::create($validated);

        // Redirect back with success message
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        // Fetch departments and roles
        $departments = Department::all();
        $roles = Role::all();

        // Return view with employee data
        return view('employees.show', compact('employee', 'departments', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        // Validation (adjust the rules as necessary)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Update the employee data
        $employee->update($validated);

        // Redirect back with success message
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Delete the employee
        $employee->delete();

        // Redirect back with success message
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
