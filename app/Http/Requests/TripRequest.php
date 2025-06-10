<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'region' => 'required|string|max:100',
            'start_date' => 'required|date|after:today',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'is_available' => 'sometimes|boolean',
        ];
    }
}
