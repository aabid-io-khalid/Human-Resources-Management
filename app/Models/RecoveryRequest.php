<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecoveryRequest extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'recovery_date', 'hours_worked', 'status', 'reason', 'hr_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
