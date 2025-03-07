<?php

namespace App\Http\Controllers;

use view;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function show(Employee $employee)
     {
         $departments = Department::all();
         
         $roles = Role::all();
         
         $careerSteps = $employee->careerSteps()
             ->orderBy('step_date', 'asc')
             ->get();
         
         $currentStep = $employee->careerSteps()
             ->where('is_current', true)
             ->first();
             
         return view('employees.show', compact('employee', 'departments', 'roles', 'careerSteps', 'currentStep'));
     }



public function index()
{
    $departments = Department::all(); 
    $employees = Employee::all(); 
    $roles = Role::all(); 

    return view('employees.index', compact('departments', 'employees', 'roles')); // Pass roles to the view
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();  
        $roles = Role::all();  
        return view('employees.create', compact('departments', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        Employee::create($validated);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
{
    $departments = Department::all();
    $roles = Role::all();
    return view('employees.show', compact('employee', 'departments', 'roles'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            // 'job_title' => 'nullable',
            'role_id' => 'nullabel|exists:roles,id',
            'department_id' => 'nullable|exists:departments,id',
            'salary' => 'required|numeric',
            'phone' => 'nullable|string'
        ]);

        $employee->update($validatedData);

        return redirect()->route('employees.show', $employee->id)->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
