@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

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
        <strong>{{ $pendingApprovals }} vendor approval{{ $pendingApprovals !== 1 ? 's' : '' }} pending</strong> -
        <a href="{{ route('admin.vendors.index') }}" class="underline font-semibold">Review vendor applications</a>
    </p>
</div>
@endif

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

<div class="bg-white rounded-lg shadow p-6 mb-8">
    <div class="flex flex-col gap-2 mb-6">
        <h2 class="text-xl font-bold">Daraja Payment Settings</h2>
        <p class="text-sm text-gray-600">Update your Safaricom credentials here and the system will save them into the application environment for future payment requests.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-semibold mb-2">Please fix the following issues:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.dashboard.payment-settings') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="payment_provider" class="block text-sm font-semibold mb-2">Payment Provider</label>
                <select id="payment_provider" name="payment_provider" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none">
                    @php($selectedProvider = old('payment_provider', $paymentSettings['provider']))
                    <option value="mpesa" {{ $selectedProvider === 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                    <option value="mock" {{ $selectedProvider === 'mock' ? 'selected' : '' }}>Mock</option>
                </select>
            </div>

            <div>
                <label for="mpesa_environment" class="block text-sm font-semibold mb-2">Daraja Environment</label>
                <select id="mpesa_environment" name="mpesa_environment" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none">
                    @php($selectedEnvironment = old('mpesa_environment', $paymentSettings['environment']))
                    <option value="sandbox" {{ $selectedEnvironment === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                    <option value="production" {{ $selectedEnvironment === 'production' ? 'selected' : '' }}>Production</option>
                </select>
            </div>

            <div>
                <label for="mpesa_business_type" class="block text-sm font-semibold mb-2">Business Type</label>
                <select id="mpesa_business_type" name="mpesa_business_type" class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none">
                    @php($selectedBusinessType = old('mpesa_business_type', $paymentSettings['business_type']))
                    <option value="paybill" {{ $selectedBusinessType === 'paybill' ? 'selected' : '' }}>PayBill</option>
                    <option value="till" {{ $selectedBusinessType === 'till' ? 'selected' : '' }}>Till / Buy Goods</option>
                </select>
            </div>

            <div>
                <label for="mpesa_shortcode" class="block text-sm font-semibold mb-2">Shortcode</label>
                <input
                    id="mpesa_shortcode"
                    type="text"
                    name="mpesa_shortcode"
                    value="{{ old('mpesa_shortcode', $paymentSettings['short_code']) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none"
                    placeholder="174379"
                >
            </div>

            <div>
                <label for="mpesa_party_b" class="block text-sm font-semibold mb-2">Party B</label>
                <input
                    id="mpesa_party_b"
                    type="text"
                    name="mpesa_party_b"
                    value="{{ old('mpesa_party_b', $paymentSettings['party_b']) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none"
                    placeholder="Leave blank to use shortcode"
                >
            </div>

            <div>
                <label for="mpesa_callback_url" class="block text-sm font-semibold mb-2">Callback URL</label>
                <input
                    id="mpesa_callback_url"
                    type="url"
                    name="mpesa_callback_url"
                    value="{{ old('mpesa_callback_url', $paymentSettings['callback_url']) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none"
                    placeholder="https://your-domain.com/payments/webhook"
                >
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="mpesa_consumer_key" class="block text-sm font-semibold mb-2">Consumer Key</label>
                <input
                    id="mpesa_consumer_key"
                    type="text"
                    name="mpesa_consumer_key"
                    value="{{ old('mpesa_consumer_key', $paymentSettings['consumer_key']) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none"
                >
            </div>

            <div>
                <label for="mpesa_consumer_secret" class="block text-sm font-semibold mb-2">Consumer Secret</label>
                <input
                    id="mpesa_consumer_secret"
                    type="text"
                    name="mpesa_consumer_secret"
                    value="{{ old('mpesa_consumer_secret', $paymentSettings['consumer_secret']) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none"
                >
            </div>

            <div class="md:col-span-2">
                <label for="mpesa_passkey" class="block text-sm font-semibold mb-2">Passkey</label>
                <input
                    id="mpesa_passkey"
                    type="text"
                    name="mpesa_passkey"
                    value="{{ old('mpesa_passkey', $paymentSettings['passkey']) }}"
                    class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-green-600 focus:outline-none"
                >
            </div>
        </div>

        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600">
            <span>These settings are stored in the application `.env` file.</span>
            <button type="submit" class="rounded-lg bg-green-700 px-5 py-3 font-semibold text-white hover:bg-green-800">
                Save Payment Settings
            </button>
        </div>
    </form>
</div>

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

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    <a href="{{ route('admin.users.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">Manage Users</h3>
        <p class="text-gray-600 text-sm">View and manage user accounts</p>
    </a>
    <a href="{{ route('admin.vendors.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">Manage Vendors</h3>
        <p class="text-gray-600 text-sm">Approve, suspend, or reject vendors</p>
    </a>
    <a href="{{ route('admin.products.index') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-md transition">
        <h3 class="font-semibold text-lg mb-2">Moderate Products</h3>
        <p class="text-gray-600 text-sm">Review product listings and update their visibility</p>
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
