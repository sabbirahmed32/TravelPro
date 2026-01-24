<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisaApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'passport_number' => 'required|string|max:50',
            'passport_expiry' => 'required|date|after:today',
            'nationality' => 'required|string|max:100',
            'destination_country' => 'required|string|max:100',
            'visa_type' => 'required|in:tourist,business,student,work',
            'intended_travel_date' => 'required|date|after:today',
            'return_date' => 'required|date|after:intended_travel_date',
            'purpose_of_travel' => 'required|string|max:1000',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'date_of_birth.before' => 'Date of birth must be before today.',
            'passport_expiry.after' => 'Passport must be valid after today.',
            'intended_travel_date.after' => 'Travel date must be in the future.',
            'return_date.after' => 'Return date must be after travel date.',
            'documents.*.mimes' => 'Documents must be PDF, JPG, or PNG files.',
            'documents.*.max' => 'Documents must not exceed 5MB.',
        ];
    }
}