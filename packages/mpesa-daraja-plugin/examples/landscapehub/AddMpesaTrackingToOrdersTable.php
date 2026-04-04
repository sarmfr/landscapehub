<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_provider')->default('mpesa')->after('payment_status');
            $table->string('merchant_request_id')->nullable()->after('mpesa_reference');
            $table->string('checkout_request_id')->nullable()->after('merchant_request_id');
            $table->json('payment_payload')->nullable()->after('checkout_request_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_provider',
                'merchant_request_id',
                'checkout_request_id',
                'payment_payload',
            ]);
        });
    }
};
