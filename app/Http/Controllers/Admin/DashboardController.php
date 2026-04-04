<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Services\EnvironmentSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

class DashboardController extends Controller
{
    public function __construct(private readonly EnvironmentSettingsService $environmentSettings)
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

        $paymentSettings = [
            'provider' => (string) config('payment.default', 'mock'),
            'consumer_key' => (string) config('payment.providers.mpesa.consumer_key', ''),
            'consumer_secret' => (string) config('payment.providers.mpesa.consumer_secret', ''),
            'passkey' => (string) config('payment.providers.mpesa.passkey', ''),
            'short_code' => (string) config('payment.providers.mpesa.short_code', ''),
            'party_b' => (string) config('payment.providers.mpesa.party_b', ''),
            'business_type' => (string) config('payment.providers.mpesa.business_type', 'paybill'),
            'callback_url' => (string) config('payment.providers.mpesa.callback_url', ''),
            'environment' => (string) config('payment.providers.mpesa.env', 'sandbox'),
        ];

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalVendors' => $totalVendors,
            'totalRevenue' => $totalRevenue,
            'pendingApprovals' => $pendingApprovals,
            'monthlyRevenue' => $monthlyRevenue,
            'topVendors' => $topVendors,
            'bestSellingProducts' => $bestSellingProducts,
            'paymentSettings' => $paymentSettings,
        ]);
    }

    public function updatePaymentSettings(Request $request): RedirectResponse
    {
        if (app()->environment('production')) {
            return back()->with('error', 'Production payment settings must be changed through environment variables and a redeploy, not from the admin dashboard.');
        }

        $provider = (string) $request->input('payment_provider', 'mock');

        $validated = $request->validate([
            'payment_provider' => ['required', 'string', 'in:mpesa,mock'],
            'mpesa_environment' => ['required', 'string', 'in:sandbox,production'],
            'mpesa_consumer_key' => [Rule::requiredIf($provider === 'mpesa'), 'nullable', 'string', 'max:255'],
            'mpesa_consumer_secret' => [Rule::requiredIf($provider === 'mpesa'), 'nullable', 'string', 'max:255'],
            'mpesa_passkey' => [Rule::requiredIf($provider === 'mpesa'), 'nullable', 'string', 'max:255'],
            'mpesa_shortcode' => [Rule::requiredIf($provider === 'mpesa'), 'nullable', 'string', 'max:255'],
            'mpesa_party_b' => ['nullable', 'string', 'max:255'],
            'mpesa_business_type' => ['required', 'string', 'in:paybill,till'],
            'mpesa_callback_url' => [Rule::requiredIf($provider === 'mpesa'), 'nullable', 'url', 'max:255'],
        ]);

        try {
            $this->environmentSettings->update([
                'PAYMENT_PROVIDER' => $validated['payment_provider'],
                'MPESA_ENV' => $validated['mpesa_environment'],
                'MPESA_CONSUMER_KEY' => $validated['mpesa_consumer_key'],
                'MPESA_CONSUMER_SECRET' => $validated['mpesa_consumer_secret'],
                'MPESA_PASSKEY' => $validated['mpesa_passkey'],
                'MPESA_SHORTCODE' => $validated['mpesa_shortcode'],
                'MPESA_PARTY_B' => $validated['mpesa_party_b'] ?: $validated['mpesa_shortcode'],
                'MPESA_BUSINESS_TYPE' => $validated['mpesa_business_type'],
                'MPESA_CALLBACK_URL' => $validated['mpesa_callback_url'],
            ]);
        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Unable to save payment settings: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Daraja payment settings updated successfully.');
    }
}
