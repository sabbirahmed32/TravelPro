<?php

namespace App\Http\Controllers;

use App\Models\VisaApplication;
use App\Http\Requests\StoreVisaApplicationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VisaApplicationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            $applications = VisaApplication::with('user')
                ->when($request->status, fn($q, $status) => $q->where('status', $status))
                ->latest()
                ->paginate(10);
        } else {
            $applications = $user->visaApplications()->latest()->paginate(10);
        }

        return response()->json($applications);
    }

    public function store(StoreVisaApplicationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending';
        $data['fee'] = $this->getVisaFee($data['visa_type'], $data['destination_country']);

        $application = VisaApplication::create($data);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('visa-documents', 'public');
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
            'message' => 'Visa application submitted successfully',
            'application' => $application->load('documents')
        ], 201);
    }

    public function show(Request $request, VisaApplication $visaApplication)
    {
        $this->authorizeView($request->user(), $visaApplication);
        
        return response()->json($visaApplication->load(['user', 'documents', 'payments']));
    }

    public function update(Request $request, VisaApplication $visaApplication)
    {
        $this->authorizeUpdate($request->user(), $visaApplication);

        $data = $request->validate([
            'status' => 'sometimes|required|in:pending,under_review,approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $visaApplication->update($data);

        return response()->json([
            'message' => 'Application updated successfully',
            'application' => $visaApplication
        ]);
    }

    public function updateStatus(Request $request, VisaApplication $visaApplication)
    {
        $this->authorizeUpdate($request->user(), $visaApplication);

        $data = $request->validate([
            'status' => 'required|in:pending,under_review,approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $visaApplication->update($data);

        return response()->json([
            'message' => 'Application status updated successfully',
            'application' => $visaApplication
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

    private function getVisaFee($visaType, $destinationCountry): float
    {
        $fees = [
            'tourist' => 150,
            'business' => 250,
            'student' => 200,
            'work' => 300,
        ];

        return $fees[$visaType] ?? 150;
    }
}