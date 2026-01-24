<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Http\Requests\StoreConsultationRequest;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            $consultations = Consultation::with('user')
                ->when($request->status, fn($q, $status) => $q->where('status', $status))
                ->when($request->consultation_type, fn($q, $type) => $q->where('consultation_type', $type))
                ->latest()
                ->paginate(10);
        } else {
            $consultations = $user->consultations()->latest()->paginate(10);
        }

        return response()->json($consultations);
    }

    public function store(StoreConsultationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'pending';
        $data['fee'] = $this->getConsultationFee($data['consultation_type']);

        $consultation = Consultation::create($data);

        return response()->json([
            'message' => 'Consultation request submitted successfully',
            'consultation' => $consultation
        ], 201);
    }

    public function show(Request $request, Consultation $consultation)
    {
        $this->authorizeView($request->user(), $consultation);
        
        return response()->json($consultation->load(['user', 'payments']));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $this->authorizeUpdate($request->user(), $consultation);

        $data = $request->validate([
            'status' => 'sometimes|required|in:pending,scheduled,completed,cancelled',
            'admin_notes' => 'nullable|string|max:1000',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        $consultation->update($data);

        return response()->json([
            'message' => 'Consultation updated successfully',
            'consultation' => $consultation
        ]);
    }

    public function schedule(Request $request, Consultation $consultation)
    {
        $this->authorizeUpdate($request->user(), $consultation);

        $data = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $consultation->update([
            'status' => 'scheduled',
            'scheduled_at' => $data['scheduled_at'],
            'admin_notes' => $data['admin_notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Consultation scheduled successfully',
            'consultation' => $consultation
        ]);
    }

    public function complete(Request $request, Consultation $consultation)
    {
        $this->authorizeUpdate($request->user(), $consultation);

        if ($consultation->status !== 'scheduled') {
            return response()->json(['message' => 'Can only complete scheduled consultations'], 422);
        }

        $data = $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $consultation->update([
            'status' => 'completed',
            'admin_notes' => $data['admin_notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Consultation marked as completed',
            'consultation' => $consultation
        ]);
    }

    public function cancel(Request $request, Consultation $consultation)
    {
        $this->authorizeCancel($request->user(), $consultation);

        if ($consultation->status === 'completed') {
            return response()->json(['message' => 'Cannot cancel completed consultation'], 422);
        }

        $consultation->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Consultation cancelled successfully',
            'consultation' => $consultation
        ]);
    }

    private function authorizeView($user, $consultation)
    {
        if (!$user->isAdmin() && $consultation->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeUpdate($user, $consultation)
    {
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeCancel($user, $consultation)
    {
        if (!$user->isAdmin() && $consultation->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }

    private function getConsultationFee($consultationType): float
    {
        $fees = [
            'visa' => 50,
            'student_admission' => 75,
            'travel_planning' => 100,
            'general' => 25,
        ];

        return $fees[$consultationType] ?? 50;
    }
}