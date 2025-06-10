@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Bookings</h2>
                <div class="mt-4 sm:mt-0">
                    <a href="{{ route('admin.bookings.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-plus mr-2"></i> New Booking
                    </a>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="mt-6">
                <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                               placeholder="Search by name, email, or booking #">
                    </div>
                    <div class="w-full sm:w-48">
                        <select id="status" name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-48">
                        <select id="trip_id" name="trip_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">All Trips</option>
                            @foreach($trips as $trip)
                                <option value="{{ $trip->id }}" {{ request('trip_id') == $trip->id ? 'selected' : '' }}>
                                    {{ $trip->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <i class="fas fa-sync-alt mr-2"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        @if($bookings->isEmpty())
            <div class="px-6 py-12 text-center">
                <i class="far fa-calendar-plus text-4xl text-gray-400 mb-3"></i>
                <p class="text-gray-500">No bookings found.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.bookings.create') }}" 
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trip</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Participants</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->trip->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->trip->region }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->trip->start_date->format('M j, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->trip->duration_days }} days</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->participants }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this booking? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bookings->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
