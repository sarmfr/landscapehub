<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteResponse;
use App\Services\SafeMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\QuoteResponseNotification;

class QuoteController extends Controller
{
    public function __construct(protected SafeMailService $safeMail)
    {
        $this->middleware(['auth', 'vendor']);
    }

    public function index()
    {
        $vendor = Auth::user()->vendor;

        // Browsable quotes for vendors
        // In a real app, we might filter by vendor's category/services
        $quotes = Quote::where('status', 'posted')
            ->whereDoesntHave('responses', function ($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })
            ->with(['user', 'category'])
            ->latest()
            ->paginate(15);

        return view('vendor.quotes.index', compact('quotes'));
    }

    public function myResponses()
    {
        $vendor = Auth::user()->vendor;
        $responses = QuoteResponse::where('vendor_id', $vendor->id)
            ->with('quote.user')
            ->latest()
            ->paginate(15);

        return view('vendor.quotes.responses', compact('responses'));
    }

    public function show(Quote $quote)
    {
        $quote->load(['user', 'category']);
        return view('vendor.quotes.show', compact('quote'));
    }

    public function storeResponse(Request $request, Quote $quote)
    {
        $vendor = Auth::user()->vendor;

        if ($quote->status !== 'posted') {
            return back()->with('error', 'This quote request is no longer accepting responses.');
        }

        $validated = $request->validate([
            'quoted_price' => 'required|numeric|min:0',
            'description' => 'required|string|min:10',
        ]);

        $response = QuoteResponse::create([
            'quote_id' => $quote->id,
            'vendor_id' => $vendor->id,
            'quoted_price' => $validated['quoted_price'],
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        $message = 'Response submitted successfully!';

        if (!$this->safeMail->send(
            $quote->user->email,
            new QuoteResponseNotification($response),
            'Quote response email failed to send.',
            [
                'quote_response_id' => $response->id,
                'quote_id' => $quote->id,
                'vendor_id' => $vendor->id,
            ]
        )) {
            $message .= ' Email notification could not be sent.';
        }

        return redirect()->route('vendor.quotes.index')->with('success', $message);
    }
}
