<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'type', 'salary', 'start_date', 'end_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
