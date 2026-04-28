<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

class CartController extends Controller
{
    public function view()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $items = [];

        try {
            foreach ($cart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    $items[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'subtotal' => $product->price * $quantity,
                    ];
                    $total += $product->price * $quantity;
                }
            }
        } catch (QueryException|PDOException $e) {
            report($e);

            return view('cart', [
                'items' => [],
                'total' => 0,
            ])->withErrors([
                'cart' => 'Your cart is temporarily unavailable while we reconnect to the database.',
            ]);
        }

        return view('cart', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        try {
            $product = Product::findOrFail($productId);
        } catch (QueryException|PDOException $e) {
            report($e);

            return back()->withErrors([
                'cart' => 'We could not add this item right now. Please try again shortly.',
            ]);
        }

        if ($product->vendor->approval_status !== 'approved') {
            return back()->withErrors(['vendor' => 'This vendor is currently suspended. Purchases are temporarily disabled.']);
        }

        if ($product->stock < $quantity) {
            return back()->withErrors(['stock' => 'Insufficient stock available.']);
        }

        $cart = session()->get('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart!');
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        unset($cart[$productId]);
        session()->put('cart', $cart);

        return back()->with('success', 'Product removed from cart!');
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'mpesa_phone' => ['required', 'string', 'max:20'],
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.view')->withErrors(['cart' => 'Your cart is empty!']);
        }

        $total = 0;
        $commissionAmount = 0;
        $items = [];

        try {
            foreach ($cart as $productId => $quantity) {
                $product = Product::with('vendor')->find($productId);
                if ($product) {
                    $subtotal = $product->price * $quantity;
                    $rate = (float) ($product->vendor->commission_rate ?? config('payment.commission_rate', 10));

                    $items[] = [
                        'product_id' => $productId,
                        'product_name' => $product->name,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ];

                    $total += $subtotal;
                    $commissionAmount += ($subtotal * $rate) / 100;
                }
            }
        } catch (QueryException|PDOException $e) {
            report($e);

            return redirect()
                ->route('cart.view')
                ->withErrors(['cart' => 'Checkout is temporarily unavailable. Please try again shortly.']);
        }

        $vendorAmount = $total - $commissionAmount;

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'total_amount' => $total,
            'commission_amount' => $commissionAmount,
            'vendor_amount' => $vendorAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_provider' => config('payment.default', 'mpesa'),
            'mpesa_phone' => $request->input('mpesa_phone'),
        ]);

        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('order.payment', $order->id);
    }
}
