@extends('layouts.vendor')

@section('content')
<div class="bg-gray-50 p-8 rounded-3xl min-h-screen">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">Quote Marketplace</h1>
            <p class="text-gray-500">Available custom requests from customers seeking landscaping services.</p>
        </div>
        <a href="{{ route('vendor.quotes.responses') }}" class="inline-flex items-center text-green-800 font-bold hover:underline">
            View My Proposals
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>

    @if($quotes->isEmpty())
    <div class="bg-white rounded-3xl p-16 text-center border-2 border-dashed border-gray-100 shadow-sm">
        <div class="w-20 h-20 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-gray-900 mb-2">Marketplace is Quiet</h2>
        <p class="text-gray-500">Check back later for new custom project requests from customers.</p>
    </div>
    @else
    <div class="grid grid-cols-1 gap-6">
        @foreach($quotes as $quote)
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:border-green-300 transition-all">
            <div class="flex flex-col lg:flex-row gap-8">
                @if($quote->image)
                <div class="w-full lg:w-48 h-48 rounded-2xl overflow-hidden flex-shrink-0">
                    <img src="{{ Storage::url($quote->image) }}" alt="Project" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="flex-grow">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-3 py-1 bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-widest rounded-full">
                            {{ $quote->category->name }}
                        </span>
                        <span class="text-xs text-gray-400 font-bold">Posted {{ $quote->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center text-gray-700 font-bold mb-4">
                        <svg class="w-4 h-4 mr-1 text-green-800 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9l-4.243-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $quote->location }}
                    </div>
                    <p class="text-gray-600 leading-relaxed mb-6">{{ Str::limit($quote->description, 300) }}</p>

                    <div class="flex items-center justify-between gap-4 pt-6 border-t border-gray-50">
                        <div class="text-sm text-gray-500 font-bold">
                            <span class="text-gray-900">{{ $quote->responses->count() }}</span> proposals received so far
                        </div>
                        <a href="{{ route('vendor.quotes.show', $quote) }}" class="bg-green-800 text-white font-black px-8 py-3 rounded-2xl hover:scale-105 hover:bg-green-700 active:scale-95 transition-all shadow-lg whitespace-nowrap">
                            Review & Propose
                        </a>
                    </div>
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
@endsection