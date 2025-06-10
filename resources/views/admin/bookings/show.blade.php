@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Booking #{{ $booking->id }}</h2>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="inline-flex items-center">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Booked on {{ $booking->created_at->format('F j, Y') }}
                        </span>
                    </p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    <a href="{{ route('admin.bookings.edit', $booking) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-edit mr-2"></i> Edit Booking
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
                    </a>
                </div>
            </div>
            
            <!-- Status Badge -->
            <div class="mt-4">
                @if($booking->status === 'confirmed')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i> Confirmed
                    </span>
                @elseif($booking->status === 'pending')
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-1"></i> Pending
                    </span>
                @else
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-1"></i> Cancelled
                    </span>
                @endif
            </div>
        </div>
        
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Trip Details -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Trip Details</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-900">{{ $booking->trip->title }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            <i class="fas fa-map-marker-alt mr-2"></i>{{ ucfirst($booking->trip->region) }}
                        </p>
                        
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Start Date</p>
                                <p class="text-sm font-medium">{{ $booking->trip->start_date->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Duration</p>
                                <p class="text-sm font-medium">{{ $booking->trip->duration_days }} days</p>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex justify-between text-sm">
                                <span>Price per person:</span>
                                <span class="font-medium">${{ number_format($booking->trip->price_per_person, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-1">
                                <span>Number of participants:</span>
                                <span class="font-medium">{{ $booking->participants }}</span>
                            </div>
                            <div class="mt-2 pt-2 border-t border-gray-200 font-medium flex justify-between">
                                <span>Total:</span>
                                <span class="text-lg">${{ number_format($booking->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Customer Information -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ $booking->name }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Contact information
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Email address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <a href="mailto:{{ $booking->email }}" class="text-blue-600 hover:text-blue-500">
                                            {{ $booking->email }}
                                        </a>
                                    </dd>
                                </div>
                                @if($booking->phone)
                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <a href="tel:{{ $booking->phone }}" class="text-blue-600 hover:text-blue-500">
                                                {{ $booking->phone }}
                                            </a>
                                        </dd>
                                    </div>
                                @endif
                                @if($booking->special_requirements)
                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">Special Requirements</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $booking->special_requirements }}
                                        </dd>
                                    </div>
                                @endif
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Booking Reference</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-mono">
                                        {{ $booking->reference_number }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Booking Timeline -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Timeline</h3>
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                            <i class="fas fa-calendar-plus text-white text-sm"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                Booking created on <span class="font-medium text-gray-900">{{ $booking->created_at->format('F j, Y \a\t g:i A') }}</span>
                                            </p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $booking->created_at->toIso8601String() }}">
                                                {{ $booking->created_at->diffForHumans() }}
                                            </time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        @if($booking->status_updated_at && $booking->status_updated_at->notEqualTo($booking->created_at))
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            @if($booking->status === 'confirmed')
                                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-check text-white text-sm"></i>
                                                </span>
                                            @elseif($booking->status === 'cancelled')
                                                <span class="h-8 w-8 rounded-full bg-red-500 flex items-center justify-center ring-8 ring-white">
                                                    <i class="fas fa-times text-white text-sm"></i>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    Booking marked as 
                                                    @if($booking->status === 'confirmed')
                                                        <span class="font-medium text-green-700">confirmed</span>
                                                    @elseif($booking->status === 'cancelled')
                                                        <span class="font-medium text-red-700">cancelled</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                <time datetime="{{ $booking->status_updated_at->toIso8601String() }}">
                                                    {{ $booking->status_updated_at->diffForHumans() }}
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                        
                        @if($booking->trip->start_date->isFuture())
                            <li>
                                <div class="relative">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-yellow-400 flex items-center justify-center ring-8 ring-white">
                                                <i class="far fa-clock text-white text-sm"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    Trip starts in 
                                                    <span class="font-medium text-gray-900">
                                                        {{ now()->diffInDays($booking->trip->start_date) }} days
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                {{ $booking->trip->start_date->format('F j, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-3">
                <div class="flex space-x-3">
                    @if($booking->status !== 'cancelled')
                        <form action="{{ route('admin.bookings.status', ['booking' => $booking, 'status' => 'cancelled']) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <i class="fas fa-times mr-2"></i> Cancel Booking
                            </button>
                        </form>
                    @endif
                    
                    @if($booking->status === 'pending')
                        <form action="{{ route('admin.bookings.status', ['booking' => $booking, 'status' => 'confirmed']) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-check mr-2"></i> Confirm Booking
                            </button>
                        </form>
                    @endif
                </div>
                
                <div class="text-sm text-gray-500">
                    <p>Last updated {{ $booking->updated_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
