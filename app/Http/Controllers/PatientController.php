<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Order;
use App\Models\Record;
use App\Models\PatientRecord;
use App\Models\TreatmentPlan;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;


class PatientController extends Controller
{
    public function dashboard(){
    // Retrieve the currently authenticated patient
    $patient = Auth::guard('patient')->user();
    $sessions = $patient->sessions()->orderBy('last_active_at', 'desc')->get();

    $patientId = $patient->id;

     // Fetch the latest medical orders, rounds, and admission information
     $medicalOrders = Order::where('patient_id', $patientId)
     ->where('status', 'pending')
     ->latest()
     ->limit(5)
     ->get();
 
    $rounds = Record::where('patient_id', $patientId)
        ->latest()
        ->limit(3)
        ->get();
    
    $admission = PatientRecord::where('patient_id', $patientId)
        ->latest()
        ->first();
    
    return view('patient.dashboard', compact('sessions', 'patient', 'medicalOrders', 'rounds', 'admission'));
    }

    public function TreatmentPlan($id)
    {
    $patient = auth()->guard('patient')->user();

    // Check if the patient exists
    if (!$patient) {
        return redirect()->back()->withErrors(['message' => 'Patient not found.']);
    }

        // Pass the patient data to the view
        return view('patient.TreatmentPlan', compact('patient'));
    }

    public function Treatments($id)
    {
        $patient = auth()->guard('patient')->user();
        // Retrieve the patient using the provided ID
        $patientRecord = PatientRecord::with(['profile', 'vital', 'admission', 'test', 'patient', 'record', 'qrcode', 'treatment_plan', 'order'])->find($id);
        

        // Pass the patient data to the view
        return view('patient.Treatment', compact('patient', 'patientRecord'));
        }

    public function profile($id){
    // Retrieve the patient using the provided ID
    $patient = Patient::with('profile')->find($id);

        return view('patient.profile.profile', compact('patient'));
    }

    public function changepass($id){
        // Retrieve the patient using the provided ID
        $patient = Patient::find($id);

    
        return view('patient.profile.changepass', compact('patient'));
        }


    public function Details($id)
    {
    // Retrieve the patient using the provided ID
    $patient = Patient::with('patientrecord')->find($id);

    // Check if the patient exists
    if (!$patient) {
        return redirect()->back()->withErrors(['message' => 'Patient not found.']);
    }

    // Pass the patient data to the view
    return view('patient.Details', compact('patient'));
    }

    public function PatientRecord($id)
        {
        $patient = auth()->guard('patient')->user();
        // Retrieve the patient using the provided ID
        $patientRecord = PatientRecord::with(['profile', 'vital', 'admission', 'test', 'patient', 'record', 'qrcode', 'treatment_plan', 'order'])->find($id);
        

        // Pass the patient data to the view
        return view('patient.PatientRecord', compact('patient', 'patientRecord'));
        }

    public function Record($id)
        {
        $patient = auth()->guard('patient')->user();
        // Retrieve the patient using the provided ID
        $record = Record::with(['vital', 'test', 'patient', 'patientRecord', 'physical_assessment', 'record_qrcode'])->find($id);
        

        // Pass the patient data to the view
        return view('patient.record', compact('patient', 'record'));
        }

    public function TreatmentPlanPage($id)
        {
        $patient = auth()->guard('patient')->user();
        // Retrieve the patient using the provided ID
        $treatment = TreatmentPlan::with(['test', 'patientRecord'])->find($id);
        

        // Pass the patient data to the view
        return view('patient.TreatmentPlanPage', compact('patient', 'treatment'));
        }

    public function OrderPage($id)
        {
        $patient = auth()->guard('patient')->user();
        // Retrieve the patient using the provided ID
        $order = Order::with(['patientRecord', 'order_qrcode'])->find($id);
        

        // Pass the patient data to the view
        return view('patient.OrderPage', compact('patient', 'order'));
        }

        public function verifyPassword(Request $request)
        {
            $inputPassword = $request->input('password');

            // Get the currently authenticated patient
            $patient = Auth::guard('patient')->user();

            if (!$patient) {
                return response()->json(['status' => 'error', 'message' => 'No patient authenticated.']);
            }

            // Verify the input password against the stored hashed password
            if (Hash::check($inputPassword, $patient->password)) {
                return response()->json(['status' => 'success']);
            }

            return response()->json(['status' => 'error', 'message' => 'Incorrect password. Please try again.']);
        }











//////////////////////////// profile

public function patient_submitpass(Request $request){

    // Validate the request
$request->validate([
    'current_password' => 'required',
    'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
]);

// Get the user using the custom 'patient' guard
$user = Auth::guard('patient')->user();

// Check if the current password matches
if (!Hash::check($request->current_password, $user->password)) {
    return redirect()->back()->with('error', 'The provided current password does not match our records.');
}

// Update the password
$user->password = Hash::make($request->new_password);
$user->save();

// Optionally, log the user out of other sessions
Auth::guard('patient')->logoutOtherDevices($request->new_password);

// Redirect with success message
return redirect()->back()->with('success', 'Your password has been changed successfully.');
}

public function changeinfo($id){
// Retrieve the patient using the provided ID
$patient = Patient::find($id);


return view('patient.profile.changeinfo', compact('patient'));
}

public function patient_submitinfo(Request $request){

// Validate the request
$request->validate([
    'email' => 'required|email|unique:patients,email,' . Auth::guard('patient')->id(),
    'telephone_no' => 'required|string|max:15', // Adjust the validation rules as needed
]);

// Get the authenticated user
$user = Auth::guard('patient')->user();

// Update the user’s email
$user->email = $request->input('email');
$user->save();

// Update the user's profile (assuming there is a related profile model)
$profile = $user->profile;
$profile->telephone_no = $request->input('telephone_no');
$profile->save();

// Redirect with a success message
return redirect()->back()->with('success', 'Your information has been updated successfully.');
}

public function patient_submitemergencyinfo(Request $request){

    // Validate the request data
$request->validate([
    'emergency_email' => 'required|email|unique:profiles,emergency_email',
    'emergency_telephone_no' => 'required|string|max:15',
]);

// Get the authenticated user
$user = Auth::guard('patient')->user();

// Find the profile or create a new one with the correct patient_id
$emergencyContact = $user->profile()->firstOrNew(['patient_id' => $user->id]);

// Update the emergency contact information
$emergencyContact->emergency_email = $request->input('emergency_email');
$emergencyContact->emergency_telephone_no = $request->input('emergency_telephone_no');
// Attempt to save the emergency contact information
if ($emergencyContact->save()) {
// If successful, redirect with a success message
return redirect()->back()->with('success', 'Emergency contact information has been updated successfully.');
} else {
// If save fails, redirect with an error message
return redirect()->back()->with('error', 'There was an error updating your emergency contact information. Please try again.');
}
}

public function showSessions($id)
{
// Retrieve the patient using the provided ID
$patient = Patient::find($id);


$user = Auth::guard('patient')->user();
$sessions = $user->sessions()->orderBy('last_active_at', 'desc')->get();
return view('patient.profile.sessions', compact('sessions', 'patient'));   
}



    
}
