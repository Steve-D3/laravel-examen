<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_id' => 'required|exists:trips,id',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'participants' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'sometimes|in:pending,confirmed,cancelled',
            'special_requests' => 'nullable|string',
        ];
    }
}
