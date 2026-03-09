<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Category;
use App\Models\Vendor;

class HomeController extends Controller
{
    public function index()
    {
        $trendingProducts = Product::where('status', 'active')
            ->orderBy('views', 'desc')
            ->limit(8)
            ->get();

        $popularServices = Service::where('status', 'active')
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();

        $categories = Category::all();

        return view('home', [
            'trendingProducts' => $trendingProducts,
            'popularServices' => $popularServices,
            'categories' => $categories,
        ]);
    }

    public function products(\Illuminate\Http\Request $request)
    {
        $query = Product::where('status', 'active');

        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->has('price_ranges')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->price_ranges as $range) {
                    if ($range === 'under_500') $q->orWhere('price', '<', 500);
                    if ($range === '500_1000') $q->orWhereBetween('price', [500, 1000]);
                    if ($range === '1000_5000') $q->orWhereBetween('price', [1000, 5000]);
                    if ($range === 'above_5000') $q->orWhere('price', '>', 5000);
                }
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('type', 'product')->get();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function services(\Illuminate\Http\Request $request)
    {
        $query = Service::where('status', 'active');

        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->has('pricing_types')) {
            $query->whereIn('pricing_type', $request->pricing_types);
        }

        $services = $query->paginate(12)->withQueryString();
        $categories = Category::where('type', 'service')->get();

        return view('services.index', [
            'services' => $services,
            'categories' => $categories,
        ]);
    }

    public function showProduct($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $product->increment('views');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function showService($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $service->increment('views');

        return view('services.show', [
            'service' => $service,
        ]);
    }
}
