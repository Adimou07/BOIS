<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // D'abord, déplacer tous les produits "Professionnels" vers "Bois de Chauffage"
        $chauffageCategory = DB::table('categories')->where('slug', 'bois-de-chauffage')->first();
        $professionnelsCategory = DB::table('categories')->where('slug', 'professionnels')->first();
        
        if ($chauffageCategory && $professionnelsCategory) {
            // Déplacer tous les produits de la catégorie professionnels vers chauffage
            DB::table('products')
                ->where('category_id', $professionnelsCategory->id)
                ->update(['category_id' => $chauffageCategory->id]);
        }
        
        // Maintenant supprimer la catégorie "Professionnels"
        DB::table('categories')->where('slug', 'professionnels')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recréer la catégorie "Professionnels" en cas de rollback
        DB::table('categories')->insert([
            'name' => 'Professionnels',
            'slug' => 'professionnels',
            'description' => 'Solutions en gros volumes pour restaurants, pizzerias, boulangeries et hôtels',
            'seo_title' => 'Bois Professionnel - Restaurants et Pizzerias',
            'meta_description' => 'Fournisseur de bois pour professionnels. Volumes importants, prix dégressifs, livraison programmée.',
            'is_active' => true,
            'sort_order' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
};
