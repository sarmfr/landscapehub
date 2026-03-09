<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorStatusChanged;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display list of all vendors
     */
    public function index(Request $request)
    {
        $query = Vendor::with('user');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('approval_status', $request->status);
        }

        // Search by business name or owner name
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $vendors = $query->paginate(15);

        return view('admin.vendors.index', ['vendors' => $vendors]);
    }

    /**
     * Display vendor details
     */
    public function show(Vendor $vendor)
    {
        return view('admin.vendors.show', ['vendor' => $vendor]);
    }

    /**
     * Show approval form
     */
    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.approve', ['vendor' => $vendor]);
    }

    /**
     * Approve vendor
     */
    public function approve(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'commission_rate' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $vendor->update([
            'approval_status' => 'approved',
            'commission_rate' => $validated['commission_rate'],
        ]);

        Mail::to($vendor->user->email)->send(new VendorStatusChanged($vendor, 'approved'));

        return redirect()->route('admin.vendors.show', $vendor)
            ->with('success', 'Vendor approved successfully!');
    }

    /**
     * Reject vendor
     */
    public function reject(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $vendor->update([
            'approval_status' => 'rejected',
        ]);

        Mail::to($vendor->user->email)->send(new VendorStatusChanged($vendor, 'rejected', $validated['rejection_reason']));

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor rejected successfully!');
    }

    /**
     * Suspend vendor
     */
    public function suspend(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'suspension_reason' => 'required|string|max:500',
        ]);

        $vendor->update([
            'approval_status' => 'suspended',
        ]);

        Mail::to($vendor->user->email)->send(new VendorStatusChanged($vendor, 'suspended', $validated['suspension_reason']));

        return redirect()->route('admin.vendors.show', $vendor)
            ->with('success', 'Vendor suspended successfully!');
    }

    /**
     * Reactivate vendor
     */
    public function reactivate(Vendor $vendor)
    {
        if ($vendor->approval_status === 'suspended') {
            $vendor->update([
                'approval_status' => 'approved',
            ]);

            return redirect()->route('admin.vendors.show', $vendor)
                ->with('success', 'Vendor reactivated successfully!');
        }

        return redirect()->route('admin.vendors.show', $vendor)
            ->with('error', 'Only suspended vendors can be reactivated.');
    }

    /**
     * Delete vendor
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor deleted successfully!');
    }
}
