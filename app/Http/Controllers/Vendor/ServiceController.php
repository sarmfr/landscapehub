<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('vendor');
    }

    /**
     * Display vendor's services
     */
    public function index()
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        $services = Service::where('vendor_id', $vendor->id)
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('vendor.services.index', compact('services', 'vendor'));
    }

    /**
     * Show service creation form
     */
    public function create()
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        if ($vendor->approval_status !== 'approved') {
            return redirect()->route('vendor.dashboard')
                ->with('error', 'Your vendor profile must be approved before adding services.');
        }

        $categories = Category::all();

        return view('vendor.services.create', compact('categories'));
    }

    /**
     * Store service in database
     */
    public function store(Request $request)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor || $vendor->approval_status !== 'approved') {
            return redirect()->route('vendor.dashboard');
        }

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string|min:20|max:3000',
            'category_id'  => 'required|exists:categories,id',
            'pricing_type' => 'required|in:fixed,quote',
            'price'        => 'nullable|numeric|min:0|max:999999.99|required_if:pricing_type,fixed',
            'status'       => 'required|in:active,inactive',
        ]);

        $slug = Str::slug($request->name) . '-' . uniqid();

        Service::create([
            'vendor_id'    => $vendor->id,
            'category_id'  => $validated['category_id'],
            'name'         => $validated['name'],
            'slug'         => $slug,
            'description'  => $validated['description'],
            'pricing_type' => $validated['pricing_type'],
            'price'        => $validated['pricing_type'] === 'fixed' ? $validated['price'] : null,
            'status'       => $validated['status'],
        ]);

        return redirect()->route('vendor.services.index')
            ->with('success', 'Service created successfully!');
    }

    /**
     * Show service edit form
     */
    public function edit(Service $service)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor || $service->vendor_id !== $vendor->id) {
            return redirect()->route('vendor.services.index')
                ->with('error', 'Unauthorized.');
        }

        $categories = Category::all();

        return view('vendor.services.edit', compact('service', 'categories'));
    }

    /**
     * Update service
     */
    public function update(Request $request, Service $service)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor || $service->vendor_id !== $vendor->id) {
            return redirect()->route('vendor.services.index')
                ->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string|min:20|max:3000',
            'category_id'  => 'required|exists:categories,id',
            'pricing_type' => 'required|in:fixed,quote',
            'price'        => 'nullable|numeric|min:0|max:999999.99|required_if:pricing_type,fixed',
            'status'       => 'required|in:active,inactive',
        ]);

        $service->update([
            'category_id'  => $validated['category_id'],
            'name'         => $validated['name'],
            'description'  => $validated['description'],
            'pricing_type' => $validated['pricing_type'],
            'price'        => $validated['pricing_type'] === 'fixed' ? $validated['price'] : null,
            'status'       => $validated['status'],
        ]);

        return redirect()->route('vendor.services.index')
            ->with('success', 'Service updated successfully!');
    }

    /**
     * Delete service
     */
    public function destroy(Service $service)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor || $service->vendor_id !== $vendor->id) {
            return redirect()->route('vendor.services.index')
                ->with('error', 'Unauthorized.');
        }

        $service->delete();

        return redirect()->route('vendor.services.index')
            ->with('success', 'Service deleted successfully!');
    }

    public function show(Service $service)
    {
        abort(404);
    }
}
