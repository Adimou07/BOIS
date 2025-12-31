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
        Schema::table('products', function (Blueprint $table) {
            // Modifier l'enum pour inclure toutes les essences
            $table->enum('wood_type', [
                'chene', 
                'hetre', 
                'charme', 
                'fruitiers', 
                'sapin', 
                'epicea', 
                'bouleau', 
                'melange',
                'fresne',
                'acacia',
                'chataignier',
                'pommier',
                'cerisier'
            ])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revenir à l'enum original
            $table->enum('wood_type', [
                'chene', 
                'hetre', 
                'charme', 
                'fruitiers', 
                'sapin', 
                'epicea', 
                'bouleau', 
                'melange'
            ])->change();
        });
    }
};