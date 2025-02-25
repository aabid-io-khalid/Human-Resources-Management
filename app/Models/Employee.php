<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'email', 'phone', 'department_id', 'job_title', 'salary'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function role()
{
    return $this->belongsTo(Role::class);
}



public function careerSteps()
    {
        return $this->hasMany(CareerStep::class);
    }
    
    /**
     * Get the current career step for the employee.
     */
    public function currentCareerStep()
    {
        return $this->hasMany(CareerStep::class)
            ->where('is_current', true)
            ->latest('step_date')
            ->first();
    }

}

