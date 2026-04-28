<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $products = Product::with(['vendor', 'category'])->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load(['vendor', 'category', 'images', 'orderItems', 'reviews.user']);
        return view('admin.products.show', compact('product'));
    }

    public function updateStatus(Request $request, Product $product)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $product->update($validated);

        return back()->with('success', 'Product status updated successfully');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully (Soft Deleted)');
    }
}
