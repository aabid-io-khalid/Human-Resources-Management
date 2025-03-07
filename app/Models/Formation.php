<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'duration'];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_formations')
                    ->withPivot('status', 'completed_at')
                    ->withTimestamps();
    }
}

