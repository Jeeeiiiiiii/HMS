<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Test extends Model
{
    protected $fillable = [
        'patient_id',
        'initial_test',
        'note',
        'medication',
        'lab_test',
        'diagnose',
    ];

    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
