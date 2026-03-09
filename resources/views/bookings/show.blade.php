@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <a href="{{ route('bookings.my') }}" class="text-green-700 hover:underline font-bold">← My Bookings</a>
            <h1 class="text-3xl font-black mt-2 text-gray-900">Booking Request Details</h1>
            <p class="text-gray-500">Submitted on {{ $booking->created_at->format('M d, Y \a\t H:i') }}</p>
        </div>
        <div class="flex items-center">
            <span class="px-6 py-2 rounded-full text-sm font-black uppercase tracking-widest shadow-sm
                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                   ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                   ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                Status: {{ $booking->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Service Info Card -->
            <div class="bg-white rounded-3xl shadow-xl border overflow-hidden">
                <div class="p-8 border-b bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-900">Requested Service</h2>
                </div>
                <div class="p-8">
                    <div class="flex items-start gap-6">
                        <div class="w-32 h-32 rounded-2xl bg-gray-100 overflow-hidden flex-shrink-0">
                            @if($booking->service->getImageUrl())
                            <img src="{{ $booking->service->getImageUrl() }}" alt="{{ $booking->service->name }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-4xl">🏗</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-1">{{ $booking->service->name }}</h3>
                            <p class="text-gray-600 mb-4">Provided by <span class="font-bold text-green-700">{{ $booking->vendor->business_name }}</span></p>
                            <div class="flex items-center gap-4">
                                @if($booking->service->pricing_type === 'fixed')
                                <p class="text-green-800 font-black text-2xl">KES {{ number_format($booking->service->price) }}</p>
                                @else
                                <span class="bg-green-100 text-green-800 px-4 py-1 rounded-full text-sm font-bold">Custom Quote Needed</span>
                                @endif

                                @if($booking->status === 'confirmed' || $booking->status === 'completed')
                                <a href="{{ route('reviews.service', $booking->service_id) }}" class="bg-yellow-400 text-yellow-900 px-4 py-1 rounded-full text-xs font-black hover:bg-yellow-500 transition shadow-sm uppercase tracking-widest">Rate Service</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Requirements Card -->
            <div class="bg-white rounded-3xl shadow-xl border overflow-hidden">
                <div class="p-8 border-b bg-gray-50">
                    <h2 class="text-xl font-bold text-gray-900">Your Requirements</h2>
                </div>
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-1">Preferred Date</p>
                            <p class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-1">Project Location</p>
                            <p class="text-lg font-bold text-gray-900">{{ $booking->location }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-1">Description of Needs</p>
                        <div class="bg-gray-50 p-6 rounded-2xl border italic text-gray-700 leading-relaxed">
                            {{ $booking->description }}
                        </div>
                    </div>

                    @if($booking->image)
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-black tracking-widest mb-3">Reference Photo</p>
                        <div class="rounded-2xl overflow-hidden border max-w-md">
                            <img src="{{ asset('storage/' . $booking->image) }}" alt="Reference Photo" class="w-full h-auto">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Vendor Info -->
            <div class="bg-green-800 text-white rounded-3xl shadow-xl p-8">
                <h3 class="font-black text-xl mb-4">Contact Professional</h3>
                <p class="text-green-100 text-sm mb-6 leading-relaxed">
                    The professional has been notified. They will review your request and contact you via phone or the platform to finalize details.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">📞</div>
                        <div>
                            <p class="text-xs text-green-300 font-bold uppercase tracking-widest">Business Phone</p>
                            <p class="font-bold">{{ $booking->vendor->business_phone ?? 'Available upon confirmation' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">🏫</div>
                        <div>
                            <p class="text-xs text-green-300 font-bold uppercase tracking-widest">Business Name</p>
                            <p class="font-bold">{{ $booking->vendor->business_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-white/10">
                    <p class="text-xs italic text-green-200">
                        Need help? <a href="#" class="underline hover:text-white">Contact support</a> if you don't hear back within 24 hours.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection