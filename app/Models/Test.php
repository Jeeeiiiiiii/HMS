<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Test extends Model
{
    protected $fillable = [
        'patient_id',
        'note',
        'medication',
        'chief_complaint',
    ];

    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
