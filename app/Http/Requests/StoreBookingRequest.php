<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'travel_package_id' => 'required|exists:travel_packages,id',
            'number_of_travelers' => 'required|integer|min:1|max:20',
            'traveler_details' => 'required|array|min:1',
            'traveler_details.*.first_name' => 'required|string|max:255',
            'traveler_details.*.last_name' => 'required|string|max:255',
            'traveler_details.*.date_of_birth' => 'required|date|before:today',
            'traveler_details.*.passport_number' => 'required|string|max:50',
            'traveler_details.*.nationality' => 'required|string|max:100',
            'special_requests' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'traveler_details.*.date_of_birth.before' => 'Date of birth must be before today.',
            'travel_package_id.exists' => 'Selected travel package is invalid.',
        ];
    }
}