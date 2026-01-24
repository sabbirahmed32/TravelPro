<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'consultation_type' => 'required|in:visa,student_admission,travel_planning,general',
            'message' => 'required|string|max:2000',
            'preferred_date_time' => 'required|date|after:now',
        ];
    }

    public function messages(): array
    {
        return [
            'preferred_date_time.after' => 'Preferred date time must be in the future.',
        ];
    }
}