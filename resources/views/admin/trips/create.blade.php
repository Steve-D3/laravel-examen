@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Create New Trip
            </h3>
        </div>
        
        <form action="{{ route('admin.trips.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <!-- Title -->
                <div class="sm:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Trip Title *</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Region -->
                <div>
                    <label for="region" class="block text-sm font-medium text-gray-700">Region *</label>
                    <select id="region" name="region" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="" disabled selected>Select a region</option>
                        @foreach(['alberta', 'british columbia', 'manitoba', 'new brunswick', 'newfoundland and labrador', 'northwest territories', 'nova scotia', 'nunavut', 'ontario', 'prince edward island', 'quebec', 'saskatchewan', 'yukon'] as $region)
                            <option value="{{ $region }}" {{ old('region') == $region ? 'selected' : '' }}>{{ ucfirst($region) }}</option>
                        @endforeach
                    </select>
                    @error('region')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date *</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Duration -->
                <div>
                    <label for="duration_days" class="block text-sm font-medium text-gray-700">Duration (days) *</label>
                    <input type="number" name="duration_days" id="duration_days" min="1" value="{{ old('duration_days', 7) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('duration_days')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Max Participants -->
                <div>
                    <label for="max_participants" class="block text-sm font-medium text-gray-700">Max Participants *</label>
                    <input type="number" name="max_participants" id="max_participants" min="1" value="{{ old('max_participants', 15) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('max_participants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Price per Person -->
                <div>
                    <label for="price_per_person" class="block text-sm font-medium text-gray-700">Price per Person (USD) *</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="price_per_person" id="price_per_person" min="0" step="0.01" value="{{ old('price_per_person', '1999.99') }}" required
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                    </div>
                    @error('price_per_person')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Is Available -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', true) ? 'checked' : '' }}
                               class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="is_available" class="font-medium text-gray-700">Available for booking</label>
                        <p class="text-gray-500">Uncheck to hide this trip from the booking system</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.trips.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Trip
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set minimum date to today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('start_date').min = today;
    });
</script>
@endpush
