<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::all();
        $employees = Employee::all(); 

        return view('formations.index', compact('formations', 'employees'));
    }

    public function enrollEmployee(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'formation_id' => 'required|exists:formations,id'
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $formation = Formation::findOrFail($request->formation_id);

        if ($employee->formations()->where('formation_id', $formation->id)->exists()) {
            return redirect()->route('formations.index')->with('error', 'Employee is already enrolled in this formation.');
        }

        $employee->formations()->attach($formation->id, ['status' => 'pending']);

        return redirect()->route('formations.index')->with('success', 'Employee enrolled successfully.');
    }

    public function completeFormation(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'formation_id' => 'required|exists:formations,id',
            'passed' => 'required|boolean'
        ]);

        $employee = Employee::findOrFail($request->employee_id);
        $formation = Formation::findOrFail($request->formation_id);

        $enrollment = $employee->formations()->where('formation_id', $formation->id)->first();

        if (!$enrollment) {
            return redirect()->route('formations.index')->with('error', 'Employee is not enrolled in this formation.');
        }

        if ($enrollment->pivot->status !== 'pending') {
            return redirect()->route('formations.index')->with('error', 'This formation has already been completed.');
        }

        $status = $request->passed ? 'passed' : 'failed';

        $employee->formations()->updateExistingPivot($formation->id, [
            'status' => $status,
            'completed_at' => now()
        ]);

        return redirect()->route('formations.index')->with('success', "Formation marked as $status.");
    }

}
