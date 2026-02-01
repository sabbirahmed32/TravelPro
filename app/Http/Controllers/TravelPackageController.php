<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TravelPackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = TravelPackage::active()
            ->when($request->destination, fn($q, $dest) => $q->where('destination', 'like', "%{$dest}%"))
            ->when($request->min_price, fn($q, $price) => $q->where('current_price', '>=', $price))
            ->when($request->max_price, fn($q, $price) => $q->where('current_price', '<=', $price))
            ->when($request->featured, fn($q) => $q->featured())
            ->latest()
            ->paginate(12);

        return response()->json($packages);
    }

    public function show(TravelPackage $travelPackage)
    {
        if (!$travelPackage->is_active) {
            return response()->json(['message' => 'Package not available'], 404);
        }

        return response()->json($travelPackage->load(['bookings' => function($query) {
            $query->where('status', '!=', 'cancelled')->latest()->limit(5);
        }]));
    }

    public function adminIndex(Request $request)
    {
        $packages = TravelPackage::with('bookings')
            ->when($request->search, fn($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($request->destination, fn($q, $dest) => $q->where('destination', 'like', "%{$dest}%"))
            ->latest()
            ->paginate(10);

        return response()->json($packages);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'destination' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'inclusions' => 'required|array|min:1',
            'exclusions' => 'required|array',
            'itinerary' => 'nullable|string',
            'max_travelers' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('travel-packages', 'public');
            $data['image'] = $path;
        }

        $data['is_active'] = $data['is_active'] ?? true;

        $package = TravelPackage::create($data);

        return response()->json([
            'message' => 'Travel package created successfully',
            'package' => $package
        ], 201);
    }

    public function update(Request $request, TravelPackage $travelPackage)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:1000',
            'destination' => 'sometimes|required|string|max:255',
            'duration_days' => 'sometimes|required|integer|min:1',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'inclusions' => 'sometimes|required|array|min:1',
            'exclusions' => 'sometimes|required|array',
            'itinerary' => 'nullable|string',
            'max_travelers' => 'sometimes|required|integer|min:1|max:100',
            'start_date' => 'sometimes|required|date|after:today',
            'end_date' => 'sometimes|required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($travelPackage->image) {
                Storage::disk('public')->delete($travelPackage->image);
            }
            $path = $request->file('image')->store('travel-packages', 'public');
            $data['image'] = $path;
        }

        $travelPackage->update($data);

        return response()->json([
            'message' => 'Travel package updated successfully',
            'package' => $travelPackage
        ]);
    }

    public function destroy(TravelPackage $travelPackage)
    {
        if ($travelPackage->bookings()->where('status', '!=', 'cancelled')->exists()) {
            return response()->json(['message' => 'Cannot delete package with active bookings'], 422);
        }

        if ($travelPackage->image) {
            Storage::disk('public')->delete($travelPackage->image);
        }

        $travelPackage->delete();

        return response()->json(['message' => 'Travel package deleted successfully']);
    }

    public function toggleStatus(Request $request, TravelPackage $travelPackage)
    {
        $travelPackage->update(['is_active' => !$travelPackage->is_active]);

        return response()->json([
            'message' => 'Package status updated successfully',
            'package' => $travelPackage
        ]);
    }

    public function frontendIndex()
    {
        // Fetch all active travel packages from database
        $packages = TravelPackage::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.tours.index', compact('packages'));
    }

    public function home()
    {
        // Fetch featured travel packages for homepage (limit to 6)
        $packages = TravelPackage::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('pages.home.index', compact('packages'));
    }
}