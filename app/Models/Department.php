<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id'); // Assuming you have a manager_id column in your departments table
    }
}

