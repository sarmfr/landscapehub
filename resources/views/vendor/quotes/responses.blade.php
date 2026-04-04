@extends('layouts.vendor')

@section('content')
<div class="bg-gray-50 p-8 rounded-3xl min-h-screen">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-black text-gray-900 mb-2">My Proposals</h1>
            <p class="text-gray-500">Track the status of your submitted price quotes.</p>
        </div>
        <a href="{{ route('vendor.quotes.index') }}" class="inline-flex items-center bg-green-800 text-white font-black px-6 py-3 rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-lg text-sm mr-auto md:mr-0">
            Browse New Requests
        </a>
    </div>

    @if($responses->isEmpty())
    <div class="bg-white rounded-3xl p-16 text-center border-2 border-dashed border-gray-100 shadow-sm">
        <p class="text-gray-500 font-bold mb-6">You haven't submitted any proposals yet.</p>
        <a href="{{ route('vendor.quotes.index') }}" class="text-green-800 font-black hover:underline">Start browsing the marketplace</a>
    </div>
    @else
    <div class="grid grid-cols-1 gap-4">
        @foreach($responses as $response)
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center flex-grow">
                <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-2xl font-black text-gray-300 uppercase">
                    {{ substr($response->quote->user->name, 0, 1) }}
                </div>
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-600 text-[10px] font-black uppercase rounded">
                            {{ $response->quote->category->name }}
                        </span>
                        <span class="text-xs text-gray-400 font-bold">Client: {{ $response->quote->user->name }}</span>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 leading-tight mb-1">{{ Str::limit($response->quote->description, 80) }}</h3>
                    <p class="text-sm text-gray-500 font-medium">Submitted {{ $response->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="flex items-center gap-8 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-4 md:pt-0">
                <div class="text-right">
                    <p class="text-xs font-black uppercase tracking-widest text-gray-400 mb-1">Your Price</p>
                    <p class="text-2xl font-black text-green-800">KES {{ number_format($response->quoted_price) }}</p>
                </div>
                <div>
                    @if($response->status === 'pending')
                    <span class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 text-xs font-black uppercase tracking-widest rounded-xl">Pending</span>
                    @elseif($response->status === 'accepted')
                    <span class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 text-xs font-black uppercase tracking-widest rounded-xl">Hired</span>
                    @else
                    <span class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 text-xs font-black uppercase tracking-widest rounded-xl">Closed</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-8">
        {{ $responses->links() }}
    </div>
    @endif
</div>
@endsection