<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Service $service)
    {
        if ($service->vendor->approval_status !== 'approved') {
            return redirect()->route('services.show', $service->slug)->with('error', 'This vendor is currently suspended. Bookings are temporarily disabled.');
        }
        return view('bookings.create', ['service' => $service]);
    }

    public function store(Request $request, Service $service)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($service->vendor->approval_status !== 'approved') {
            return redirect()->route('services.show', $service->slug)->with('error', 'This vendor is currently suspended. Bookings are temporarily disabled.');
        }

        $validated = $request->validate([
            'booking_date' => 'required|date|after:today',
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('bookings', 'public');
        }

        $booking = Booking::create([
            'service_id' => $service->id,
            'user_id' => Auth::id(),
            'vendor_id' => $service->vendor_id,
            'booking_date' => $validated['booking_date'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking request submitted!');
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', ['booking' => $booking]);
    }

    public function myBookings()
    {
        $bookings = Booking::where('user_id', Auth::id())->latest()->paginate(10);
        return view('bookings.my-bookings', ['bookings' => $bookings]);
    }
}
