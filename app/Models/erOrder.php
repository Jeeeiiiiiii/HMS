<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Nurse;
use App\Models\Doctor;
use App\Models\PatientRecord;
use App\Models\erOrderQrCode;


class erOrder extends Model
{
    protected $fillable = [
        'patient_id', 
        'doctor_id',
        'nurse_id',
        'department_id',
        'patient_record_id', 
        'emergency_room_id', 
        'type', 
        'description', 
        'order_status', 
        'status', 
        'order_date',
        'title',
        'admitting_doctor',
        ];

    protected $dates = ['order_date'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patientRecord()
    {
        return $this->belongsTo(PatientRecord::class);
    }

    public function order_qrcode()
    {
        return $this->HasMany(erOrderQrCode::class);
    }

    public function admittingDoctor()
    {
        return $this->belongsTo(Doctor::class, 'admitting_doctor');
    }
}
