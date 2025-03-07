<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::with('employees')->get();
        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
    ]);

    Department::create([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('departments.index')->with('success', 'Department added successfully.');

}
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $department = Department::with('manager')->findOrFail($id);
        $employees = Employee::where('department_id', $id)->get();
    
        return view('departments.show', compact('department', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $department = Department::findOrFail($id);

    $department->delete();

    return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
}
}
