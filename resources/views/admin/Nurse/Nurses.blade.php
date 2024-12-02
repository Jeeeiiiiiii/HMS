@extends('layouts.admin')
 
@section('title', 'Nurses')
 
@section('contents')


<div class="p-6">
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex mb-4">
                <div class="font-medium text-lg text-gray-700">Nurses</div>
            </div>

            <!-- Search and Filter Section -->
            <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-4 gap-4 sm:gap-0">
                <form action="{{ route('admin_nurses') }}" method="GET" class="flex flex-col sm:flex-row w-full sm:w-auto gap-4">
                    <!-- Nurse Status Filter -->
                    <div>
                        <select name="status" class="w-full sm:w-[180px] border border-gray-300 rounded-lg p-2" onchange="this.form.submit()">
                            <option value="active" {{ request('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Search Input -->
                    <div class="flex w-full sm:w-auto items-center space-x-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search nurses..." class="w-full sm:w-auto bg-gray-50 text-sm text-gray-600 py-2 px-4 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>

                <!-- Add Nurse Button -->
                <div class="w-full sm:w-auto">
                    <a href="{{ route('nurse_register') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md text-sm px-4 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200 block text-center">Add Nurse</a>
                </div>
            </div>

            <!-- Status Information -->
            <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg">
                <span class="text-sm font-medium">
                    Showing {{ request('status', 'active') == 'active' ? 'Active' : 'Inactive' }} Nurses
                </span>
                <span class="text-sm text-gray-500">
                    Total: {{ $nurses->count() }} nurses
                </span>
            </div>


            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px]">
                    <thead>
                        <tr>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tl-md">#</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Name</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Email</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left">Date</th>
                            <th class="text-xs uppercase tracking-wide font-medium text-gray-400 py-2 px-4 bg-gray-50 text-left rounded-tr-md">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($nurses as $nurse)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $nurse->user->name ?? $nurse->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $nurse->email }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $nurse->created_at->format('Y-m-d') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin_nurses_profile', $nurse->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-blue-300 transition duration-200">Detail</a>
                                    <form action="{{ route($nurse->status == 'inactive' ? 'users.activate' : 'users.delete', ['userType' => 'nurse', 'id' => $nurse->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to {{ $nurse->status == 'inactive' ? 'reactivate' : 'deactivate' }} this nurse?')">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="bg-{{ $nurse->status == 'inactive' ? 'green' : 'red' }}-600 hover:bg-{{ $nurse->status == 'inactive' ? 'green' : 'red' }}-700 text-white font-medium rounded-lg text-sm px-3 py-2 focus:ring-2 focus:ring-{{ $nurse->status == 'inactive' ? 'green' : 'red' }}-300 transition duration-200">
                                            {{ $nurse->status == 'inactive' ? 'Reactivate' : 'Deactivate' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach                             
                    </tbody>
                </table>            
            </div>
        </div>
    </div>
</div>
        
        
    @endsection 