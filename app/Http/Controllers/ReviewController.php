<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Service;
use App\Models\Order;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createProductReview(Request $request, Product $product)
    {
        // Check if user has ordered this product
        $hasOrdered = Order::where('user_id', Auth::id())
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->exists();

        return view('reviews.create', [
            'item' => $product,
            'type' => 'product',
            'is_verified' => $hasOrdered
        ]);
    }

    public function createServiceReview(Request $request, Service $service)
    {
        // Check if user has booked this service
        $hasBooked = Booking::where('user_id', Auth::id())
            ->where('service_id', $service->id)
            ->where('status', 'completed')
            ->exists();

        return view('reviews.create', [
            'item' => $service,
            'type' => 'service',
            'is_verified' => $hasBooked
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'product_id' => 'nullable|exists:products,id',
            'service_id' => 'nullable|exists:services,id',
        ]);

        $hasProduct = !empty($validated['product_id']);
        $hasService = !empty($validated['service_id']);

        if ($hasProduct === $hasService) {
            return back()
                ->withErrors(['reviewable' => 'Please review either a product or a service.'])
                ->withInput();
        }

        $product = $hasProduct ? Product::with('vendor')->findOrFail($validated['product_id']) : null;
        $service = $hasService ? Service::with('vendor')->findOrFail($validated['service_id']) : null;

        $vendorId = $product?->vendor_id ?? $service?->vendor_id;
        $isVerifiedPurchase = $product
            ? Order::where('user_id', Auth::id())
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->where('payment_status', 'completed')
                ->exists()
            : Booking::where('user_id', Auth::id())
                ->where('service_id', $service->id)
                ->where('status', 'completed')
                ->exists();

        Review::create([
            'user_id' => Auth::id(),
            'vendor_id' => $vendorId,
            'product_id' => $validated['product_id'] ?? null,
            'service_id' => $validated['service_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_verified_purchase' => $isVerifiedPurchase,
        ]);

        $route = $product
            ? route('products.show', $product->slug)
            : route('services.show', $service->slug);

        return redirect($route)->with('success', 'Review submitted successfully!');
    }
}
