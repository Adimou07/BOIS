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
        // Corriger le prix du produit Hêtre 40kg au bon montant : 42.50€
        \App\Models\Product::where('name', 'LIKE', '%Hêtre%')
                           ->where('name', 'LIKE', '%40kg%')
                           ->update(['price_per_unit' => 42.50]);
        
        // Mettre à jour les prix dans le panier existant
        \App\Models\CartItem::whereHas('product', function($query) {
            $query->where('name', 'LIKE', '%Hêtre%')
                  ->where('name', 'LIKE', '%40kg%');
        })->update(['unit_price' => 42.50]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre le prix précédent
        \App\Models\Product::where('name', 'LIKE', '%Hêtre%')
                           ->where('name', 'LIKE', '%40kg%')
                           ->update(['price_per_unit' => 85.00]);
    }
};
