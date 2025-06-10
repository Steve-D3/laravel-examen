@extends('layouts.admin')

@section('content')
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-800">Trips Overview</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration (days)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confirmed</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pending</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cancelled</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($trips as $trip)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ ucfirst($trip->region) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $trip->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $trip->start_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $trip->duration_days }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                {{ $trip->confirmed_bookings_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600 font-medium">
                                {{ $trip->pending_bookings_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                                {{ $trip->cancelled_bookings_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                ${{ number_format($trip->total_revenue, 2) }}
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
    </div>
@endsection
