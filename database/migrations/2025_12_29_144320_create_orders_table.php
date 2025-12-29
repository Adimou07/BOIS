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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_cost', 8, 2)->default(0);
            $table->decimal('tax_amount', 8, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Shipping address
            $table->string('shipping_name');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_postal_code');
            $table->string('shipping_country')->default('France');
            
            // Billing address (can be same as shipping)
            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_postal_code')->nullable();
            $table->string('billing_country')->nullable();
            
            // Company info for professionals
            $table->string('company_name')->nullable();
            $table->string('siret')->nullable();
            
            // Payment info
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('payment_reference')->nullable();
            
            $table->text('notes')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
