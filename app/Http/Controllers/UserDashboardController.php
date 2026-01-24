<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VisaApplication;
use App\Models\StudentApplication;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\Blog;
use App\Models\TravelPackage;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = request()->user();
        
        $stats = [
            'pending_visa_applications' => $user->visaApplications()->where('status', 'pending')->count(),
            'pending_student_applications' => $user->studentApplications()->where('status', 'pending')->count(),
            'pending_bookings' => $user->bookings()->where('status', 'pending')->count(),
            'pending_consultations' => $user->consultations()->where('status', 'pending')->count(),
        ];

        $recentVisaApplications = $user->visaApplications()
            ->with('documents')
            ->latest()
            ->take(5)
            ->get();

        $recentStudentApplications = $user->studentApplications()
            ->with('documents')
            ->latest()
            ->take(5)
            ->get();

        $recentBookings = $user->bookings()
            ->with('travelPackage')
            ->latest()
            ->take(5)
            ->get();

        $recentConsultations = $user->consultations()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.user.index', compact(
            'stats',
            'recentVisaApplications',
            'recentStudentApplications',
            'recentBookings',
            'recentConsultations'
        ));
    }

    public function profile(): View
    {
        $user = request()->user();
        return view('dashboard.user.profile', compact('user'));
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . request()->user()->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = request()->user();
        $user->update($request->only(['name', 'email', 'phone', 'address']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = request()->user();
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = request()->user();
        
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Avatar updated successfully!',
            'avatar_url' => $user->avatar
        ]);
    }

    public function visaApplications(): View
    {
        $applications = request()->user()
            ->visaApplications()
            ->with('documents')
            ->latest()
            ->paginate(10);

        return view('dashboard.user.visa-applications', compact('applications'));
    }

    public function studentApplications(): View
    {
        $applications = request()->user()
            ->studentApplications()
            ->with('documents')
            ->latest()
            ->paginate(10);

        return view('dashboard.user.student-applications', compact('applications'));
    }

    public function bookings(): View
    {
        $bookings = request()->user()
            ->bookings()
            ->with('travelPackage')
            ->latest()
            ->paginate(10);

        return view('dashboard.user.bookings', compact('bookings'));
    }

    public function consultations(): View
    {
        $consultations = request()->user()
            ->consultations()
            ->latest()
            ->paginate(10);

        return view('dashboard.user.consultations', compact('consultations'));
    }

    public function payments(): View
    {
        $payments = request()->user()
            ->payments()
            ->with(['payable'])
            ->latest()
            ->paginate(10);

        return view('dashboard.user.payments', compact('payments'));
    }

    public function analytics(): JsonResponse
    {
        $user = request()->user();
        
        $visaStats = $user->visaApplications()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $studentStats = $user->studentApplications()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $bookingStats = $user->bookings()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $monthlySpending = $user->payments()
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        return response()->json([
            'visa_applications' => $visaStats,
            'student_applications' => $studentStats,
            'bookings' => $bookingStats,
            'monthly_spending' => $monthlySpending,
        ]);
    }
}