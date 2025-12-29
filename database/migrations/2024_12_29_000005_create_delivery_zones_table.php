<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: "Paris et proche banlieue"
            $table->json('postal_codes'); // Liste des codes postaux couverts
            $table->decimal('delivery_cost', 8, 2); // Frais de livraison fixe
            $table->decimal('free_delivery_threshold', 8, 2)->nullable(); // Seuil livraison gratuite
            $table->integer('min_delivery_days')->default(1); // Délai minimum
            $table->integer('max_delivery_days')->default(7); // Délai maximum
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_zones');
    }
};