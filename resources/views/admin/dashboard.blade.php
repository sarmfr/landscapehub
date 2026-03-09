@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Total Users</div>
        <div class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Approved Vendors</div>
        <div class="text-3xl font-bold text-green-600">{{ $totalVendors }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Total Revenue</div>
        <div class="text-3xl font-bold text-purple-600">KES {{ number_format($totalRevenue) }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-gray-600 text-sm">Pending Approvals</div>
        <div class="text-3xl font-bold text-yellow-600">{{ $pendingApprovals }}</div>
    </div>
</div>

@if($pendingApprovals > 0)
<div class="bg-yellow-100 border border-yellow-400 rounded-lg p-4 mb-8">
    <p class="text-yellow-800">
        <strong>{{ $pendingApprovals }} vendor approval{{ $pendingApprovals !== 1 ? 's' : '' }} pending</strong> —
        <a href="{{ route('admin.vendors.index') }}" class="underline font-semibold">Review vendor applications</a>
    </p>
</div>
@endif

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Monthly Revenue</h2>
        <canvas id="revenueChart"></canvas>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Top Vendors</h2>
        <div class="space-y-3">
            @forelse($topVendors as $vendor)
            <div class="flex justify-between items-center pb-3 border-b">
                <span class="font-semibold">{{ $vendor->business_name }}</span>
                <span class="text-gray-600">{{ $vendor->products_count }} products</span>
            </div>
            @empty
            <p class="text-gray-500">No vendors yet</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Best Selling Products -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Best Selling Products</h2>
    <div class="space-y-3">
        @forelse($bestSellingProducts as $product)
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="font-semibold">{{ $product->name }}</span>
            <span class="text-gray-600">{{ $product->sold_count ?? 0 }} sold</span>
        </div>
        @empty
        <p class="text-gray-500">No sales yet</p>
        @endforelse
    </div>
</div>

<!-- Admin Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">👥 Manage Users</h3>
        <p class="text-gray-600 text-sm">View and manage user accounts</p>
    </a>
    <a href="{{ route('admin.vendors.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">🏪 Manage Vendors</h3>
        <p class="text-gray-600 text-sm">Approve, suspend, or reject vendors</p>
    </a>
    <a href="#" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">📊 View Reports</h3>
        <p class="text-gray-600 text-sm">Detailed analytics and reports</p>
    </a>
</div>
@endsection

@push('scripts')
<script>
    const revenueData = JSON.parse('{!! addslashes(json_encode($monthlyRevenue)) !!}');
    const ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueData.labels,
                datasets: [{
                    label: 'Revenue (KES)',
                    data: revenueData.data,
                    borderColor: '#0B6623',
                    backgroundColor: 'rgba(11, 102, 35, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
@endpush