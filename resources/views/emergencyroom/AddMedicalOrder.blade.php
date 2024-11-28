@extends('layouts.emergencyroom')

@section('title', 'Add Medical Order')

@section('contents')

<!-- Back Button -->
<div class="mb-6 p-6">
    <button onclick="goBack()" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <i class="ri-arrow-left-line text-xl"></i> <!-- Remixicon arrow left icon -->
    </button>
</div>

<div class="p-6 rounded-lg bg-gray-100 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-4xl">
        <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
            Create Order
        </div>
        <div class="p-6">
            <form action="{{ route('emergencyroom_storeOrder', $patientRecord->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" id="title" name="title" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Order Type -->
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700">Order Type</label>
                    <select id="type" name="type" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        <option value="lab_test">Lab Test</option>
                        <option value="procedure">Procedure</option>
                        <option value="imaging">Imaging</option>
                        <option value="medication">Medication</option>
                        <option value="other">Other</option>
                    </select>
                    @error('type')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Department -->
                <div class="mb-4">
                    <label for="admitting_department" class="block text-sm font-medium text-gray-700">Department</label>
                    <select id="admitting_department" name="admitting_department" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                        <option value="">Select a department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('admitting_department')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Attending Physician -->
                <div class="mb-4">
                    <label for="admitting_doctor" class="block text-sm font-medium text-gray-700">Attending Physician</label>
                    <select id="admitting_doctor" name="admitting_doctor" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        <option value="" disabled selected>Select a physician</option>
                        <!-- Doctors will be dynamically populated here -->
                    </select>
                    @error('admitting_doctor')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Order Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" rows="3" placeholder="Detailed description of the order (e.g., ECG to monitor heart activity)"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Order Status -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">
                        Pending
                    </p>
                    <input type="hidden" name="status" value="pending">
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>



                <!-- Order Date -->
                <div class="mb-4">
                    <label for="order_date" class="block text-sm font-medium text-gray-700">Order Date</label>
                    <input type="date" id="order_date" name="order_date" class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full focus:outline-none focus:ring-2 focus:ring-gray-500" required>
                    @error('order_date')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-4">
                    <button type="submit" class="bg-blue-500 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

function goBack() {
    if (document.referrer) {
        // If there is a referrer, go back to the referring page
        window.location.href = document.referrer;
    } else {
        // Fallback URL if there is no referrer (e.g., when opened in a new tab)
        window.location.href = '/your-fallback-url'; // Replace with the URL you want to redirect to
    }
}

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // When the department is selected
        $('#admitting_department').on('change', function() {
            var departmentId = $(this).val(); // Get selected department ID
            
            // Clear the doctor dropdown and disable it until we fetch the data
            $('#admitting_doctor').empty().append('<option value="" disabled selected>Loading...</option>');
            
            if (departmentId) {
                // Use fetch API to get doctors for the selected department
                fetch(`/get-doctors-by-department?department_id=${departmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Empty the dropdown and add default option
                        $('#admitting_doctor').empty().append('<option value="" disabled selected>Select a physician</option>');
                        
                        // Check if doctors are returned
                        if (data.doctors.length > 0) {
                            // Loop through the returned doctors and append them to the dropdown
                            data.doctors.forEach(doctor => {
                                $('#admitting_doctor').append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                            });
                        } else {
                            // If no doctors found, display message
                            $('#admitting_doctor').append('<option value="" disabled>No doctors found for this department</option>');
                        }
                    })
                    .catch(error => {
                        // Handle any errors
                        console.error('Error fetching doctors:', error);
                        $('#admitting_doctor').empty().append('<option value="" disabled>Error loading doctors</option>');
                    });
            } else {
                // If no department selected, clear the doctor dropdown
                $('#admitting_doctor').empty().append('<option value="" disabled selected>Select a physician</option>');
            }
        });
    });
</script>



@endsection