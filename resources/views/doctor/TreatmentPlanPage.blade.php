@extends('layouts.doctor')
 
@section('title', 'Dashboard')
 
@section('contents')

<!-- Back Button -->
<div class="p-6">
    <button onclick="window.history.back()" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <i class="ri-arrow-left-line text-xl"></i> <!-- Remixicon arrow left icon -->
    </button>
</div>

<div class="p-6 rounded-lg bg-gray-100 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-md w-full max-w-4xl">
        <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
            Test/Medication Details
        </div>
        <div class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->title }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Initial Test</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->test->initial_test }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Note</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->test->note }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Medication</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->test->medication }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Lab Test</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->test->lab_test }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Diagnose</label>
                <p class="bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md w-full">{{ $patient->test->diagnose }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
