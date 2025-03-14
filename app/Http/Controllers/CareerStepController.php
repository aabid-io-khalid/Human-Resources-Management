<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\CareerStep;
use Illuminate\Http\Request;

class CareerStepController extends Controller
{
    /**
     * Store a newly created career step for an employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'step_date' => 'required|date',
            'step_title' => 'required|string|max:255',
            'step_type' => 'nullable|string|max:255',
            'step_status' => 'required|string|max:255',
            'step_details' => 'nullable|string',
        ]);
        
        $isCurrent = $request->has('is_current');
        
        if ($isCurrent) {
            $employee->careerSteps()->update(['is_current' => false]);
        }
        
        $careerStep = $employee->careerSteps()->create([
            'step_date' => $validated['step_date'],
            'title' => $validated['step_title'],
            'type' => $validated['step_type'],
            'status' => $validated['step_status'],
            'details' => $validated['step_details'],
            'is_current' => $isCurrent,
        ]);
        
        return redirect()->route('employees.show', $employee)
            ->with('success', 'Career step added successfully!');
    }
    
    /**
     * Update the specified career step.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CareerStep  $careerStep
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CareerStep $careerStep)
    {
        $validatedData = $request->validate([
            'step_date' => 'required|date',
            'step_title' => 'required|string',
            'step_type' => 'nullable|string',
            'step_status' => 'required|string',
            'step_details' => 'nullable|string',
            'is_current' => 'boolean'
        ]);
        
        $isCurrent = $request->has('is_current');
        
        if ($isCurrent) {
            $careerStep->employee->careerSteps()
                ->where('id', '!=', $careerStep->id)
                ->update(['is_current' => false]);
        }
        
        $careerStep->update([
            'step_date' => $validatedData['step_date'],
            'title' => $validatedData['step_title'],
            'type' => $validatedData['step_type'],
            'status' => $validatedData['step_status'],
            'details' => $validatedData['step_details'],
            'is_current' => $request->has('is_current')
        ]);
        
        return redirect()->route('employees.show', $careerStep->employee)
            ->with('success', 'Career step updated successfully!');
    }
    
    /**
     * Remove the specified career step.
     *
     * @param  \App\Models\CareerStep  $careerStep
     * @return \Illuminate\Http\Response
     */
    public function destroy(CareerStep $careerStep)
    {
        $employee = $careerStep->employee;
        $careerStep->delete();
        
        return redirect()->route('employees.show', $employee)
            ->with('success', 'Career step deleted successfully!');
    }
}