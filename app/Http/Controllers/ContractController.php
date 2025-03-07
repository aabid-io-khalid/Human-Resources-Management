<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = Contract::paginate(10); 
    return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('contracts.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'type' => 'required|in:CDD,CDI,Internship,Freelance',
            'salary' => 'nullable|numeric',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date'
        ]);

        Contract::create($request->all());
        return redirect()->route('contracts.index')->with('success', 'Contract added.');
    }
}
