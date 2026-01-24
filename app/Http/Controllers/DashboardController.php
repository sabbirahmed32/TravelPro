<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VisaApplication;
use App\Models\StudentApplication;
use App\Models\Booking;
use App\Models\Consultation;
use App\Models\TravelPackage;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->userDashboard($user);
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('role', 'user')->count(),
            'total_visa_applications' => VisaApplication::count(),
            'pending_visa_applications' => VisaApplication::where('status', 'pending')->count(),
            'total_student_applications' => StudentApplication::count(),
            'pending_student_applications' => StudentApplication::where('status', 'pending')->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_consultations' => Consultation::count(),
            'pending_consultations' => Consultation::where('status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'active_packages' => TravelPackage::where('is_active', true)->count(),
        ];

        $recentApplications = VisaApplication::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentBookings = Booking::with(['user', 'travelPackage'])
            ->latest()
            ->limit(5)
            ->get();

        $recentConsultations = Consultation::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $monthlyRevenue = Payment::where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json([
            'stats' => $stats,
            'recent_applications' => $recentApplications,
            'recent_bookings' => $recentBookings,
            'recent_consultations' => $recentConsultations,
            'monthly_revenue' => $monthlyRevenue,
        ]);
    }

    private function userDashboard($user)
    {
        $visaApplications = $user->visaApplications()
            ->with('documents')
            ->latest()
            ->limit(5)
            ->get();

        $studentApplications = $user->studentApplications()
            ->with('documents')
            ->latest()
            ->limit(5)
            ->get();

        $bookings = $user->bookings()
            ->with('travelPackage')
            ->latest()
            ->limit(5)
            ->get();

        $consultations = $user->consultations()
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'visa_applications_count' => $user->visaApplications()->count(),
            'pending_visa_applications' => $user->visaApplications()->where('status', 'pending')->count(),
            'student_applications_count' => $user->studentApplications()->count(),
            'pending_student_applications' => $user->studentApplications()->where('status', 'pending')->count(),
            'bookings_count' => $user->bookings()->count(),
            'active_bookings' => $user->bookings()->whereIn('status', ['confirmed', 'paid'])->count(),
            'consultations_count' => $user->consultations()->count(),
            'pending_consultations' => $user->consultations()->where('status', 'pending')->count(),
            'total_spent' => $user->payments()->where('status', 'completed')->sum('amount'),
        ];

        return response()->json([
            'stats' => $stats,
            'visa_applications' => $visaApplications,
            'student_applications' => $studentApplications,
            'bookings' => $bookings,
            'consultations' => $consultations,
        ]);
    }

    public function analytics(Request $request)
    {
        $this->authorizeAdmin($request->user());

        $period = $request->get('period', 'month');
        
        $visaApplicationsByType = VisaApplication::selectRaw('visa_type, COUNT(*) as count')
            ->groupBy('visa_type')
            ->get();

        $applicationsByStatus = [
            'visa' => VisaApplication::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'student' => StudentApplication::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
        ];

        $revenueBySource = Payment::with('payable')
            ->where('status', 'completed')
            ->selectRaw('payable_type, SUM(amount) as total')
            ->groupBy('payable_type')
            ->get();

        $popularDestinations = VisaApplication::selectRaw('destination_country, COUNT(*) as count')
            ->groupBy('destination_country')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $consultationsByType = Consultation::selectRaw('consultation_type, COUNT(*) as count')
            ->groupBy('consultation_type')
            ->get();

        return response()->json([
            'visa_applications_by_type' => $visaApplicationsByType,
            'applications_by_status' => $applicationsByStatus,
            'revenue_by_source' => $revenueBySource,
            'popular_destinations' => $popularDestinations,
            'consultations_by_type' => $consultationsByType,
        ]);
    }

    private function authorizeAdmin($user)
    {
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }
}