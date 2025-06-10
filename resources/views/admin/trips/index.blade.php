@extends('layouts.admin')

@section('content')
    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">Trips Overview</h2>
        </div>
        
        <!-- Desktop Table (hidden on mobile) -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confirmed</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pending</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cancelled</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($trips as $trip)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ ucfirst($trip->region) }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 text-sm text-gray-900 font-medium">
                                {{ $trip->title }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $trip->start_date->format('M d, Y') }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $trip->duration_days }} days
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                {{ $trip->confirmed_bookings_count ?? 0 }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-medium">
                                {{ $trip->pending_bookings_count ?? 0 }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                                {{ $trip->cancelled_bookings_count ?? 0 }}
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ${{ number_format($trip->total_revenue, 2) }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2 justify-end">
                                    <a href="{{ route('admin.trips.show', $trip) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.trips.edit', $trip) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.bookings.index', ['trip_id' => $trip->id]) }}" class="text-purple-600 hover:text-purple-900" title="View Bookings">
                                        <i class="fas fa-calendar-check"></i>
                                    </a>
                                    <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No trips found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Cards (visible on mobile) -->
        <div class="md:hidden">
            @forelse ($trips as $trip)
                <div class="border-b border-gray-200 p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">{{ $trip->title }}</h3>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-map-marker-alt mr-1"></i> {{ ucfirst($trip->region) }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="far fa-calendar-alt mr-1"></i> {{ $trip->start_date->format('M d, Y') }} • {{ $trip->duration_days }} days
                            </p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ${{ number_format($trip->total_revenue, 2) }}
                        </span>
                    </div>
                    <div class="mt-3 flex space-x-3">
                        <a href="{{ route('admin.trips.show', $trip) }}" class="text-blue-600 hover:text-blue-900" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.trips.edit', $trip) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.bookings.index', ['trip_id' => $trip->id]) }}" class="text-purple-600 hover:text-purple-900" title="View Bookings">
                            <i class="fas fa-calendar-check"></i>
                        </a>
                        <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this trip? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    <div class="mt-3 flex justify-between text-xs">
                        <span class="inline-flex items-center text-green-600">
                            <i class="fas fa-check-circle mr-1"></i> {{ $trip->confirmed_bookings_count ?? 0 }}
                        </span>
                        <span class="inline-flex items-center text-yellow-600">
                            <i class="far fa-clock mr-1"></i> {{ $trip->pending_bookings_count ?? 0 }}
                        </span>
                        <span class="inline-flex items-center text-red-600">
                            <i class="fas fa-times-circle mr-1"></i> {{ $trip->cancelled_bookings_count ?? 0 }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-sm text-gray-500">
                    No trips found.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if(method_exists($trips, 'hasPages') && $trips->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-lg shadow">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($trips->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                        Previous
                    </span>
                @else
                    <a href="{{ $trips->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                @endif
                
                @if($trips->hasMorePages())
                    <a href="{{ $trips->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                @else
                    <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white cursor-not-allowed">
                        Next
                    </span>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        @if(method_exists($trips, 'firstItem'))
                            Showing
                            <span class="font-medium">{{ $trips->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $trips->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $trips->total() }}</span>
                            results
                        @else
                            Showing {{ $trips->count() }} results
                        @endif
                    </p>
                </div>
                @if(method_exists($trips, 'links'))
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            {{ $trips->links() }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
