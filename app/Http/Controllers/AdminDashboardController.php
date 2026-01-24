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
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_visa_applications' => VisaApplication::count(),
            'total_student_applications' => StudentApplication::count(),
            'total_bookings' => Booking::count(),
            'total_consultations' => Consultation::count(),
            'pending_visa_applications' => VisaApplication::where('status', 'pending')->count(),
            'pending_student_applications' => StudentApplication::where('status', 'pending')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'pending_consultations' => Consultation::where('status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'this_month_revenue' => Payment::where('status', 'completed')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('amount'),
        ];

        $recentVisaApplications = VisaApplication::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentStudentApplications = StudentApplication::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentBookings = Booking::with(['user', 'travelPackage'])
            ->latest()
            ->take(5)
            ->get();

        $recentConsultations = Consultation::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin.index', compact(
            'stats',
            'recentVisaApplications',
            'recentStudentApplications',
            'recentBookings',
            'recentConsultations'
        ));
    }

    public function manageUsers(): View
    {
        $users = User::latest()
            ->when(request('search'), function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when(request('role'), function ($query, $role) {
                $query->where('role', $role);
            })
            ->paginate(10);

        return view('dashboard.admin.users.index', compact('users'));
    }

    public function editUser(User $user): View
    {
        return view('dashboard.admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully!'
        ]);
    }

    public function deleteUser(User $user): JsonResponse
    {
        if ($user->id === request()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete your own account!'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully!'
        ]);
    }

    public function manageVisaApplications(): View
    {
        $applications = VisaApplication::with('user')
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.visa-applications.index', compact('applications'));
    }

    public function showVisaApplication(VisaApplication $visaApplication): View
    {
        $visaApplication->load(['user', 'documents', 'payments']);
        return view('dashboard.admin.visa-applications.show', compact('visaApplication'));
    }

    public function manageStudentApplications(): View
    {
        $applications = StudentApplication::with('user')
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.student-applications.index', compact('applications'));
    }

    public function showStudentApplication(StudentApplication $studentApplication): View
    {
        $studentApplication->load(['user', 'documents', 'payments']);
        return view('dashboard.admin.student-applications.show', compact('studentApplication'));
    }

    public function manageBookings(): View
    {
        $bookings = Booking::with(['user', 'travelPackage'])
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.bookings.index', compact('bookings'));
    }

    public function showBooking(Booking $booking): View
    {
        $booking->load(['user', 'travelPackage', 'payments']);
        return view('dashboard.admin.bookings.show', compact('booking'));
    }

    public function manageConsultations(): View
    {
        $consultations = Consultation::with('user')
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('consultation_type'), function ($query, $type) {
                $query->where('consultation_type', $type);
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.consultations.index', compact('consultations'));
    }

    public function showConsultation(Consultation $consultation): View
    {
        $consultation->load(['user', 'payments']);
        return view('dashboard.admin.consultations.show', compact('consultation'));
    }

    public function manageBlogs(): View
    {
        $blogs = Blog::with('author')
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.blogs.index', compact('blogs'));
    }

    public function manageFAQs(): View
    {
        $faqs = FAQ::latest()->paginate(10);
        return view('dashboard.admin.faqs.index', compact('faqs'));
    }

    public function manageTravelPackages(): View
    {
        $packages = TravelPackage::latest()->paginate(10);
        return view('dashboard.admin.travel-packages.index', compact('packages'));
    }

    public function analytics(): View
    {
        return view('dashboard.admin.analytics');
    }

    public function getAnalytics(): JsonResponse
    {
        // Application trends
        $visaTrends = VisaApplication::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $studentTrends = StudentApplication::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $bookingTrends = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue breakdown
        $revenueByType = DB::table('payments')
            ->join('visa_applications', 'payments.payable_type', '=', 'App\\Models\\VisaApplication')
            ->where('payments.status', 'completed')
            ->selectRaw('SUM(payments.amount) as total, "visa" as type')
            ->unionAll(
                DB::table('payments')
                    ->join('student_applications', 'payments.payable_type', '=', 'App\\Models\\StudentApplication')
                    ->where('payments.status', 'completed')
                    ->selectRaw('SUM(payments.amount) as total, "student" as type')
            )
            ->unionAll(
                DB::table('payments')
                    ->join('bookings', 'payments.payable_type', '=', 'App\\Models\\Booking')
                    ->where('payments.status', 'completed')
                    ->selectRaw('SUM(payments.amount) as total, "booking" as type')
            )
            ->get();

        // Status distributions
        $visaStatusDistribution = VisaApplication::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $studentStatusDistribution = StudentApplication::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $bookingStatusDistribution = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Monthly revenue
        $monthlyRevenue = Payment::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(amount) as total')
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return response()->json([
            'visa_trends' => $visaTrends,
            'student_trends' => $studentTrends,
            'booking_trends' => $bookingTrends,
            'revenue_by_type' => $revenueByType,
            'visa_status_distribution' => $visaStatusDistribution,
            'student_status_distribution' => $studentStatusDistribution,
            'booking_status_distribution' => $bookingStatusDistribution,
            'monthly_revenue' => $monthlyRevenue,
        ]);
    }

    public function quickStats(): JsonResponse
    {
        $stats = [
            'today_visa_applications' => VisaApplication::whereDate('created_at', Carbon::today())->count(),
            'today_student_applications' => StudentApplication::whereDate('created_at', Carbon::today())->count(),
            'today_bookings' => Booking::whereDate('created_at', Carbon::today())->count(),
            'today_consultations' => Consultation::whereDate('created_at', Carbon::today())->count(),
            'today_revenue' => Payment::where('status', 'completed')
                ->whereDate('created_at', Carbon::today())
                ->sum('amount'),
            'pending_approvals' => VisaApplication::where('status', 'pending')->count() +
                                 StudentApplication::where('status', 'pending')->count(),
        ];

        return response()->json($stats);
    }
}