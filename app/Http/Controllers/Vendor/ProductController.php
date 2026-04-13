<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('vendor');
    }

    /**
     * Display vendor's products
     */
    public function index()
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        $products = Product::where('vendor_id', $vendor->id)
            ->with('category', 'images')
            ->paginate(15);

        return view('vendor.products.index', ['products' => $products, 'vendor' => $vendor]);
    }

    /**
     * Show product creation form
     */
    public function create()
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        $categories = Category::all();

        return view('vendor.products.create', ['categories' => $categories]);
    }

    /**
     * Store product in database
     */
    public function store(Request $request)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.profile.create');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:20|max:2000',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'stock' => 'required|integer|min:0|max:99999',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Create slug
        $slug = Str::slug($request->name) . '-' . uniqid();

        // Create product
        $product = Product::create([
            'vendor_id' => $vendor->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'status' => 'active',
        ]);

        // Handle images
        $isPrimary = true;
        try {
            foreach ($request->file('images', []) as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $isPrimary,
                ]);

                $isPrimary = false;
            }
        } catch (Throwable $e) {
            report($e);
            $product->delete();

            return back()
                ->withInput()
                ->withErrors(['images' => 'We could not save your product images right now. Please try again shortly.']);
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Show product edit form
     */
    public function edit(Product $product)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor || $product->vendor_id !== $vendor->id) {
            return redirect()->route('vendor.products.index')
                ->with('error', 'Unauthorized');
        }

        $categories = Category::all();

        return view('vendor.products.edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor || $product->vendor_id !== $vendor->id) {
            return redirect()->route('vendor.products.index')
                ->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:20|max:2000',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'stock' => 'required|integer|min:0|max:99999',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'status' => $validated['status'],
        ]);

        // Handle new images
        if ($request->hasFile('images')) {
            try {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'is_primary' => false,
                    ]);
                }
            } catch (Throwable $e) {
                report($e);

                return back()
                    ->withInput()
                    ->withErrors(['images' => 'We could not save the uploaded images right now. Please try again shortly.']);
            }
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Delete image
     */
    public function deleteImage(ProductImage $image)
    {
        $product = $image->product;
        $vendor = Auth::user()->vendor;

        if (!$vendor || $product->vendor_id !== $vendor->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Don't allow deleting if it's the last image
        if ($product->images()->count() <= 1) {
            return response()->json(['error' => 'Cannot delete the last image'], 400);
        }

        // Delete file
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor || $product->vendor_id !== $vendor->id) {
            return redirect()->route('vendor.products.index')
                ->with('error', 'Unauthorized');
        }

        // Delete associated images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
