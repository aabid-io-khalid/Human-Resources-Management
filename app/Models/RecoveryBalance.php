<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecoveryBalance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'total_recovery_days'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
