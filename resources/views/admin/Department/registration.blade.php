@extends('layouts.registration')

@section('title', 'Department Registration')

@section('contents')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 h-2 bg-gray-200 w-full rounded-full">
            <div id="progress-bar" class="h-2 bg-blue-600 rounded-full transition-all duration-300" style="width: 50%;"></div>
        </div>

        <!-- Start of Form -->
        <form action="{{ route('department_post_final') }}" method="POST">
            @csrf <!-- Always include CSRF token for form security -->

            <div id="step1" class="step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Department Registration</div>
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 1: Basic Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="department_name" class="block text-sm font-medium text-gray-700">Department Name</label>
                        <input type="text" id="department_name" name="department_name" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required autofocus>
                        @if ($errors->has('department_name'))
                            <span class="text-red-500 text-sm">{{ $errors->first('department_name') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">E-Mail Address</label>
                        <input type="email" id="email" name="email" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('email'))
                            <span class="text-red-500 text-sm">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('password'))
                            <span class="text-red-500 text-sm">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation" class="text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required autocomplete="new-password">
                        @error('password_confirmation')
                            <span class="text-red-400 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="flex justify-end mt-6">
                    <button id="next1" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <div id="step2" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 2: Department Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="department_code" class="block text-sm font-medium text-gray-700">Department Code</label>
                        <input type="text" id="department_code" name="department_code" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('department_code'))
                            <span class="text-red-500 text-sm">{{ $errors->first('department_code') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                        <input type="text" id="address" name="address" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('address'))
                            <span class="text-red-500 text-sm">{{ $errors->first('address') }}</span>
                        @endif
                    </div>
                    
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone No.</label>
                        <input type="tel" id="phone_number" name="phone_number" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('phone_number'))
                            <span class="text-red-500 text-sm">{{ $errors->first('phone_number') }}</span>
                        @endif
                    </div>

                </div>

                <div class="flex justify-between mt-6">
                    <button id="back1" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Register</button>
                </div>
            </div>
        </form>
        <!-- End of Form -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const progressBar = document.getElementById('progress-bar');

    document.getElementById('next1').addEventListener('click', function () {
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
        progressBar.style.width = '100%';
    });

    document.getElementById('back1').addEventListener('click', function () {
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        progressBar.style.width = '50%';
    });
});
</script>
@endsection
