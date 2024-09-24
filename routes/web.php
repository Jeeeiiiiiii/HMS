<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\TriageNurseController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::controller(AccountController::class)->group(function () {
 
    Route::get('login', 'login')->name('login');
    Route::post('login', 'login_submit')->name('login.action');
    Route::get('logout', 'logout')->name('logout');
    Route::get('register', 'register')->name('register');
    Route::post('registerSave', 'registerSave')->name('registerSave');
    
    ////////// Doctor Logic
    Route::get('doctor/final_registration/{token}', 'final_registration')->name('final_register');
    Route::post('doctor/post_final', 'doctor_post_final')->name('doctor_post_final');
    ////////// Patient Logic
    Route::get('patient/final_registration/{token}', 'patient_final_registration')->name('patient_final_register');
    Route::post('patient/post_final', 'patient_post_final')->name('patient_post_final');
    ////////// Nurse Logic
    Route::get('nurse/final_registration/{token}', 'nurse_final_registration')->name('nurse_final_register');
    Route::post('nurse/post_final', 'nurse_post_final')->name('nurse_post_final');
    ////////// Department Logic
    Route::get('department/final_registration/{token}', 'department_final_registration')->name('department_final_register');
    Route::post('department/post_final', 'department_post_final')->name('department_post_final');
    ////////// TriageNurse Logic
    Route::get('triagenurse/final_registration/{token}', 'triage_nurse_final_registration')->name('triage_nurse_final_register');
    Route::post('triagenurse/post_final', 'triage_nurse_post_final')->name('triage_nurse_post_final');
    
});




