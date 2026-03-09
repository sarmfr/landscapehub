<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuoteRequestNotification;
use App\Mail\QuoteAcceptedNotification;
use App\Models\Vendor;

class QuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $quotes = Auth::user()->quotes()->latest()->paginate(10);
        return view('quotes.index', compact('quotes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('quotes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('quotes', 'public');
        }

        $quote = Quote::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'status' => 'posted',
        ]);

        // Notify all active vendors (Simplified)
        $vendors = Vendor::where('approval_status', 'approved')->with('user')->get();
        foreach ($vendors as $vendor) {
            Mail::to($vendor->user->email)->queue(new QuoteRequestNotification($quote));
        }

        return redirect()->route('quotes.show', $quote)->with('success', 'Quote request posted successfully!');
    }

    public function show(Quote $quote)
    {
        if ($quote->user_id !== Auth::id()) {
            abort(403);
        }

        $quote->load(['responses.vendor', 'category']);
        return view('quotes.show', compact('quote'));
    }

    public function acceptResponse(QuoteResponse $response)
    {
        $quote = $response->quote;

        if ($quote->user_id !== Auth::id()) {
            abort(403);
        }

        $quote->update([
            'status' => 'accepted',
            'accepted_vendor_id' => $response->vendor_id,
        ]);

        $response->update(['status' => 'accepted']);

        // Notify the accepted vendor
        Mail::to($response->vendor->user->email)->send(new QuoteAcceptedNotification($quote, $response));

        // Reject other pending responses
        $quote->responses()->where('id', '!=', $response->id)->update(['status' => 'rejected']);

        return back()->with('success', 'Vendor response accepted!');
    }
}
