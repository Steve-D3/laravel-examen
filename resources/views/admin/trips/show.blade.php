@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Trip Header -->
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $trip->title }}</h2>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="inline-flex items-center">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ ucfirst($trip->region) }} • 
                            {{ $trip->start_date->format('F j, Y') }} • 
                            {{ $trip->duration_days }} days
                        </span>
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('admin.trips.edit', $trip) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-edit mr-2"></i> Edit Trip
                    </a>
                    <a href="{{ route('admin.bookings.create', ['trip_id' => $trip->id]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-plus mr-2"></i> New Booking
                    </a>
                </div>
            </div>
            
            <!-- Stats -->
            <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-4">
                <!-- Total Revenue -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-dollar-sign text-white"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            ${{ number_format($trip->total_revenue, 2) }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Confirmed Bookings -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Confirmed</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ $trip->confirmed_bookings_count ?? 0 }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Pending Bookings -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <i class="far fa-clock text-white"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ $trip->pending_bookings_count ?? 0 }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Available Spots -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Available Spots</dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ max(0, $trip->max_participants - ($trip->confirmed_bookings_count ?? 0)) }} / {{ $trip->max_participants }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trip Details -->
        <div class="px-6 py-5 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Trip Details</h3>
            <div class="mt-4 text-sm text-gray-700 space-y-2">
                <p><span class="font-medium">Status:</span> 
                    @if($trip->is_available)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Available
                        </span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Unavailable
                        </span>
                    @endif
                </p>
                <p><span class="font-medium">Price per person:</span> ${{ number_format($trip->price_per_person, 2) }}</p>
                <p><span class="font-medium">Start Date:</span> {{ $trip->start_date ? $trip->start_date->format('F j, Y') : 'Not set' }}</p>
                <p><span class="font-medium">End Date:</span> {{ $trip->end_date ? $trip->end_date->format('F j, Y') : 'Not set' }}</p>
                <p><span class="font-medium">Duration:</span> {{ $trip->duration_days ? $trip->duration_days . ' days' : 'Not set' }}</p>
                <p><span class="font-medium">Max Participants:</span> {{ $trip->max_participants ?? 'Not set' }}</p>
                @if($trip->description)
                    <div class="mt-4">
                        <p class="font-medium">Description:</p>
                        <p class="mt-1 text-gray-600">{{ $trip->description }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Bookings Section -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Bookings</h3>
        </div>
        
        @if($bookings->isEmpty())
            <div class="px-6 py-12 text-center">
                <i class="far fa-calendar-plus text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500">No bookings found for this trip.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.bookings.create', ['trip_id' => $trip->id]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i> Create Booking
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booked On</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $booking->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->participants }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($booking->total_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->status === 'confirmed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Confirmed
                                        </span>
                                    @elseif($booking->status === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-indigo-600 hover:text-indigo-900">
                                        <i class="far fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
