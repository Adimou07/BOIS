<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_type', ['full', 'partial'])->default('full')->after('payment_method');
            $table->decimal('deposit_amount', 10, 2)->default(0)->after('payment_type');
            $table->decimal('remaining_amount', 10, 2)->default(0)->after('deposit_amount');
            $table->enum('deposit_status', ['pending', 'paid', 'failed'])->default('pending')->after('remaining_amount');
            $table->enum('remaining_status', ['pending', 'paid', 'not_required'])->default('not_required')->after('deposit_status');
            $table->timestamp('deposit_paid_at')->nullable()->after('remaining_status');
            $table->timestamp('remaining_paid_at')->nullable()->after('deposit_paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type',
                'deposit_amount', 
                'remaining_amount',
                'deposit_status',
                'remaining_status',
                'deposit_paid_at',
                'remaining_paid_at'
            ]);
        });
    }
};
