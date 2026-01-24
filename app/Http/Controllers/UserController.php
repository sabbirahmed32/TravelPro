<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeAdmin($request->user());

        $users = User::when($request->search, fn($q, $search) => 
                $q->where('name', 'like', "%{$search}%")
                 ->orWhere('email', 'like', "%{$search}%"))
            ->when($request->role, fn($q, $role) => $q->where('role', $role))
            ->when($request->status, fn($q, $status) => 
                $status === 'active' ? $q : $q->whereNull('email_verified_at'))
            ->latest()
            ->paginate(15);

        return response()->json($users);
    }

    public function show(Request $request, User $user)
    {
        $this->authorizeAdmin($request->user());

        $user->load(['visaApplications', 'studentApplications', 'bookings', 'consultations', 'payments']);

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request->user());

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeUpdate($request->user(), $user);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'sometimes|required|in:admin,user',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorizeAdmin($request->user());

        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'Cannot delete your own account'], 422);
        }

        if ($user->visaApplications()->exists() || 
            $user->studentApplications()->exists() || 
            $user->bookings()->exists()) {
            return response()->json(['message' => 'Cannot delete user with associated records'], 422);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function toggleStatus(Request $request, User $user)
    {
        $this->authorizeAdmin($request->user());

        if ($user->email_verified_at) {
            $user->update(['email_verified_at' => null]);
        } else {
            $user->update(['email_verified_at' => now()]);
        }

        return response()->json([
            'message' => 'User status updated successfully',
            'user' => $user
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 422);
        }

        $user->update([
            'password' => Hash::make($data['password'])
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }

    private function authorizeAdmin($user)
    {
        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    private function authorizeUpdate($currentUser, $targetUser)
    {
        if (!$currentUser->isAdmin() && $currentUser->id !== $targetUser->id) {
            abort(403, 'Unauthorized');
        }
    }
}