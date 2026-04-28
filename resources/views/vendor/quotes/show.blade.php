@extends('layouts.vendor')

@section('content')
<div class="bg-gray-50 p-8 rounded-3xl min-h-screen">
    <div class="mb-8">
        <a href="{{ route('vendor.quotes.index') }}" class="inline-flex items-center text-gray-500 hover:text-green-800 font-bold transition-all mb-4 text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Marketplace
        </a>
        <h1 class="text-4xl font-black text-gray-900">Project Details</h1>
        <p class="text-gray-500">Review the requirements and submit your price proposal.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                @if($quote->image)
                <div class="h-80 w-full overflow-hidden">
                    <img src="{{ Storage::url($quote->image) }}" alt="Project" class="w-full h-full object-cover">
                </div>
                @endif
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-black uppercase tracking-widest rounded-full">
                            {{ $quote->category->name }}
                        </span>
                        <div class="flex items-center text-sm font-bold text-gray-400">
                            <svg class="w-4 h-4 mr-1 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $quote->location }}
                            <span class="mx-3 text-gray-200">|</span>
                            Posted {{ $quote->created_at->format('M d, Y') }}
                        </div>
                    </div>
                    <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Project Requirements</h3>
                    <div class="text-lg text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $quote->description }}</div>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 sticky top-8">
                <h3 class="text-2xl font-black text-gray-900 mb-6">Submit Proposal</h3>

                <form action="{{ route('vendor.quotes.respond', $quote) }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="quoted_price" class="block text-sm font-bold text-gray-700 mb-2">Estimated Price (KES)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-gray-400">KES</span>
                            <input type="number" name="quoted_price" id="quoted_price" step="0.01" value="{{ old('quoted_price') }}" class="w-full bg-gray-50 border-0 rounded-2xl pl-16 pr-6 py-4 font-black text-xl text-green-800 focus:ring-2 focus:ring-green-600 transition-all @error('quoted_price') ring-2 ring-red-500 @enderror" required>
                        </div>
                        @error('quoted_price')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Proposal Details</label>
                        <textarea name="description" id="description" rows="5" placeholder="Explain your pricing and how you plan to tackle this project..." class="w-full bg-gray-50 border-0 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-green-600 transition-all @error('description') ring-2 ring-red-500 @enderror" required>{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 font-medium">Minimum 10 characters.</p>
                    </div>

                    <button type="submit" class="w-full bg-green-800 text-white font-black py-5 rounded-2xl hover:bg-green-700 active:scale-95 transition-all shadow-lg text-lg">
                        Submit Proposal
                    </button>
                    <p class="text-center text-xs text-gray-400 font-medium pt-2">Submit your best offer to win the job.</p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection