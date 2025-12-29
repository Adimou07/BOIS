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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            
            // Spécificités bois
            $table->enum('wood_type', ['chene', 'hetre', 'charme', 'fruitiers', 'sapin', 'epicea', 'bouleau', 'melange']);
            $table->enum('usage_type', ['chauffage', 'cuisson', 'both']);
            $table->decimal('humidity_rate', 3, 1)->nullable(); // Taux d'humidité
            $table->enum('conditioning', ['vrac', 'sacs_25kg', 'sacs_40kg', 'palettes', 'steres', 'big_bags']);
            $table->enum('unit_type', ['kg', 'stere', 'm3', 'palette', 'sac']);
            
            // Prix et stock
            $table->decimal('price_per_unit', 8, 2);
            $table->decimal('professional_price', 8, 2)->nullable(); // Prix pro
            $table->integer('stock_quantity')->default(0);
            $table->integer('min_order_quantity')->default(1);
            $table->integer('alert_stock_level')->default(10);
            $table->boolean('is_professional_only')->default(false);
            
            // Relations
            $table->foreignId('category_id')->constrained('categories');
            
            // SEO
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            
            // Statut
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();
            
            $table->index(['status', 'category_id']);
            $table->index(['wood_type', 'usage_type']);
            $table->index(['stock_quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};