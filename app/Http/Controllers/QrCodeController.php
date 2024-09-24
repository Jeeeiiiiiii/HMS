<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PatientQrCode;
use App\Models\PatientRecord;
use App\Models\RecordQrCode;
use App\Models\Record;
use App\Models\Order;

class QrCodeController extends Controller
{
    public function show($patientRecordId)
{
    $patientRecord = PatientRecord::with('qrcode')->find($patientRecordId);

    if ($patientRecord && $patientRecord->qrcode->isNotEmpty()) {
        // Get the first QR code associated with this PatientRecord
        $qrCode = $patientRecord->qrcode->first();
        return response()->json(['path' => Storage::url($qrCode->file_path)]);
    } else {
        return response()->json(['path' => null], 404); // Handle the case where no QR code is found
    }
}

    public function showRecord($patientRecordId)
{
    $Record = Record::with('record_qrcode')->find($patientRecordId);

    if ($Record && $Record->record_qrcode->isNotEmpty()) {
        // Get the first QR code associated with this PatientRecord
        $qrCode = $Record->record_qrcode->first();
        return response()->json(['path' => Storage::url($qrCode->file_path)]);
    } else {
        return response()->json(['path' => null], 404); // Handle the case where no QR code is found
    }
}

    public function showOrder($patientRecordId)
{
    $Record = Order::with('order_qrcode')->find($patientRecordId);

    if ($Record && $Record->order_qrcode->isNotEmpty()) {
        // Get the first QR code associated with this PatientRecord
        $qrCode = $Record->order_qrcode->first();
        return response()->json(['path' => Storage::url($qrCode->file_path)]);
    } else {
        return response()->json(['path' => null], 404); // Handle the case where no QR code is found
    }
}

}