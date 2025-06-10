@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Edit Booking #{{ $booking->id }}
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                {{ $booking->trip->title }} • {{ $booking->trip->start_date->format('M j, Y') }}
            </p>
        </div>
        
        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
                <!-- Trip Information (Readonly) -->
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Trip</label>
                    <div class="mt-1 bg-gray-50 p-3 rounded-md border border-gray-200">
                        <p class="font-medium">{{ $booking->trip->title }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $booking->trip->start_date->format('F j, Y') }} • 
                            {{ $booking->trip->duration_days }} days • 
                            ${{ number_format($booking->trip->price_per_person, 2) }} per person
                        </p>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-medium">Available spots:</span> 
                        {{ max(0, $booking->trip->max_participants - $booking->trip->confirmed_bookings_count + ($booking->status === 'confirmed' ? 1 : 0)) }} of {{ $booking->trip->max_participants }}
                    </p>
                </div>
                
                <!-- Customer Information -->
                <div class="sm:col-span-2 border-t border-gray-200 pt-4">
                    <h4 class="text-md font-medium text-gray-900">Customer Information</h4>
                </div>
                
                <div class="sm:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $booking->name) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-1">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $booking->email) }}" required
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sm:col-span-2">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $booking->phone) }}"
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
                    <input type="number" name="participants" id="participants" min="1" 
                           value="{{ old('participants', $booking->participants) }}" required
                           max="{{ $booking->trip->max_participants - $booking->trip->confirmed_bookings_count + ($booking->status === 'confirmed' ? $booking->participants : 0) }}"
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('participants')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                    <select id="status" name="status" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="pending" {{ old('status', $booking->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $booking->status) === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ old('status', $booking->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Special Requirements -->
                <div class="sm:col-span-2">
                    <label for="special_requirements" class="block text-sm font-medium text-gray-700">Special Requirements</label>
                    <textarea id="special_requirements" name="special_requirements" rows="3"
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('special_requirements', $booking->special_requirements) }}</textarea>
                    @error('special_requirements')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Price Summary -->
                <div class="sm:col-span-2 bg-gray-50 p-4 rounded-md">
                    <h4 class="text-md font-medium text-gray-900 mb-2">Price Summary</h4>
                    <div class="flex justify-between text-sm text-gray-600">
                        <span>Price per person:</span>
                        <span>${{ number_format($booking->trip->price_per_person, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 mt-1">
                        <span>Number of participants:</span>
                        <span id="participants_count">{{ $booking->participants }}</span>
                    </div>
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between font-medium">
                        <span>Total:</span>
                        <span id="total_price" class="text-lg">${{ number_format($booking->total_price, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-between">
                    <button type="button" onclick="if(confirm('Are you sure you want to delete this booking?')) { document.getElementById('delete-form').submit(); }" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash-alt mr-2"></i> Delete Booking
                    </button>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.bookings.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Booking
                        </button>
                    </div>
                </div>
            </div>
        </form>
        
        <!-- Delete Form -->
        <form id="delete-form" action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const participantsInput = document.getElementById('participants');
        const pricePerPerson = {{ $booking->trip->price_per_person }};
        const totalPriceEl = document.getElementById('total_price');
        const participantsCountEl = document.getElementById('participants_count');
        
        function updatePrice() {
            const participants = parseInt(participantsInput.value) || 0;
            const totalPrice = pricePerPerson * participants;
            
            // Update display
            participantsCountEl.textContent = participants;
            totalPriceEl.textContent = '$' + totalPrice.toFixed(2);
        }
        
        // Initial update
        updatePrice();
        
        // Add event listener
        participantsInput.addEventListener('input', updatePrice);
    });
</script>
@endpush
