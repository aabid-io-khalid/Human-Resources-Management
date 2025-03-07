<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class OrganigrammeController extends Controller
{
    public function index()
    {
        $ceo = Employee::where('job_title', 'CEO')->first();

        $hr_director = Employee::where('department_id', 'HR')->where('job_title', 'Director')->first();
        $it_director = Employee::where('department_id', 'IT')->where('job_title', 'Director')->first();
        $marketing_director = Employee::where('department_id', 'Marketing')->where('job_title', 'Director')->first();
        $finance_director = Employee::where('department_id', 'Finance')->where('job_title', 'Director')->first();
        $operations_manager = Employee::where('job_title', 'Operations Manager')->first();
        $sales_manager = Employee::where('job_title', 'Sales Manager')->first();

        $hr_employees = Employee::where('department_id', 'HR')->get();
        $it_employees = Employee::where('department_id', 'IT')->get();
        $marketing_employees = Employee::where('department_id', 'Marketing')->get();

        return view('leave.organigramme', compact(
            'ceo',
            'hr_director',
            'it_director',
            'marketing_director',
            'finance_director',
            'operations_manager',
            'sales_manager',
            'hr_employees',
            'it_employees',
            'marketing_employees'
        ));
    }
}
