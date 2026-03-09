@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-gray-900">My Service Bookings</h1>
            <p class="text-gray-600 mt-2">Track your project requests and professional confirmations.</p>
        </div>
        <a href="{{ route('services') }}" class="bg-green-700 text-white px-8 py-3 rounded-xl font-bold hover:bg-green-800 transition shadow-lg inline-block">
            🚜 Book New Service
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-8 py-5 font-black text-xs text-gray-400 uppercase tracking-widest">Service Details</th>
                        <th class="px-8 py-5 font-black text-xs text-gray-400 uppercase tracking-widest">Provider</th>
                        <th class="px-8 py-5 font-black text-xs text-gray-400 uppercase tracking-widest">Preferred Date</th>
                        <th class="px-8 py-5 font-black text-xs text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 font-black text-xs text-gray-400 uppercase tracking-widest text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-green-50/30 transition group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden flex-shrink-0 border">
                                    @if($booking->service->image_path)
                                    <img src="{{ $booking->service->image_path }}" alt="{{ $booking->service->name }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-xl">🏗</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $booking->service->name }}</p>
                                    <p class="text-xs text-gray-500">Ref: #BK-{{ $booking->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="font-medium text-gray-700">{{ $booking->vendor->business_name }}</p>
                            <p class="text-xs text-gray-400">{{ $booking->vendor->location }}</p>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2 text-gray-900 font-medium">
                                <span>📅</span>
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="inline-block px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider
                                {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="inline-block bg-white border border-green-700 text-green-700 px-4 py-2 rounded-lg font-bold text-sm hover:bg-green-700 hover:text-white transition">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="text-5xl mb-4 opacity-20">🚜</div>
                            <p class="text-gray-400 font-medium italic">You haven't made any service bookings yet.</p>
                            <a href="{{ route('services') }}" class="text-green-700 font-bold hover:underline mt-2 inline-block">Explore professional services</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-10">
        {{ $bookings->links() }}
    </div>
</div>
@endsection