////////////////////////////////////////
Route::middleware('admin')->group(function (){

    //////// profile
    Route::get('admin/profile/{id}', [AdminController::class, 'profile'])->name('admin_profile');
    Route::get('admin/profile/{id}/changepass', [AdminController::class, 'changepass'])->name('admin_changepass');
    Route::post('admin/profile/admin_submitpass', [AdminController::class, 'admin_submitpass'])->name('admin_submitpass');
    Route::get('admin/profile/{id}/changeinfo', [AdminController::class, 'changeinfo'])->name('admin_changeinfo');
    Route::post('admin/profile/admin_submitinfo', [AdminController::class, 'admin_submitinfo'])->name('admin_submitinfo');
    Route::post('admin/profile/admin_submitemergencyinfo', [AdminController::class, 'admin_submitemergencyinfo'])->name('admin_submitemergencyinfo');
    Route::get('admin/profile/{id}/sessions', [AdminController::class, 'showSessions'])->name('admin_sessions');


    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');

    ////////// Doctor Logic
    Route::get('admin/doctors', [AdminController::class, 'doctors'])->name('admin_doctors');
    Route::get('admin/doctors/{id}/profile', [AdminController::class, 'showDoctorProfile'])->name('admin_doctors_profile');
    Route::get('admin/doctors/register', [AdminController::class, 'DoctorRegister'])->name('doctor_register');
    Route::post('admin/doctor/post/register', [AdminController::class, 'doctorPostRegistration'])->name('doctor.register.post'); 

    ////////// Patient Logic
    Route::get('admin/patients', [AdminController::class, 'patients'])->name('admin_patients');
    Route::get('admin/patients/{id}/profile', [AdminController::class, 'showPatientProfile'])->name('admin_patients_profile');
    Route::get('admin/patients/register', [AdminController::class, 'PatientRegister'])->name('patient_register');
    Route::post('admin/patients/post/register', [AdminController::class, 'patientPostRegistration'])->name('patient.register.post'); 

    ////////// Nurse Logic
    Route::get('admin/nurses', [AdminController::class, 'nurses'])->name('admin_nurses');
    Route::get('admin/nurses/{id}/profile', [AdminController::class, 'showNurseProfile'])->name('admin_nurses_profile');
    Route::get('admin/nurses/register', [AdminController::class, 'NurseRegister'])->name('nurse_register');
    Route::post('admin/nurse/post/register', [AdminController::class, 'nursePostRegistration'])->name('nurse.register.post'); 

    ////////// TriageNurse Logic
    Route::get('admin/triagenurse', [AdminController::class, 'triagenurse'])->name('admin_triagenurse');
    Route::get('admin/triagenurse/{id}/profile', [AdminController::class, 'showTriageProfile'])->name('admin_triage_nurses_profile');
    Route::get('admin/triage_nurses/register', [AdminController::class, 'Triage_NurseRegister'])->name('triage_nurse_register');
    Route::post('admin/triage_nurse/post/register', [AdminController::class, 'triage_nursePostRegistration'])->name('triage_nurse.register.post'); 

    ////////// Department Logic
    Route::get('admin/departments', [AdminController::class, 'departments'])->name('admin_departments');
    Route::get('admin/department/register', [AdminController::class, 'DepartmentRegister'])->name('department_register');
    Route::post('admin/department/post/register', [AdminController::class, 'departmentPostRegistration'])->name('department.register.post'); 
    Route::get('admin/department/{id}/details', [AdminController::class, 'departmentsDetail'])->name('department_details');
    Route::get('admin/assign-doctor', [AdminController::class, 'assignDoctor'])->name('assign-doctor.create');
    Route::post('/assign-doctor', [AdminController::class, 'storeAssignDoctor'])->name('assign-doctor.store');
    Route::get('admin/assign-nurse', [AdminController::class, 'assignNurse'])->name('assign-nurse.create');
    Route::post('/assign-nurse', [AdminController::class, 'storeAssignNurse'])->name('assign-nurse.store');
    Route::get('admin/assign-triage_nurse', [AdminController::class, 'assignTriageNurse'])->name('assign-triage_nurse.create');
    Route::post('/assign-triage_nurse', [AdminController::class, 'storeAssignTriageNurse'])->name('assign-triage_nurse.store');
    Route::post('/departments/{departmentId}/doctors/{doctorId}/remove', [AdminController::class, 'removeDoctorFromDepartment'])->name('doctors.remove');
    Route::post('/departments/{departmentId}/nurses/{nurseId}/remove', [AdminController::class, 'removeNurseFromDepartment'])->name('nurses.remove');
    Route::post('/departments/{departmentId}/triage_nurses/{triagenurseId}/remove', [AdminController::class, 'removeTriageNurseFromDepartment'])->name('triage_nurses.remove');


    //Delete Functions
    Route::delete('/{userType}/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    });



/////////////////////////////////// Doctor

Route::middleware('doctor')->group(function (){
    Route::get('doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor_dashboard');
    Route::get('doctor/treatmentplan', [DoctorController::class, 'treatmentPlan'])->name('doctor_treatmentPlan');
    Route::get('doctor/medicalorder', [DoctorController::class, 'medicalOrder'])->name('doctor_medicalOrder');
    Route::get('doctor/AddPlan/{id}', [DoctorController::class, 'AddPlan'])->name('doctor_addplan');
    Route::get('doctor/AddOrder/{id}', [DoctorController::class, 'AddOrder'])->name('doctor_addorder');
    Route::get('doctor/DetailsPatient/{id}', [DoctorController::class, 'Details'])->name('doctor_detailspatient');
    Route::get('doctor/PatientRecord/{id}', [DoctorController::class, 'PatientRecord'])->name('doctor_patientrecord');
    Route::get('doctor/Record/{id}', [DoctorController::class, 'Record'])->name('doctor_record');
    Route::get('doctor/treatmentplanpage/{id}', [DoctorController::class, 'TreatmentPlanPage'])->name('doctor_treatmentplanpage');
    Route::get('doctor/orderpage/{id}', [DoctorController::class, 'OrderPage'])->name('doctor_orderpage');
    Route::get('doctor/AddTreatment/{id}', [DoctorController::class, 'AddTreatment'])->name('doctor_addtreatment');
    Route::post('/doctor/{patientId}/storeTreatment', [DoctorController::class, 'storeTreatment'])->name('storeTreatment');
    Route::get('doctor/AddMedicalOrder/{id}', [DoctorController::class, 'AddMedicalOrder'])->name('doctor_addmedicalorder');
    Route::post('/doctor/{patientId}/storeOrder', [DoctorController::class, 'storeOrder'])->name('storeOrder');
    Route::post('/doctor/order/{id}/update-status', [DoctorController::class, 'updateOrderStatus'])->name('doctor.updateOrderStatus');
    Route::post('/doctor/{id}/discharge', [DoctorController::class, 'discharge'])->name('doctor.discharge');


    // QR Codes
    Route::get('/doctor/qr-code/{patientRecordId}', [QrCodeController::class, 'show']);
    Route::get('/doctor/record/qr-code/{patientRecordId}', [QrCodeController::class, 'showRecord']);
    Route::get('/doctor/order/qr-code/{patientRecordId}', [QrCodeController::class, 'showOrder']);
   

    //Profile
    Route::get('doctor/profile/{id}', [DoctorController::class, 'profile'])->name('doctor_profile');
    Route::get('doctor/profile/{id}/changepass', [DoctorController::class, 'changepass'])->name('doctor_changepass');
    Route::post('doctor/profile/doctor_submitpass', [DoctorController::class, 'doctor_submitpass'])->name('doctor_submitpass');
    Route::get('doctor/profile/{id}/changeinfo', [DoctorController::class, 'changeinfo'])->name('doctor_changeinfo');
    Route::post('doctor/profile/doctor_submitinfo', [DoctorController::class, 'doctor_submitinfo'])->name('doctor_submitinfo');
    Route::post('doctor/profile/doctor_submitemergencyinfo', [DoctorController::class, 'doctor_submitemergencyinfo'])->name('doctor_submitemergencyinfo');
    Route::get('doctor/profile/{id}/sessions', [DoctorController::class, 'showSessions'])->name('doctor_sessions');

    });

/////////////////////////////////// Nurse

Route::middleware('nurse')->group(function (){
    ////////////profile
    Route::get('nurse/profile/{id}', [NurseController::class, 'profile'])->name('nurse_profile');
    Route::get('nurse/profile/{id}/changepass', [NurseController::class, 'changepass'])->name('nurse_changepass');
    Route::post('nurse/profile/nurse_submitpass', [NurseController::class, 'nurse_submitpass'])->name('nurse_submitpass');
    Route::get('nurse/profile/{id}/changeinfo', [NurseController::class, 'changeinfo'])->name('nurse_changeinfo');
    Route::post('nurse/profile/nurse_submitinfo', [NurseController::class, 'nurse_submitinfo'])->name('nurse_submitinfo');
    Route::post('nurse/profile/nurse_submitemergencyinfo', [NurseController::class, 'nurse_submitemergencyinfo'])->name('nurse_submitemergencyinfo');
    Route::get('nurse/profile/{id}/sessions', [NurseController::class, 'showSessions'])->name('nurse_sessions');
    Route::get('/nurse/patient-charts', [NurseController::class, 'showPatientCharts'])->name('nurse_patient_charts');


    Route::get('nurse/dashboard', [NurseController::class, 'dashboard'])->name('nurse_dashboard');
    Route::get('nurse/DetailsPatient/{id}', [NurseController::class, 'Details'])->name('nurse_detailspatient');
    Route::get('nurse/AddChart/{id}', [NurseController::class, 'AddChart'])->name('nurse_addchart');
    Route::post('nurse/{patientId}/store', [NurseController::class, 'storeData'])->name('nurse_storeData');
    Route::get('nurse/PatientRecord/{id}', [NurseController::class, 'PatientRecord'])->name('nurse_patientrecord');
    Route::get('nurse/Record/{id}', [NurseController::class, 'Record'])->name('nurse_record');
    Route::get('nurse/AddPatient/{id}', [NurseController::class, 'AddPatient'])->name('nurse_addpatient');

    // QR Codes
    Route::get('/nurse/qr-code/{patientRecordId}', [QrCodeController::class, 'show']);
    Route::get('/record/qr-code/{patientRecordId}', [QrCodeController::class, 'showRecord']);
    
    });

/////////////////////////////////// Triage Nurse

Route::middleware('triagenurse')->group(function (){
    //////////////// profile
    Route::get('triagenurse/profile/{id}', [TriageNurseController::class, 'triage_profile'])->name('triagenurse_profile');
    Route::get('triagenurse/profile/{id}/changepass', [TriageNurseController::class, 'changepass'])->name('triagenurse_changepass');
    Route::post('triagenurse/profile/triagenurse_submitpass', [TriageNurseController::class, 'triagenurse_submitpass'])->name('triagenurse_submitpass');
    Route::get('triagenurse/profile/{id}/changeinfo', [TriageNurseController::class, 'changeinfo'])->name('triagenurse_changeinfo');
    Route::post('triagenurse/profile/triagenurse_submitinfo', [TriageNurseController::class, 'triagenurse_submitinfo'])->name('triagenurse_submitinfo');
    Route::post('triagenurse/profile/triagenurse_submitemergencyinfo', [TriageNurseController::class, 'triagenurse_submitemergencyinfo'])->name('triagenurse_submitemergencyinfo');
    Route::get('triagenurse/profile/{id}/sessions', [TriageNurseController::class, 'showSessions'])->name('triagenurse_sessions');

    Route::get('triagenurse/dashboard', [TriageNurseController::class, 'dashboard'])->name('triagenurse_dashboard');
    Route::post('triagenurse/generateqrcode', [TriageNurseController::class, 'generateQRCode'])->name('generate_qrcode');
    Route::get('triagenurse/AddPatient/{id}', [TriageNurseController::class, 'AddPatient'])->name('triagenurse_addpatient');
    Route::post('/triagenurse/{patientId}/store', [TriageNurseController::class, 'storeData'])->name('storeData');
    Route::get('triagenurse/DetailsPatient/{id}', [TriageNurseController::class, 'Details'])->name('triagenurse_detailspatient');
    Route::get('triagenurse/ProfilePatient/{id}', [TriageNurseController::class, 'Profile'])->name('triagenurse_profilepatient');
    Route::post('triagenurse{id}/storeProfile', [TriageNurseController::class, 'storeProfile'])->name('storeProfile');
    Route::get('triagenurse/PatientRecord/{id}', [TriageNurseController::class, 'PatientRecord'])->name('triagenurse_patientrecord');
    Route::get('triagenurse/Record/{id}', [TriageNurseController::class, 'Record'])->name('triagenurse_record');
    
    // QR Codes
    Route::get('/qr-code/{patientRecordId}', [QrCodeController::class, 'show']);
    Route::get('/triagenurse/record/qr-code/{patientRecordId}', [QrCodeController::class, 'showRecord']);

    ////////// Add Patient Logic
    Route::get('triagenurse/patients/register', [TriageNurseController::class, 'PatientRegister'])->name('triage_patient_register');
    Route::post('triagenurse/patients/post/register', [TriageNurseController::class, 'patientPostRegistration'])->name('triage.patient.register.post');
    

    });

/////////////////////////////////// patient

Route::middleware('patient')->group(function (){
    Route::get('patient/dashboard', [PatientController::class, 'dashboard'])->name('patient_dashboard');
    Route::get('patient/profile/{id}', [PatientController::class, 'profile'])->name('patient_profile');
    Route::get('patient/profile/{id}/changepass', [PatientController::class, 'changepass'])->name('patient_changepass');
    Route::post('patient/profile/patient_submitpass', [PatientController::class, 'patient_submitpass'])->name('patient_submitpass');
    Route::get('patient/profile/{id}/changeinfo', [PatientController::class, 'changeinfo'])->name('patient_changeinfo');
    Route::post('patient/profile/patient_submitinfo', [PatientController::class, 'patient_submitinfo'])->name('patient_submitinfo');
    Route::post('patient/profile/patient_submitemergencyinfo', [PatientController::class, 'patient_submitemergencyinfo'])->name('patient_submitemergencyinfo');
    Route::get('patient/profile/{id}/sessions', [PatientController::class, 'showSessions'])->name('patient_sessions');

    Route::get('patient/DetailsPatient/{id}', [PatientController::class, 'Details'])->name('patient_detailspatient');
    Route::get('patient/PatientRecord/{id}', [PatientController::class, 'PatientRecord'])->name('patient_patientrecord');
    Route::get('patient/Record/{id}', [PatientController::class, 'Record'])->name('patient_record');
    Route::get('patient/treatmentplanpage/{id}', [PatientController::class, 'TreatmentPlanPage'])->name('patient_treatmentplanpage');
    Route::get('patient/orderpage/{id}', [PatientController::class, 'OrderPage'])->name('patient_orderpage');
    Route::get('patient/patient_treatmentplan/{id}', [PatientController::class, 'TreatmentPlan'])->name('patient_treatmentplan');
    Route::get('patient/Treatments/{id}', [PatientController::class, 'Treatments'])->name('patient_treatments');
    

    // QR Codes
    Route::get('/patient/qr-code/{patientRecordId}', [QrCodeController::class, 'show']);
    Route::get('/patient/record/qr-code/{patientRecordId}', [QrCodeController::class, 'showRecord']);
    Route::get('/patient/order/qr-code/{patientRecordId}', [QrCodeController::class, 'showOrder']);

    //verify password
    Route::post('/verify-password', [PatientController::class, 'verifyPassword'])->name('verify-password');
    });


    //////////////// Department
    Route::middleware('department')->group(function (){
        
        Route::get('department/dashboard', [DepartmentController::class, 'dashboard'])->name('department_dashboard');
        Route::get('department/medicalOrders', [DepartmentController::class, 'MedicalOrders'])->name('department_medical_order');
        Route::get('department/scanqr', [DepartmentController::class, 'ScanQR'])->name('department_scan_qr');
        Route::post('department/order/{id}/update-status', [DepartmentController::class, 'updateOrderStatus'])->name('department.updateOrderStatus');
        Route::get('department/doctors/{id}/order', [DepartmentController::class, 'showOrder'])->name('department_order');
        Route::get('department/doctors/{id}/profile', [DepartmentController::class, 'showDoctorProfile'])->name('department_doctors_profile');
        Route::get('department/nurses/{id}/profile', [DepartmentController::class, 'showNurseProfile'])->name('department_nurses_profile');
        Route::get('department/triagenurse/{id}/profile', [DepartmentController::class, 'showTriageProfile'])->name('department_triage_nurses_profile');
        Route::post('{departmentId}/doctors/{doctorId}/remove', [DepartmentController::class, 'removeDoctorFromDepartment'])->name('department.doctors.remove');
        Route::post('{departmentId}/nurses/{nurseId}/remove', [DepartmentController::class, 'removeNurseFromDepartment'])->name('department.nurses.remove');
        Route::post('{departmentId}/triage_nurses/{triagenurseId}/remove', [DepartmentController::class, 'removeTriageNurseFromDepartment'])->name('department.triage_nurses.remove');
       

        ////////// profile
        Route::get('department/profile/{id}', [DepartmentController::class, 'profile'])->name('department_profile');
        Route::get('department/profile/{id}/changepass', [DepartmentController::class, 'changepass'])->name('department_changepass');
        Route::post('department/profile/department_submitpass', [DepartmentController::class, 'department_submitpass'])->name('department_submitpass');
        Route::get('department/profile/{id}/sessions', [DepartmentController::class, 'showSessions'])->name('department_sessions');
        });

    
        Route::get('/patient-record/{patientRecord}', [TriageNurseController::class, 'showQR'])->name('patientRecord.show');
        Route::get('/nurse/patient-record/{record}', [NurseController::class, 'showQR'])->name('Record.show');
        Route::get('/doctor/order/{order}', [DoctorController::class, 'showQR'])->name('Order.show');
    
    
    
