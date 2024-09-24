@extends('layouts.admin')

@section('title', 'Assign Nurse to Department')

@section('contents')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden">
        <!-- Header -->
        <h2 class="text-lg font-semibold text-gray-800 mb-2 text-center">Assign Nurse to Department</h2>
        <p class="text-sm text-gray-600 mb-6 text-center">Select a nurse and a department to make an assignment.</p>

        <!-- Form to Assign Nurse to Department -->
        <form action="{{ route('assign-nurse.store') }}" method="POST">
            @csrf
            <!-- Nurse Selection -->
            <div class="space-y-4">
                <div class="mb-4">
                    <label for="nurse-select" class="block text-sm font-medium text-gray-700">Select Nurse</label>
                    <select name="nurse_id" id="nurse-select" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none">
                        <option value="">Choose a nurse</option>
                        @foreach($nurses as $nurse)
                            <option value="{{ $nurse->id }}">{{ $nurse->name }}</option>
                        @endforeach
                    </select>
                    @error('nurse_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Department Selection -->
                <div class="mb-4">
                    <label for="department-select" class="block text-sm font-medium text-gray-700">Select Department</label>
                    <select name="department_id" id="department-select" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none">
                        <option value="">Choose a department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200 w-full">Assign Nurse</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
