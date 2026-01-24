<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            $bookings = Booking::with(['user', 'travelPackage'])
                ->when($request->status, fn($q, $status) => $q->where('status', $status))
                ->latest()
                ->paginate(10);
        } else {
            $bookings = $user->bookings()->with('travelPackage')
                ->latest()
                ->paginate(10);
        }

        return response()->json($bookings);
    }

    public function show(Request $request, Booking $booking)
    {
        $this->authorizeView($request->user(), $booking);
        
        return response()->json($booking->load(['user', 'travelPackage', 'payments']));
    }

    public function store(StoreBookingRequest $request)
    {
        $travelPackage = TravelPackage::findOrFail($request->travel_package_id);
        
        if ($travelPackage->is_sold_out) {
            return response()->json(['message' => 'This package is sold out'], 422);
        }

        if ($travelPackage->available_slots < $request->number_of_travelers) {
            return response()->json(['message' => 'Not enough available slots'], 422);
        }

        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['booking_reference'] = 'BK' . strtoupper(uniqid());
        $data['total_price'] = $travelPackage->current_price * $request->number_of_travelers;
        $data['booking_date'] = now();
        $data['payment_due_date'] = now()->addDays(3);
        $data['status'] = 'pending';

        $booking = Booking::create($data);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking->load('travelPackage')
        ], 201);
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorizeUpdate($request->user(), $booking);

        $data = $request->validate([
            'status' => 'sometimes|required|in:pending,confirmed,paid,cancelled,completed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $booking->update($data);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ]);
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorizeCancel($request->user(), $booking);

        if ($booking->status === 'completed') {
            return response()->json(['message' => 'Cannot cancel completed booking'], 422);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'booking' => $booking
        ]);
    }

    public function confirm(Request $request, Booking $booking)
    {
        $this->authorizeUpdate($request->user(), $booking);

        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Can only confirm pending bookings'], 422);
        }

        $booking->update(['status' => 'confirmed']);

        return response()->json([
            'message' => 'Booking confirmed successfully',
            'booking' => $booking
        ]);
    }

    private function authorizeView($user, $booking)
    {
        if (!$user->isAdmin() && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeUpdate($user, $booking)
    {
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeCancel($user, $booking)
    {
        if (!$user->isAdmin() && $booking->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }
}