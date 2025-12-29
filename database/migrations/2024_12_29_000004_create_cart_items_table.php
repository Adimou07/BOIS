<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // Pour les invités
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Pour les connectés
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2); // Prix au moment de l'ajout
            $table->timestamps();
            
            $table->index(['session_id']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};