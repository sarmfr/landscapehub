<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('vendor');
    }

    /**
     * Show vendor profile creation form
     */
    public function create()
    {
        $user = Auth::user();

        // If vendor already has a profile, redirect to edit
        if ($user->vendor) {
            return redirect()->route('vendor.profile.edit');
        }

        return view('vendor.profile.create');
    }

    /**
     * Store vendor profile
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if vendor already exists
        if ($user->vendor) {
            return redirect()->route('vendor.profile.edit');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255|unique:vendors',
            'description' => 'required|string|min:20|max:1000',
            'location' => 'required|string|max:255',
            'business_phone' => 'required|string|max:20',
            'business_address' => 'required|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('vendors', 'public');
            $validated['profile_image'] = $path;
        }

        $validated['user_id'] = $user->id;
        $validated['approval_status'] = 'pending';
        $validated['commission_rate'] = 15; // Default commission rate

        Vendor::create($validated);

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Vendor profile created successfully! Your profile is pending admin approval.');
    }

    /**
     * Show vendor profile edit form
     */
    public function edit()
    {
        $user = Auth::user();
        $vendor = $user->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        return view('vendor.profile.edit', ['vendor' => $vendor]);
    }

    /**
     * Update vendor profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $vendor = $user->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255|unique:vendors,business_name,' . $vendor->id,
            'description' => 'required|string|min:20|max:1000',
            'location' => 'required|string|max:255',
            'business_phone' => 'required|string|max:20',
            'business_address' => 'required|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image
            if ($vendor->profile_image) {
                Storage::disk('public')->delete($vendor->profile_image);
            }
            $path = $request->file('profile_image')->store('vendors', 'public');
            $validated['profile_image'] = $path;
        }

        $vendor->update($validated);

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Vendor profile updated successfully!');
    }

    /**
     * Show vendor profile
     */
    public function show()
    {
        $user = Auth::user();
        $vendor = $user->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        return view('vendor.profile.show', ['vendor' => $vendor]);
    }
}
