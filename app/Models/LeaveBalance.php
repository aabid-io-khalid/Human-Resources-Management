<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveBalance extends Model
{
    public function calculateAnnualLeave($yearsWorked)
{
    return 18 + max(0, $yearsWorked - 1) * 0.5;
}

use HasFactory;

protected $fillable = ['employee_id', 'total_leave_days', 'used_leave_days', 'remaining_leave_days'];

public function employee()
{
    return $this->belongsTo(Employee::class);
}
}
