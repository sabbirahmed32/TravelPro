<?php

namespace App\Http\Controllers;

use App\Models\StudentApplication;
use App\Http\Requests\StoreStudentApplicationRequest;
use Illuminate\Http\Request;

class StudentApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            $applications = StudentApplication::with('user')
                ->when($request->status, fn($q, $status) => $q->where('status', $status))
                ->latest()
                ->paginate(10);
        } else {
            $applications = $user->studentApplications()->latest()->paginate(10);
        }

        return response()->json($applications);
    }

    public function store(StoreStudentApplicationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending';
        $data['service_fee'] = $this->getServiceFee($data['education_level']);

        $application = StudentApplication::create($data);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('student-documents', 'public');
                $application->documents()->create([
                    'name' => $document->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $document->getClientMimeType(),
                    'file_size' => $document->getSize(),
                    'status' => 'pending',
                ]);
            }
        }

        return response()->json([
            'message' => 'Student application submitted successfully',
            'application' => $application->load('documents')
        ], 201);
    }

    public function show(Request $request, StudentApplication $studentApplication)
    {
        $this->authorizeView($request->user(), $studentApplication);
        
        return response()->json($studentApplication->load(['user', 'documents', 'payments']));
    }

    public function update(Request $request, StudentApplication $studentApplication)
    {
        $this->authorizeUpdate($request->user(), $studentApplication);

        $data = $request->validate([
            'status' => 'sometimes|required|in:pending,under_review,approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $studentApplication->update($data);

        return response()->json([
            'message' => 'Application updated successfully',
            'application' => $studentApplication
        ]);
    }

    public function updateStatus(Request $request, StudentApplication $studentApplication)
    {
        $this->authorizeUpdate($request->user(), $studentApplication);

        $data = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $studentApplication->update($data);

        return response()->json([
            'message' => 'Application status updated successfully',
            'application' => $studentApplication
        ]);
    }

    private function authorizeView($user, $application)
    {
        if (!$user->isAdmin() && $application->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeUpdate($user, $application)
    {
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    private function getServiceFee($educationLevel): float
    {
        $fees = [
            'high_school' => 300,
            'bachelors' => 500,
            'masters' => 700,
            'phd' => 900,
        ];

        return $fees[$educationLevel] ?? 500;
    }
}