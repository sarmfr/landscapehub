<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Product;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalVendors = Vendor::where('approval_status', 'approved')->count();
        $totalRevenue = Order::where('payment_status', 'completed')->sum('commission_amount');
        $pendingApprovals = Vendor::where('approval_status', 'pending')->count();

        // Generate labels for the last 12 months
        $months = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $months[] = $month->format('M Y');
            $key = $month->format('m-Y');
            $chartData[$key] = 0;
        }

        $revenueQuery = Order::where('payment_status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%m-%Y") as month, SUM(commission_amount) as total')
            ->groupByRaw('DATE_FORMAT(created_at, "%m-%Y")')
            ->get();

        foreach ($revenueQuery as $data) {
            if (isset($chartData[$data->month])) {
                $chartData[$data->month] = (float)$data->total;
            }
        }

        $monthlyRevenue = [
            'labels' => $months,
            'data' => array_values($chartData)
        ];

        $topVendors = Vendor::where('approval_status', 'approved')
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(5)
            ->get();

        $bestSellingProducts = Product::withCount('orderItems as sold_count')
            ->orderBy('sold_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalVendors' => $totalVendors,
            'totalRevenue' => $totalRevenue,
            'pendingApprovals' => $pendingApprovals,
            'monthlyRevenue' => $monthlyRevenue,
            'topVendors' => $topVendors,
            'bestSellingProducts' => $bestSellingProducts,
        ]);
    }
}
