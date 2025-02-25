<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'step_date',
        'title',
        'type',
        'status',
        'details',
        'is_current'
    ];

    protected $casts = [
        'step_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the employee that owns the career step.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}