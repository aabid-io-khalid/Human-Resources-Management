<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProgress extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'type', 'description', 'date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
