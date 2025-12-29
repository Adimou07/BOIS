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
        // Corriger le prix du produit Hêtre 40kg
        \App\Models\Product::where('name', 'LIKE', '%Hêtre%')
                           ->where('name', 'LIKE', '%40kg%')
                           ->update(['price_per_unit' => 85.00]);
        
        // Mettre à jour les prix dans le panier existant
        \App\Models\CartItem::whereHas('product', function($query) {
            $query->where('name', 'LIKE', '%Hêtre%')
                  ->where('name', 'LIKE', '%40kg%');
        })->update(['unit_price' => 85.00]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre l'ancien prix si besoin
        \App\Models\Product::where('name', 'LIKE', '%Hêtre%')
                           ->where('name', 'LIKE', '%40kg%')
                           ->update(['price_per_unit' => 8.50]);
    }
};
