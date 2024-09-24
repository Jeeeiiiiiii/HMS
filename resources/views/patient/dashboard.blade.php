@extends('layouts.patient')

@section('title', 'Dashboard')

@section('contents')
<div class="p-6">
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Latest Medical Orders Section -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Latest Medical Orders</h2>
                <ul class="space-y-2">
                    @forelse($medicalOrders as $order)
                            <li class="flex flex-col p-3 bg-gray-50 rounded-md">
                            <div class="flex justify-between mb-2">
                                <div>
                                    <i class="ri-capsule-fill text-xl text-blue-500 mr-2"></i>
                                    <span class="font-semibold">{{ $order->type ?? 'N/A' }}</span>
                                </div>
                                <span class="text-gray-600">
                                    {{ Str::limit($order->description ?? 'No description available', 30, '...') }}
                                </span>
                            </div>
                            <p class="text-md text-gray-700">
                                Status: {{ $order->status ?? 'N/A' }}
                            </p>
                            <p class="text-md text-gray-700">
                                Ordered by Dr. {{ $order->doctor->name ?? 'N/A' }}
                            </p>
                            <p class="text-sm text-gray-700">
                                {{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('F j, Y \a\t g:i A') : 'N/A' }}
                            </p>
                        </li>
                    @empty
                        <li class="p-2 text-gray-500">No medical orders found.</li>
                    @endforelse
                </ul>
            </div>


            <!-- Latest Rounds Section -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Latest Rounds</h2>
                <ul class="space-y-3">
                    @foreach($rounds as $round)
                        <li class="flex flex-col p-3 bg-gray-50 rounded-md">
                            <div class="flex justify-between mb-2">
                                <div>
                                    <i class="ri-time-line text-xl text-blue-500 mr-2"></i>
                                    <span class="font-semibold">{{ $round->rounds ?? 'N/A' }}</span>
                                </div>
                                <span class="text-gray-600">{{ $round->doctor->name ?? 'N/A' }}</span>
                            </div>
                            <div>
                            <span class="text-gray-600">
                                Reason for admission: {{ Str::limit($round->patientRecord->reason_for_admission ?? 'N/A', 50, '...') }}
                            </span>
                            </div>
                            <p class="text-sm text-gray-700">
                                {{ $round->admitting_date_and_time ? \Carbon\Carbon::parse($round->admitting_date_and_time)->format('F j, Y \a\t g:i A') : 'N/A' }}
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>


            <!-- Admission Information Section -->
            <div class="bg-white border border-gray-200 shadow-lg p-4 rounded-lg">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Admission Information</h2>
                <div class="space-y-4">
                    <div class = "bg-gray-50 rounded-md">
                        <div class = "flex">
                            <i class="ri-calendar-2-line  text-xl text-blue-500 mr-2"></i>
                            <h3 class="font-semibold text-gray-700">Admission Date</h3>
                        </div>
                        <p>{{ $admission && $admission->admitting_date_and_time ? \Carbon\Carbon::parse($admission->admitting_date_and_time)->format('F j, Y \a\t g:i A') : 'N/A' }}</p>

                    </div>
                    <div class="bg-gray-50 rounded-md">
                        <h3 class="font-semibold text-gray-700">Reason for Admission</h3>
                        <p>{{ Str::limit($admission ? $admission->reason_for_admission : 'N/A', 50, '...') }}</p>
                    </div>

                    <div class = "bg-gray-50 rounded-md">
                        <h3 class="font-semibold text-gray-700">Attending Physician</h3>
                        <p>{{ $admission ? $admission->doctor->name : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Sessions Section -->
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-lg mt-4 overflow-x-auto">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Sessions</h2>
            @foreach($sessions as $session)
                <div class="flex items-center mb-4 p-4 bg-gray-50 rounded-md shadow-sm hover:bg-gray-100 transition">
                    <!-- Display Browser Icon -->
                    @if (strpos($session->browser_name, 'Chrome') !== false)
                        <i class="ri-chrome-line text-2xl text-blue-600 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Safari') !== false)
                        <i class="ri-safari-line text-2xl text-blue-400 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Firefox') !== false)
                        <i class="ri-firefox-line text-2xl text-orange-600 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Edge') !== false)
                        <i class="ri-edge-line text-2xl text-blue-700 mr-4"></i>
                    @elseif (strpos($session->browser_name, 'Opera') !== false)
                        <i class="ri-opera-line text-2xl text-red-600 mr-4"></i>
                    @else
                        <i class="ri-global-line text-2xl text-gray-600 mr-4"></i>
                    @endif

                    <!-- Display Session Details -->
                    <div>
                        <p class="font-medium text-gray-800">{{ $session->device_name }}</p>
                        <p class="text-sm text-gray-600">{{ $session->browser_name }} - {{ $session->last_active_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
