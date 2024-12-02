<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor;
use App\Models\Department;

class DepartmentDoctor extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'department_doctor';

    // Disable mass assignment protection for this model (optional)
    protected $fillable = [
        'doctor_id', 'department_id'
    ];

    // Define the relationship with the Doctor model
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Define the relationship with the Department model
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
