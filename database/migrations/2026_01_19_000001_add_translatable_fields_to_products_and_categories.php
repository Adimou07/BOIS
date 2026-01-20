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
        // Ajouter les champs translatables aux produits
        Schema::table('products', function (Blueprint $table) {
            // Le nom et la description deviennent translatables
            $table->json('name_i18n')->nullable()->after('name');
            $table->json('description_i18n')->nullable()->after('description');
        });

        // Migrer les données existantes vers le format JSON
        DB::statement("
            UPDATE products 
            SET 
                name_i18n = JSON_OBJECT('fr', name),
                description_i18n = CASE 
                    WHEN description IS NOT NULL 
                    THEN JSON_OBJECT('fr', description)
                    ELSE NULL 
                END
        ");

        // Ajouter les champs translatables aux catégories
        Schema::table('categories', function (Blueprint $table) {
            $table->json('name_i18n')->nullable()->after('name');
            $table->json('description_i18n')->nullable()->after('description');
        });

        // Migrer les données existantes pour les catégories
        DB::statement("
            UPDATE categories 
            SET 
                name_i18n = JSON_OBJECT('fr', name),
                description_i18n = CASE 
                    WHEN description IS NOT NULL 
                    THEN JSON_OBJECT('fr', description)
                    ELSE NULL 
                END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_i18n', 'description_i18n']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['name_i18n', 'description_i18n']);
        });
    }
};