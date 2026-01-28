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
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($request->all());

        // Handle AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!'
            ]);
        }

        // Handle regular form submissions
return redirect()
            ->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

public function deleteUser(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete your own account!'
                ], 422);
            }
            
            return redirect()
                ->route('admin.users')
                ->with('error', 'Cannot delete your own account!');
        }

        $user->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);
        }

        return redirect()
            ->route('admin.users')
            ->with('success', 'User deleted successfully!');
    }

    public function createUser(): View
    {
        return view('dashboard.admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully!',
                'user' => $user
            ]);
        }

return redirect()
            ->route('admin.users')
            ->with('success', 'User created successfully!');
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

    public function createBlog(): View
    {
        return view('dashboard.admin.blogs.create');
    }

    public function storeBlog(Request $request): RedirectResponse
    {
        // Debug: Log the request data
        Log::info('Blog creation attempt', [
            'request_data' => $request->all(),
            'user_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'auth_user' => Auth::user()
        ]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'sometimes|boolean',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date',
        ]);

        // Debug: Log validation result
        Log::info('Validation passed', ['validated_data' => $validated]);

        // Debug: Check if user is authenticated
        if (!Auth::check()) {
            Log::error('User not authenticated when creating blog');
            return redirect()->back()
                ->withInput()
                ->withErrors(['auth' => 'You must be logged in to create a blog post.']);
        }

        // Handle checkbox - if not checked, it won't be in request
        $validated['is_featured'] = $request->has('is_featured') ? true : false;
        
        // Handle tags - convert comma-separated string to array if needed
        if (!empty($validated['tags'])) {
            if (is_string($validated['tags'])) {
                $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
            }
        } else {
            $validated['tags'] = null;
        }

        $validated['author_id'] = Auth::id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        if ($validated['status'] === 'published' && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        Log::info('Final blog data before creation', ['blog_data' => $validated]);

        Blog::create($validated);

        return redirect()->route('admin.blogs')
            ->with('success', 'Blog post created successfully.');
    }

    public function showBlog(Blog $blog): View
    {
        return view('dashboard.admin.blogs.show', compact('blog'));
    }

    public function editBlog(Blog $blog): View
    {
        return view('dashboard.admin.blogs.edit', compact('blog'));
    }

    public function updateBlog(Request $request, Blog $blog): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
        }

        if ($validated['status'] === 'published' && !$validated['published_at'] && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs')
            ->with('success', 'Blog post updated successfully.');
    }

    public function publishBlog(Blog $blog): RedirectResponse
    {
        $blog->update([
            'status' => 'published',
            'published_at' => $blog->published_at ?: now()
        ]);

        return redirect()->route('admin.blogs')
            ->with('success', 'Blog post published successfully.');
    }

    public function archiveBlog(Blog $blog): RedirectResponse
    {
        $blog->update(['status' => 'archived']);

        return redirect()->route('admin.blogs')
            ->with('success', 'Blog post archived successfully.');
    }

    public function destroyBlog(Blog $blog): RedirectResponse
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs')
            ->with('success', 'Blog post deleted successfully.');
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

    public function createTravelPackage(): View
    {
        return view('dashboard.admin.travel-packages.create');
    }

    public function storeTravelPackage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('travel-packages', 'public');
        }

        TravelPackage::create($validated);

        return redirect()->route('admin.travel-packages')
            ->with('success', 'Travel package created successfully.');
    }

    public function showTravelPackage(TravelPackage $travelPackage): View
    {
        return view('dashboard.admin.travel-packages.show', compact('travelPackage'));
    }

    public function editTravelPackage(TravelPackage $travelPackage): View
    {
        return view('dashboard.admin.travel-packages.edit', compact('travelPackage'));
    }

    public function updateTravelPackage(Request $request, TravelPackage $travelPackage): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'duration' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive',
            'featured' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($travelPackage->image) {
                Storage::disk('public')->delete($travelPackage->image);
            }
            $validated['image'] = $request->file('image')->store('travel-packages', 'public');
        }

        $travelPackage->update($validated);

        return redirect()->route('admin.travel-packages')
            ->with('success', 'Travel package updated successfully.');
    }

    public function activateTravelPackage(TravelPackage $travelPackage): RedirectResponse
    {
        $travelPackage->update(['status' => 'active']);
        return redirect()->route('admin.travel-packages')
            ->with('success', 'Travel package activated successfully.');
    }

    public function deactivateTravelPackage(TravelPackage $travelPackage): RedirectResponse
    {
        $travelPackage->update(['status' => 'inactive']);
        return redirect()->route('admin.travel-packages')
            ->with('success', 'Travel package deactivated successfully.');
    }

    public function destroyTravelPackage(TravelPackage $travelPackage): RedirectResponse
    {
        if ($travelPackage->image) {
            Storage::disk('public')->delete($travelPackage->image);
        }

        $travelPackage->delete();

        return redirect()->route('admin.travel-packages')
            ->with('success', 'Travel package deleted successfully.');
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