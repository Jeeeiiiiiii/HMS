@extends('layouts.patient')

@section('title', 'Details')

@section('contents')
<div class="p-6 space-y-6">

    <!-- Patient Case and Name Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT CASE:</div>
                <div class="text-lg font-semibold text-gray-600">P-{{ $patient->id ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-lg">
            <div class="flex justify-between items-center">
                <div class="text-lg font-semibold text-gray-600">PATIENT NAME:</div>
                <div class="text-lg font-semibold text-gray-800">{{ $patient->profile->name ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Details and Doctors Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Patient Details -->
        <div class="lg:col-span-1 bg-white rounded-md border border-gray-100 shadow-lg">
            <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4">
                Details
            </div>
            <div class="p-6 space-y-4">
                @foreach (['AGE' => $patient->profile->age, 'BIRTHDAY' => $patient->profile->birthday, 'BIRTHPLACE' => $patient->profile->birthplace, 'CIVIL STATUS' => $patient->profile->civil_status, 'RELIGION' => $patient->profile->religion, 'NATIONALITY' => $patient->profile->nationality, 'GENDER' => $patient->profile->gender, 'TELEPHONE NO.' => $patient->profile->telephone_no] as $label => $value)
                <div>
                    <div class="text-sm font-semibold text-gray-500">{{ $label }}</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $value ?? 'N/A' }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Admission Details -->
        <div class="lg:col-span-2 bg-white rounded-md border border-gray-100 shadow-lg">
            <div class="bg-gray-600 text-white text-lg font-semibold rounded-t-lg p-4 flex justify-between items-center">
                <div>Admission Records</div>
                <a href="{{ route('emergencyroom_addorder', $patient->id) }}" class="text-white-600 hover:text-blue-500 transition-colors">
                    <i class="ri-edit-box-line"></i>
                </a>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-center text-gray-600 border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">ER Medical Order</th>
                                <th class="px-4 py-2 font-semibold border-b border-r border-gray-300">Order Status</th>
                                <th class="px-4 py-2 font-semibold border-b border-gray-300">Admission Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->er_order as $record)
                            <tr>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    <a href="{{ route('patient_orderpageER', $record->id) }}" class="text-blue-700 hover:text-blue-500 font-semibold transition-colors duration-100 ease-in-out">
                                        {{ $record->type }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 border-b border-r border-gray-200">
                                    @if ($record->order_status === 'pending')
                                        <span class="text-lg font-semibold text-yellow-400">Pending</span>
                                    @elseif ($record->order_status === 'completed')
                                        <span class="text-lg font-semibold text-green-400">Completed</span>
                                    @else
                                        <span class="text-lg font-semibold text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    @if ($record->status === 'pending')
                                        <span class="text-lg font-semibold text-yellow-400">Pending</span>
                                    @elseif ($record->status === 'admitted')
                                        <span class="text-lg font-semibold text-green-400">Admitted</span>
                                    @elseif ($record->status === 'not admitted')
                                        <span class="text-lg font-semibold text-gray-400">Not Admitted</span>
                                    @elseif ($record->status === 'discharged')
                                        <span class="text-lg font-semibold text-red-400">Discharged</span>
                                    @else
                                        <span class="text-lg font-semibold text-gray-400">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
