<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('vendor');
    }

    public function index()
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        $totalProducts = Product::where('vendor_id', $vendor->id)->count();
        $totalServices = Service::where('vendor_id', $vendor->id)->count();
        $totalEarnings = $vendor->getTotalEarnings();
        $averageRating = $vendor->getAverageRating();
        $pendingBookings = Booking::where('vendor_id', $vendor->id)
            ->where('status', 'pending')
            ->count();

        return view('vendor.dashboard', [
            'vendor' => $vendor,
            'totalProducts' => $totalProducts,
            'totalServices' => $totalServices,
            'totalEarnings' => $totalEarnings,
            'averageRating' => round($averageRating, 1),
            'pendingBookings' => $pendingBookings,
        ]);
    }
}
