@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Create New Booking
            </h3>
        </div>
        
        <form action="{{ route('admin.bookings.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <!-- Trip Selection -->
                <div class="sm:col-span-2">
                    <label for="trip_id" class="block text-sm font-medium text-gray-700">Select Trip *</label>
                    <select id="trip_id" name="trip_id" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="" disabled {{ old('trip_id') ? '' : 'selected' }}>Select a trip</option>
                        @foreach($trips as $trip)
                            <option value="{{ $trip->id }}" {{ old('trip_id', request('trip_id')) == $trip->id ? 'selected' : '' }}
                                    data-price="{{ $trip->price_per_person }}"
                                    data-max-participants="{{ $trip->max_participants - $trip->confirmed_bookings_count }}">
                                {{ $trip->title }} ({{ $trip->start_date->format('M j, Y') }} - {{ $trip->end_date->format('M j, Y') }}) - ${{ number_format($trip->price_per_person, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('trip_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p id="trip_availability" class="mt-2 text-sm text-gray-600">
                        Select a trip to see availability
                    </p>
                </div>
                
                <!-- Customer Information -->
                <div class="sm:col-span-2 border-t border-gray-200 pt-4">
                    <h4 class="text-md font-medium text-gray-900">Customer Information</h4>
                </div>
                
                <div class="sm:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Booking Details -->
                <div class="sm:col-span-2 border-t border-gray-200 pt-4">
                    <h4 class="text-md font-medium text-gray-900">Booking Details</h4>
                </div>
                
                <div>
                    <label for="participants" class="block text-sm font-medium text-gray-700">Number of Participants *</label>
                    <input type="number" name="participants" id="participants" min="1" value="{{ old('participants', 1) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('participants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                    <select id="status" name="status" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', 'confirmed') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Special Requirements -->
                <div class="sm:col-span-2">
                    <label for="special_requirements" class="block text-sm font-medium text-gray-700">Special Requirements</label>
                    <textarea id="special_requirements" name="special_requirements" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('special_requirements') }}</textarea>
                    @error('special_requirements')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Price Summary -->
                <div class="sm:col-span-2 bg-gray-50 p-4 rounded-md">
                    <h4 class="text-md font-medium text-gray-900 mb-2">Price Summary</h4>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Price per person:</span>
                        <span id="price_per_person">$0.00</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 mt-1">
                        <span>Number of participants:</span>
                        <span id="participants_count">0</span>
                    </div>
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between font-medium">
                        <span>Total:</span>
                        <span id="total_price" class="text-lg">$0.00</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.bookings.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Create Booking
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tripSelect = document.getElementById('trip_id');
        const participantsInput = document.getElementById('participants');
        const pricePerPersonEl = document.getElementById('price_per_person');
        const participantsCountEl = document.getElementById('participants_count');
        const totalPriceEl = document.getElementById('total_price');
        const tripAvailabilityEl = document.getElementById('trip_availability');
        
        function updatePriceAndAvailability() {
            const selectedOption = tripSelect.options[tripSelect.selectedIndex];
            const pricePerPerson = parseFloat(selectedOption.dataset.price) || 0;
            const maxParticipants = parseInt(selectedOption.dataset.maxParticipants) || 0;
            const participants = parseInt(participantsInput.value) || 0;
            const totalPrice = pricePerPerson * participants;
            
            // Update price display
            pricePerPersonEl.textContent = '$' + pricePerPerson.toFixed(2);
            participantsCountEl.textContent = participants;
            totalPriceEl.textContent = '$' + totalPrice.toFixed(2);
            
            // Update availability message
            if (selectedOption.value) {
                if (maxParticipants > 0) {
                    tripAvailabilityEl.innerHTML = `
                        <span class="text-green-600">
                            <i class="fas fa-check-circle"></i> ${maxParticipants} spots available
                        </span>
                    `;
                    
                    // Update max participants
                    participantsInput.max = maxParticipants;
                    if (participants > maxParticipants) {
                        participantsInput.value = maxParticipants;
                        updatePriceAndAvailability();
                    }
                } else {
                    tripAvailabilityEl.innerHTML = `
                        <span class="text-red-600">
                            <i class="fas fa-times-circle"></i> No spots available
                        </span>
                    `;
                    participantsInput.disabled = true;
                }
            } else {
                tripAvailabilityEl.textContent = 'Select a trip to see availability';
                participantsInput.disabled = false;
            }
        }
        
        // Initial update
        updatePriceAndAvailability();
        
        // Add event listeners
        tripSelect.addEventListener('change', updatePriceAndAvailability);
        participantsInput.addEventListener('input', updatePriceAndAvailability);
    });
</script>
@endpush
