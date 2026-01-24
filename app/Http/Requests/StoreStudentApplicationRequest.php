<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentApplicationRequest extends FormRequest
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
            'nationality' => 'required|string|max:100',
            'passport_number' => 'required|string|max:50',
            'education_level' => 'required|in:high_school,bachelors,masters,phd',
            'desired_course' => 'required|string|max:255',
            'desired_university' => 'required|string|max:255',
            'target_country' => 'required|string|max:100',
            'gpa' => 'required|numeric|min:0|max:4.0',
            'english_test_type' => 'nullable|in:IELTS,TOEFL,PTE',
            'english_score' => 'nullable|numeric|min:0|max:9.0',
            'personal_statement' => 'required|string|max:2000',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'gpa.max' => 'GPA cannot exceed 4.0.',
            'english_score.max' => 'English score cannot exceed 9.0.',
            'documents.*.mimes' => 'Documents must be PDF, JPG, or PNG files.',
            'documents.*.max' => 'Documents must not exceed 5MB.',
        ];
    }
}