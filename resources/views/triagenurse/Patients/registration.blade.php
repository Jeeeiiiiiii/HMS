@extends('layouts.registration')

@section('title', 'Patient Registration')

@section('contents')
<div class="p-6 max-w-2xl mx-auto">
    <div class="bg-white border border-gray-100 shadow-md p-6 rounded-md relative overflow-hidden">
        <!-- Progress Bar -->
        <div class="absolute top-0 left-0 h-2 bg-gray-200 w-full rounded-full">
            <div id="progress-bar" class="h-2 bg-blue-600 rounded-full transition-all duration-300" style="width: 33%;"></div>
        </div>

        <!-- Start of Form -->
        <form action="{{ route('patient_post_final') }}" method="POST">
            @csrf <!-- Always include CSRF token for form security -->
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div id="step1" class="step">Patient Registration
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 1: Basic Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required autofocus>
                        @if ($errors->has('name'))
                            <span class="text-red-500 text-sm">{{ $errors->first('name') }}</span>
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
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 2: Personal Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                        <input type="number" id="age" name="age" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('age'))
                            <span class="text-red-500 text-sm">{{ $errors->first('age') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                        <input type="date" id="birthday" name="birthday" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('birthday'))
                            <span class="text-red-500 text-sm">{{ $errors->first('birthday') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select id="gender" name="gender" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        @if ($errors->has('gender'))
                            <span class="text-red-500 text-sm">{{ $errors->first('gender') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="birthplace" class="block text-sm font-medium text-gray-700">Birthplace</label>
                        <input type="text" id="birthplace" name="birthplace" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('birthplace'))
                            <span class="text-red-500 text-sm">{{ $errors->first('birthplace') }}</span>
                        @endif
                    </div>
                    
                    <div>
                        <label for="telephone_no" class="block text-sm font-medium text-gray-700">Telephone No.</label>
                        <input type="tel" id="telephone_no" name="telephone_no" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('telephone_no'))
                            <span class="text-red-500 text-sm">{{ $errors->first('telephone_no') }}</span>
                        @endif
                    </div>

                </div>

                <div class="flex justify-between mt-6">
                    <button id="back1" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
                    <button id="next2" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow transition duration-200">Next</button>
                </div>
            </div>

            <div id="step3" class="hidden step">
                <div class="font-semibold text-lg mb-4 text-gray-800 text-center">Step 3: Additional Information</div>

                <div class="space-y-4">
                    <div>
                        <label for="civil_status" class="block text-sm font-medium text-gray-700">Civil Status</label>
                        <input type="text" id="civil_status" name="civil_status" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('civil_status'))
                            <span class="text-red-500 text-sm">{{ $errors->first('civil_status') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="religion" class="block text-sm font-medium text-gray-700">Religion</label>
                        <input type="text" id="religion" name="religion" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('religion'))
                            <span class="text-red-500 text-sm">{{ $errors->first('religion') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
                        <input type="text" id="nationality" name="nationality" class="bg-gray-50 text-sm py-3 px-4 rounded-md w-full border border-gray-300 focus:border-blue-500 focus:outline-none" required>
                        @if ($errors->has('nationality'))
                            <span class="text-red-500 text-sm">{{ $errors->first('nationality') }}</span>
                        @endif
                    </div>
                </div>

                <div class="flex justify-between mt-6">
                    <button id="back2" type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-3 rounded-lg shadow transition duration-200">Back</button>
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
    const step3 = document.getElementById('step3');
    const progressBar = document.getElementById('progress-bar');

    document.getElementById('next1').addEventListener('click', function () {
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
        progressBar.style.width = '66%';
    });

    document.getElementById('back1').addEventListener('click', function () {
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        progressBar.style.width = '33%';
    });

    document.getElementById('next2').addEventListener('click', function () {
        step2.classList.add('hidden');
        step3.classList.remove('hidden');
        progressBar.style.width = '100%';
    });

    document.getElementById('back2').addEventListener('click', function () {
        step2.classList.remove('hidden');
        step3.classList.add('hidden');
        progressBar.style.width = '66%';
    });
});
</script>
@endsection
