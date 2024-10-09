<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientRecord;
use App\Models\Record;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Nurse;
use App\Models\TreatmentPlan;
use App\Models\Order;
use App\Models\Test;
use App\Models\OrderQRcode;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function dashboard()
{
    // Specify the 'doctor' guard to get the logged-in doctor
    $doctor = auth()->guard('doctor')->user(); 

    // Get all patient records assigned to this doctor, excluding discharged patients
    $patientRecords = $doctor->patientRecords()
                             ->with('patient')
                             ->whereHas('patient', function ($query) {
                                 $query->where('status', '!=', 'discharged');
                             })
                             ->get()
                             ->unique('patient_id');

    // Get the 3 latest records for the logged-in doctor, excluding discharged patients
    $patients = Record::where('doctor_id', $doctor->id)
                      ->whereHas('patient', function ($query) {
                          $query->where('status', '!=', 'discharged');
                      })
                      ->with(['patient', 'vital' => function ($query) {
                          $query->latest(); // Load vitals in descending order
                      }])
                      ->latest() // Order by the most recent records
                      ->take(3)  // Limit to 3 records
                      ->get();
    
    return view('doctor.dashboard', compact('patientRecords', 'doctor', 'patients'));
}




    public function treatmentPlan(){
            
        // Specify the 'doctor' guard to get the logged-in doctor
        $doctor = auth()->guard('doctor')->user(); // Ensure 'doctor' is the correct guard for doctor

        // Get all patient records assigned to this doctor
        $patientRecords = $doctor->patientRecords()->with('patient')->get()->unique('patient_id');

        return view('doctor.treatmentPlan', compact('patientRecords', 'doctor'));
        }

    public function medicalOrder(){
        
        // Specify the 'doctor' guard to get the logged-in doctor
        $doctor = auth()->guard('doctor')->user(); // Ensure 'doctor' is the correct guard for doctor

        // Get all patient records assigned to this doctor
        $patientRecords = $doctor->patientRecords()->with('patient')->get()->unique('patient_id');

        return view('doctor.medicalOrder', compact('patientRecords', 'doctor'));
        }

    public function AddPlan($id)
        {
            $doctor = auth()->guard('doctor')->user();
        // Retrieve the patient using the provided ID
        $patient = Patient::with('patientrecord')->find($id);

        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->withErrors(['message' => 'Patient not found.']);
        }


            // Pass the patient data to the view
            return view('doctor.AddPlan', compact('patient', 'doctor'));
        }

    public function AddOrder($id)
        {
        $doctor = auth()->guard('doctor')->user();
        // Retrieve the patient using the provided ID
        $patient = Patient::with('patientrecord')->find($id);

        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->withErrors(['message' => 'Patient not found.']);
        }


            // Pass the patient data to the view
            return view('doctor.AddOrder', compact('patient', 'doctor'));
        }

    public function Details($id)
        {
        $doctor = auth()->guard('doctor')->user();
        // Retrieve the patient using the provided ID
        $patient = Patient::with('patientrecord')->find($id);

        // Check if the patient exists
        if (!$patient) {
            return redirect()->back()->withErrors(['message' => 'Patient not found.']);
        }

        // Pass the patient data to the view
        return view('doctor.Details', compact('patient', 'doctor'));
        }

    public function PatientRecord($id)
        {
        $doctor = auth()->guard('doctor')->user();
        // Retrieve the patient using the provided ID
        $patient = PatientRecord::with(['profile', 'vital', 'admission', 'test', 'patient', 'record', 'qrcode', 'treatment_plan', 'order'])->find($id);
        

        // Pass the patient data to the view
        return view('doctor.PatientRecord', compact('patient', 'doctor'));
        }

    public function Record($id)
        {
        $doctor = auth()->guard('doctor')->user();
        // Retrieve the patient using the provided ID
        $patient = Record::with(['vital', 'test', 'patient', 'patientRecord', 'physical_assessment', 'record_qrcode'])->find($id);
        

        // Pass the patient data to the view
        return view('doctor.record', compact('patient', 'doctor'));
        }

    public function TreatmentPlanPage($id)
        {
        $doctor = auth()->guard('doctor')->user();
        // Retrieve the patient using the provided ID
        $patient = TreatmentPlan::with(['test', 'patientRecord'])->find($id);
        

        // Pass the patient data to the view
        return view('doctor.TreatmentPlanPage', compact('patient', 'doctor'));
        }

    public function OrderPage($id)
        {
            $doctor = auth()->guard('doctor')->user();
        // Retrieve the patient using the provided ID
        $patient = Order::with(['patientRecord', 'order_qrcode'])->find($id);
        

        // Pass the patient data to the view
        return view('doctor.OrderPage', compact('patient', 'doctor'));
        }

    public function AddTreatment($id)
        {
            $doctor = auth()->guard('doctor')->user();
            // Retrieve the patient using the provided ID
            $patientRecord = PatientRecord::find($id);

            $doctors = Doctor::all(); // Retrieve all doctors
            $nurses = Nurse::all();   // Retrieve all nurses

            // Check if the patient exists
            if (!$patientRecord) {
                return redirect()->back()->withErrors(['message' => 'Patient not found.']);
            }

            // Pass the patient data to the view
            return view('doctor.AddTreatment', compact('patientRecord', 'doctors', 'nurses', 'doctor'));
        }

    public function AddMedicalOrder($id)
        {
            $doctor = auth()->guard('doctor')->user();
            // Retrieve the patient using the provided ID
            $patientRecord = PatientRecord::find($id);
            $departments = Department::all();
            $doctors = Doctor::all(); // Retrieve all doctors
            $nurses = Nurse::all();   // Retrieve all nurses

            // Check if the patient exists
            if (!$patientRecord) {
                return redirect()->back()->withErrors(['message' => 'Patient not found.']);
            }

            // Pass the patient data to the view
            return view('doctor.AddMedicalOrder', compact('patientRecord', 'doctors', 'nurses', 'doctor', 'departments'));
        }

    public function updateOrderStatus(Request $request, $id)
        {
            $order = Order::findOrFail($id);
            $order->status = $request->input('status');
            $order->save();

            return redirect()->back()->with('success', 'Order status updated successfully.');
        }

    public function discharge($id)
        {
            $patient = Patient::findOrFail($id);
            $patient->status = 'discharged';  // Update status to discharged
            $patient->save();

            return redirect()->back()->with('success', 'Patient has been discharged.');
        }


    public function storeTreatment(Request $request, $patientId)

        {
        DB::beginTransaction();

        try { 


        $patientRecord = PatientRecord::findOrFail($patientId);


        $test = Test::create([
            'patient_id' => $patientRecord->patient_id,
            'initial_test' => $request->initial_test,
            'note' => $request->note,
            'medication' => $request->medication,
            'lab_test' => $request->lab_test,
            'diagnose' => $request->diagnose,
        ]);
        

        // Create the patient record
        $record = TreatmentPlan::create([
            'patient_id' => $patientRecord->patient_id,
            'doctor_id' => $patientRecord->doctor_id,
            'nurse_id' => $patientRecord->nurse_id,
            'patient_record_id' => $patientRecord->id,
            'test_id' => $test->id,
            'title' => $request->title,
        ]);

        DB::commit();

            return redirect()->route('doctor_dashboard')->with('success', 'Treatment Plan created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error message and stack trace
            \Log::error('Error creating profile: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->route('doctor_dashboard')->with('error', 'There was an error creating the Treatment Plan: ' . $e->getMessage());
        }
        
        
        }

    public function storeOrder(Request $request, $patientId)

        {
        DB::beginTransaction();

        try { 


        $patientRecord = PatientRecord::findOrFail($patientId);
        

        // Create the Order record
        $order = Order::create([
            'patient_id' => $patientRecord->patient_id,
            'doctor_id' => $patientRecord->doctor_id,
            'nurse_id' => $patientRecord->nurse_id,
            'department_id' => $request->admitting_department,
            'patient_record_id' => $patientRecord->id,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'title' => $request->title,
        ]);

        DB::commit();

        // Fetch the patient record to generate QR code
        $order = Order::with(['patientRecord', 'order_qrcode'])->findOrFail($order->id);


        // Call the generateQRCode method
        $this->generateQRCode($order);

            return redirect()->route('doctor_dashboard')->with('success', 'Medical Order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error message and stack trace
            \Log::error('Error creating profile: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->route('nurse_dashboard')->with('error', 'There was an error creating the Medical Order: ' . $e->getMessage());
        }
        
        
        }

        public function generateQRCode(Order $order)
        {
            // Generate the URL that the QR code will point to
            $url = route('Order.show', $order->id);
        
            // Generate the QR code as a PNG image pointing to the URL
            $qrCodeImage = QrCode::format('png')->size(200)->generate($url);
        
            // Define a unique file path where the QR code image will be stored in the S3 bucket
            $uniqueId = Str::uuid(); // Generate a unique ID
            $filePath = 'OrderQRcodes/' . $order->id . '_' . $uniqueId . '.png';
        
            // Attempt to save the QR code image to the S3 storage
            try {
                Storage::disk('s3')->put($filePath, $qrCodeImage);
                
                // Log successful upload
                \Log::info('QR code uploaded successfully to S3 at: ' . $filePath);
            } catch (\Exception $e) {
                // Log any errors that occur during upload
                \Log::error('Error uploading QR code to S3: ' . $e->getMessage() . "\nTrace: " . $e->getTraceAsString());
            }
        
            if (Storage::disk('s3')->exists($filePath)) {
                \Log::info('QR code exists on S3 at: ' . $filePath);
            } else {
                \Log::error('QR code does not exist on S3 at: ' . $filePath);
            }
        
            // Store the file path in the database, associating it with the order
            OrderQrCode::create([
                'patient_record_id' => $order->patient_record_id,
                'order_id' => $order->id,
                'file_path' => $filePath,
                'patient_id' => $order->patient_id,
            ]);
        }
        

        public function showQR(Order $order)
        {
            // Get the currently authenticated user's guard
            $userGuard = null;
        
            if (auth()->guard('triagenurse')->check()) {
                $userGuard = 'triagenurse';
            } elseif (auth()->guard('doctor')->check()) {
                $userGuard = 'doctor';
            } elseif (auth()->guard('nurse')->check()) {
                $userGuard = 'nurse';
            } elseif (auth()->guard('patient')->check()) {
                $userGuard = 'patient';
            } elseif (auth()->guard('department')->check()) {
                $userGuard = 'department';
            }
        
            // If no valid guard is found, deny access
            if (!$userGuard) {
                return redirect()->route('login')->with('error', 'Unauthorized Access');
            }
        
            // If authorized, show the QR code details
            return view('doctor.show', compact('order'));
        }
        


    ////////////////////////////////////////////////////////////////////////////////////// Profile

    public function profile($id){
        // Retrieve the doctor using the provided ID
        $doctor = Doctor::with('profile')->find($id);
    
            return view('doctor.profile.profile', compact('doctor'));
        }
    
        public function changepass($id){
            // Retrieve the doctor using the provided ID
            $doctor = Doctor::find($id);
    
        
            return view('doctor.profile.changepass', compact('doctor'));
            }
    
        public function doctor_submitpass(Request $request){
    
                // Validate the request
            $request->validate([
                'current_password' => 'required',
                'new_password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
            ]);
    
            // Get the user using the custom 'doctor' guard
            $user = Auth::guard('doctor')->user();
    
            // Check if the current password matches
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'The provided current password does not match our records.');
            }
    
            // Update the password
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            // Optionally, log the user out of other sessions
            Auth::guard('doctor')->logoutOtherDevices($request->new_password);
    
            // Redirect with success message
            return redirect()->back()->with('success', 'Your password has been changed successfully.');
        }
    
        public function changeinfo($id){
            // Retrieve the doctor using the provided ID
            $doctor = Doctor::find($id);
    
        
            return view('doctor.profile.changeinfo', compact('doctor'));
            }
    
        public function doctor_submitinfo(Request $request){
    
            // Validate the request
            $request->validate([
                'email' => 'required|email|unique:doctors,email,' . Auth::guard('doctor')->id(),
                'telephone_no' => 'required|string|max:15', // Adjust the validation rules as needed
            ]);
    
            // Get the authenticated user
            $user = Auth::guard('doctor')->user();
    
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
    
        public function doctor_submitemergencyinfo(Request $request){
    
                // Validate the request data
            $request->validate([
                'emergency_email' => 'required|email|unique:profiles,emergency_email',
                'emergency_telephone_no' => 'required|string|max:15',
            ]);
    
            // Get the authenticated user
            $user = Auth::guard('doctor')->user();
    
            // Find the profile or create a new one with the correct doctor_id
            $emergencyContact = $user->profile()->firstOrNew(['doctor_id' => $user->id]);
    
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
        // Retrieve the doctor using the provided ID
        $doctor = Doctor::find($id);
    
    
        $user = Auth::guard('doctor')->user();
        $sessions = $user->sessions()->orderBy('last_active_at', 'desc')->get();
        return view('doctor.profile.sessions', compact('sessions', 'doctor'));
    
        
    }
}
