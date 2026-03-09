@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-black text-gray-900 mb-2">My Quote Requests</h1>
                <p class="text-gray-500">Track and manage your custom landscaping requests and vendor proposals.</p>
            </div>
            <a href="{{ route('quotes.create') }}" class="inline-flex items-center bg-green-800 text-white font-black px-8 py-4 rounded-2xl hover:scale-105 hover:bg-green-700 active:scale-95 transition-all shadow-lg whitespace-nowrap">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Post New Request
            </a>
        </div>

        @if($quotes->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center shadow-md">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-green-50 text-green-700 rounded-full mb-6">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-gray-900 mb-2">No Requests Found</h2>
            <p class="text-gray-500 mb-8 max-w-md mx-auto">You haven't posted any custom quote requests yet. Get started by describing your project today!</p>
            <a href="{{ route('quotes.create') }}" class="inline-flex items-center text-green-800 font-black hover:underline">
                Post your first request
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($quotes as $quote)
            <div class="bg-white rounded-3xl shadow-md overflow-hidden hover:shadow-xl transition-all border border-gray-100 flex flex-col h-full">
                <div class="p-8 flex-grow">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs font-black uppercase tracking-widest rounded-full mb-2">
                                {{ $quote->category->name }}
                            </span>
                            <h3 class="text-xl font-black text-gray-900 leading-tight truncate max-w-xs">
                                {{ Str::limit($quote->description, 50) }}
                            </h3>
                        </div>
                        <div class="text-right">
                            @if($quote->status === 'posted')
                            <span class="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                                Finding Vendors
                            </span>
                            @elseif($quote->status === 'accepted')
                            <span class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Accepted
                            </span>
                            @else
                            <span class="inline-flex items-center px-3 py-1 bg-gray-50 text-gray-700 text-xs font-bold rounded-full">
                                {{ ucfirst($quote->status) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-6">
                        <svg class="w-4 h-4 mr-1 text-green-800 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $quote->location }}
                        <span class="mx-2 opacity-30">•</span>
                        <svg class="w-4 h-4 mr-1 text-green-800 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z" />
                        </svg>
                        {{ $quote->created_at->format('M d, Y') }}
                    </div>

                    <div class="flex items-center justify-between bg-gray-50 rounded-2xl p-4">
                        <div class="flex items-center">
                            <div class="flex -space-x-2 mr-3">
                                @foreach($quote->responses->take(3) as $resp)
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-green-100 flex items-center justify-center text-[10px] font-black text-green-800 uppercase">
                                    {{ substr($resp->vendor->business_name, 0, 1) }}
                                </div>
                                @endforeach
                            </div>
                            <span class="text-sm font-bold text-gray-700">
                                {{ $quote->responses->count() }} {{ Str::plural('Proposal', $quote->responses->count()) }}
                            </span>
                        </div>
                        <a href="{{ route('quotes.show', $quote) }}" class="text-green-800 font-bold hover:underline">View All</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $quotes->links() }}
        </div>
        @endif
    </div>
</div>
@endsection