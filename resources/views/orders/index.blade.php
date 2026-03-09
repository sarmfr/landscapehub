@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <h1 class="text-3xl font-bold mb-8">My Orders</h1>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Order #</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Date</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Total</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700">Status</th>
                    <th class="px-6 py-4 font-bold text-sm text-gray-700 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $order->order_number }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 font-bold text-green-800">KES {{ number_format($order->total_amount) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase 
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                               ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('orders.show', $order->id) }}" class="text-green-700 font-bold hover:underline">View Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">You haven't placed any orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</div>
@endsection