@extends('layouts.triagenurse')

@section('title', 'Admission Registration')

@section('contents')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden max-w-3xl mx-auto">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 h-2 bg-gray-200 w-full rounded-full">
            <div id="progress-bar" class="h-2 bg-blue-600 rounded-full transition-all duration-300" style="width: 33%;"></div>
        </div>

        <!-- Start of Form -->
        <form action="{{ route('storeData', $patient->id) }}" method="POST">
            @csrf

            <!-- Step 1: Test/Medication -->
            <div id="step1" class="step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 1: Test/Medication</div>

                <div class="space-y-4">

                    <div>
                        <label for="chief_complaint" class="block text-sm font-medium text-gray-700">Chief Complaint</label>
                        <input type="text" id="chief_complaint" name="chief_complaint" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('chief_complaint')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="medication" class="block text-sm font-medium text-gray-700">Medication</label>
                        <input type="text" id="medication" name="medication" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('medication')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                        <input type="text" id="note" name="note" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('note')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button id="next1" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <!-- Step 2: Patient Vital Signs -->
            <div id="step2" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 2: Patient Vital Signs</div>

                <div class="space-y-4">
                    <div>
                        <label for="body_temperature" class="block text-sm font-medium text-gray-700">Body Temperature</label>
                        <input type="number" step="any" id="body_temperature" name="body_temperature" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <p class="text-xs text-gray-500 mt-1">Body temperature is assumed to be in degrees Celsius (°C), e.g., 36.50°C (store it as 36.50)</p>
                        @error('body_temperature')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="systolic_pressure" class="block text-sm font-medium text-gray-700">Systolic Pressure</label>
                        <input type="number" step="any" id="systolic_pressure" name="systolic_pressure" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <p class="text-xs text-gray-500 mt-1">Systolic pressure is assumed to be in millimeters of mercury (mmHg), e.g., 120/80 mmHg (store it as 120.80)</p>
                        @error('systolic_pressure')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="diastolic_pressure" class="block text-sm font-medium text-gray-700">Diastolic Pressure</label>
                        <input type="number" step="any" id="diastolic_pressure" name="diastolic_pressure" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <p class="text-xs text-gray-500 mt-1">Diastolic pressure is assumed to be in millimeters of mercury (mmHg), e.g., 120/80 mmHg (store it as 120.80)</p>
                        @error('diastolic_pressure')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="respiratory_rate" class="block text-sm font-medium text-gray-700">Respiratory Rate</label>
                        <input type="number" step="any" id="respiratory_rate" name="respiratory_rate" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <p class="text-xs text-gray-500 mt-1">Respiratory rate is assumed to be in breaths per minute (bpm), e.g., 162.00 bpm</p>
                        @error('respiratory_rate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Weight</label>
                        <input type="number" step="any" id="weight" name="weight" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <p class="text-xs text-gray-500 mt-1">Weight is assumed to be in kilograms (kg), e.g., 250.34 kg</p>
                        @error('weight')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Height</label>
                        <input type="number" step="any" id="height" name="height" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <p class="text-xs text-gray-500 mt-1">Height is assumed to be in centimeters (cm), e.g., 174.45 cm</p>
                        @error('height')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="pulse_rate" class="block text-sm font-medium text-gray-700">Pulse Rate</label>
                        <input type="number" step="any" id="pulse_rate" name="pulse_rate" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <p class="text-xs text-gray-500 mt-1">Pulse rate is assumed to be in beats per minute (bpm), e.g., 72.00 bpm</p>
                        @error('pulse_rate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button id="back1" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button id="next2" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <!-- Step 3: Admission Details -->
            <div id="step3" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 3: Admission Details</div>

                <div class="space-y-4">
                    <div>
                        <label for="reason_for_admission" class="block text-sm font-medium text-gray-700">Reason for Admission</label>
                        <input type="text" id="reason_for_admission" name="reason_for_admission" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('reason_for_admission')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="room" class="block text-sm font-medium text-gray-700">Room</label>
                        <input type="text" id="room" name="room" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('room')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="attending_physician" class="block text-sm font-medium text-gray-700">Attending Physician</label>
                        <select id="attending_physician" name="attending_physician" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="" disabled selected>Select a physician</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('attending_physician')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="attending_nurse" class="block text-sm font-medium text-gray-700">Attending Nurse</label>
                        <select id="attending_nurse" name="attending_nurse" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="" disabled selected>Select a nurse</option>
                            @foreach ($nurses as $nurse)
                                <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                            @endforeach
                        </select>
                        @error('attending_nurse')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="admitting_date_and_time" class="block text-sm font-medium text-gray-700">Admission Date</label>
                        <input type="datetime-local" id="admitting_date_and_time" name="admitting_date_and_time" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @error('admitting_date_and_time')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="admitting_department" class="block text-sm font-medium text-gray-700">Admitting Department</label>
                        <select id="admitting_department" name="admitting_department" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="">Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="flex justify-between mt-6">
                    <button id="back2" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('next1').addEventListener('click', function() {
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function(error) {
            error.remove();
        });

        // Get the values of the input fields in Step 1
        var chiefComplaint = document.getElementById('chief_complaint').value;
        var medication = document.getElementById('medication').value;
        var note = document.getElementById('note').value;

        var valid = true;

        // Check if all fields are filled out
        if (chiefComplaint.trim() === "") {
            valid = false;
            showError('chief_complaint', 'Chief complaint is required.');
        }

        if (medication.trim() === "") {
            valid = false;
            showError('medication', 'Medication is required.');
        }

        if (note.trim() === "") {
            valid = false;
            showError('note', 'Note is required.');
        }

        if (valid) {
            // If all fields are filled, move to the next step
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            document.getElementById('progress-bar').style.width = '66%';
        }
    });

    document.getElementById('next2').addEventListener('click', function() {
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function(error) {
            error.remove();
        });

        // Get the values of the input fields in Step 2
        var bodyTemperature = document.getElementById('body_temperature').value;
        var systolicPressure = document.getElementById('systolic_pressure').value;
        var diastolicPressure = document.getElementById('diastolic_pressure').value;
        var respiratoryRate = document.getElementById('respiratory_rate').value;
        var weight = document.getElementById('weight').value;
        var height = document.getElementById('height').value;
        var pulseRate = document.getElementById('pulse_rate').value;

        var valid = true;

        // Regular expression to check for numbers with up to 2 decimal places
        var decimalPattern = /^\d{1,3}(\.\d{1,2})?$/;

        // Maximum allowed value for validation
        var maxBodyTemperature = 999.99;
        var maxPressure = 999.99;
        var maxRespiratoryRate = 999.99;
        var maxWeight = 999.99;
        var maxHeight = 999.99;
        var maxPulseRate = 999.99;

        // Check if the values match the decimal format and the limits
        if (!decimalPattern.test(bodyTemperature)) {
            valid = false;
            showError('body_temperature', 'Body temperature must be a valid number with up to 2 decimal places and should not exceed 999.99.');
        } else if (parseFloat(bodyTemperature) > maxBodyTemperature) {
            valid = false;
            showError('body_temperature', 'Body temperature cannot exceed 999.99.');
        }

        if (!decimalPattern.test(systolicPressure)) {
            valid = false;
            showError('systolic_pressure', 'Systolic pressure must be a valid number with up to 2 decimal places and should not exceed 999.99.');
        } else if (parseFloat(systolicPressure) > maxPressure) {
            valid = false;
            showError('systolic_pressure', 'Systolic pressure cannot exceed 999.99.');
        }

        if (!decimalPattern.test(diastolicPressure)) {
            valid = false;
            showError('diastolic_pressure', 'Diastolic pressure must be a valid number with up to 2 decimal places and should not exceed 999.99.');
        } else if (parseFloat(diastolicPressure) > maxPressure) {
            valid = false;
            showError('diastolic_pressure', 'Diastolic pressure cannot exceed 999.99.');
        }

        if (!decimalPattern.test(respiratoryRate)) {
            valid = false;
            showError('respiratory_rate', 'Respiratory rate must be a valid number with up to 2 decimal places and should not exceed 999.99.');
        } else if (parseFloat(respiratoryRate) > maxRespiratoryRate) {
            valid = false;
            showError('respiratory_rate', 'Respiratory rate cannot exceed 999.99.');
        }

        if (!decimalPattern.test(weight)) {
            valid = false;
            showError('weight', 'Weight must be a valid number with up to 2 decimal places and should not exceed 999.99.');
        } else if (parseFloat(weight) > maxWeight) {
            valid = false;
            showError('weight', 'Weight cannot exceed 999.99.');
        }

        if (!decimalPattern.test(height)) {
            valid = false;
            showError('height', 'Height must be a valid number with up to 2 decimal places and should not exceed 999.99.');
        } else if (parseFloat(height) > maxHeight) {
            valid = false;
            showError('height', 'Height cannot exceed 999.99.');
        }

        if (!decimalPattern.test(pulseRate)) {
            valid = false;
            showError('pulse_rate', 'Pulse rate must be a valid number with up to 2 decimal places and should not exceed 999.99.');
        } else if (parseFloat(pulseRate) > maxPulseRate) {
            valid = false;
            showError('pulse_rate', 'Pulse rate cannot exceed 999.99.');
        }

        // If all fields are valid, move to the next step
        if (valid) {
            document.getElementById('step2').classList.add('hidden');
            document.getElementById('step3').classList.remove('hidden');
            document.getElementById('progress-bar').style.width = '100%';
        }
    });

    document.getElementById('back1').addEventListener('click', function() {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('progress-bar').style.width = '33%';
    });

    document.getElementById('back2').addEventListener('click', function() {
        document.getElementById('step3').classList.add('hidden');
        document.getElementById('step2').classList.remove('hidden');
        document.getElementById('progress-bar').style.width = '66%';
    });

    // Add validation for Step 3
    document.getElementById('next3').addEventListener('click', function() {
        // Clear previous error messages
        document.querySelectorAll('.error-message').forEach(function(error) {
            error.remove();
        });

        // Get the values of the input fields in Step 3
        var reasonForAdmission = document.getElementById('reason_for_admission').value;
        var room = document.getElementById('room').value;
        var attendingPhysician = document.getElementById('attending_physician').value;
        var attendingNurse = document.getElementById('attending_nurse').value;
        var admittingDateAndTime = document.getElementById('admitting_date_and_time').value;
        var admittingDepartment = document.getElementById('admitting_department').value;

        var valid = true;

        // Check if the fields are filled out
        if (reasonForAdmission.trim() === "") {
            valid = false;
            showError('reason_for_admission', 'Reason for admission is required.');
        }

        if (room.trim() === "") {
            valid = false;
            showError('room', 'Room is required.');
        }

        if (!attendingPhysician) {
            valid = false;
            showError('attending_physician', 'Attending physician is required.');
        }

        if (!attendingNurse) {
            valid = false;
            showError('attending_nurse', 'Attending nurse is required.');
        }

        if (!admittingDateAndTime) {
            valid = false;
            showError('admitting_date_and_time', 'Admission date and time is required.');
        }

        if (!admittingDepartment) {
            valid = false;
            showError('admitting_department', 'Admitting department is required.');
        }

        // If all fields are valid, allow form submission (or proceed to submit)
        if (valid) {
            document.getElementById('step3').classList.add('hidden');
            document.getElementById('progress-bar').style.width = '100%';  // or submit the form
        }
    });

    // Function to display error messages
    function showError(fieldId, message) {
        var inputField = document.getElementById(fieldId);
        var errorMessage = document.createElement('span');
        errorMessage.classList.add('error-message', 'text-red-500', 'text-sm');
        errorMessage.innerText = message;
        inputField.parentNode.appendChild(errorMessage);
    }
</script>



@endsection
