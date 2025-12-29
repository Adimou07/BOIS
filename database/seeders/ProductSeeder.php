<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $chauffageCategory = Category::where('slug', 'bois-de-chauffage')->first();
        $cuissonCategory = Category::where('slug', 'bois-de-cuisson')->first();
        $proCategory = Category::where('slug', 'professionnels')->first();

        $products = [
            // BOIS DE CHAUFFAGE
            [
                'name' => 'Bois de Chêne Sec 33cm - Stère',
                'slug' => 'bois-chene-sec-33cm-stere',
                'description' => "Bois de chêne premium, séché naturellement pendant 24 mois. Taux d'humidité inférieur à 20%. 
                
Parfait pour tous types de chauffage : cheminée ouverte, poêle à bois, insert. Longue combustion et excellent pouvoir calorifique.

Conditionné en stère (1m³ empilé), livré sur palette pour faciliter le stockage.",
                'short_description' => 'Chêne sec premium, séché 24 mois, < 20% humidité',
                'wood_type' => 'chene',
                'usage_type' => 'chauffage',
                'humidity_rate' => 18.5,
                'conditioning' => 'steres',
                'unit_type' => 'stere',
                'price_per_unit' => 85.00,
                'professional_price' => 78.00,
                'stock_quantity' => 45,
                'min_order_quantity' => 1,
                'alert_stock_level' => 5,
                'category_id' => $chauffageCategory->id,
                'seo_title' => 'Bois de Chêne Sec 33cm - Stère - WoodShop',
                'meta_description' => 'Achetez votre stère de chêne sec 33cm. Séché 24 mois, < 20% humidité. Livraison rapide.',
                'status' => 'active'
            ],
            [
                'name' => 'Bois de Hêtre Sec - Sacs 40kg',
                'slug' => 'bois-hetre-sec-sacs-40kg',
                'description' => "Bois de hêtre de première qualité en sacs de 40kg pratiques à manipuler.

Le hêtre offre une combustion régulière avec de belles flammes et une chaleur constante. Idéal pour les poêles à bois et inserts.

Conditionnement en sacs étanches pour préserver la qualité du bois. Facile à stocker.",
                'short_description' => 'Hêtre sec premium en sacs pratiques de 40kg',
                'wood_type' => 'hetre',
                'usage_type' => 'chauffage',
                'humidity_rate' => 19.2,
                'conditioning' => 'sacs_40kg',
                'unit_type' => 'sac',
                'price_per_unit' => 8.50,
                'stock_quantity' => 120,
                'min_order_quantity' => 5,
                'alert_stock_level' => 20,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],
            [
                'name' => 'Mélange Feuillus 25cm - Palette',
                'slug' => 'melange-feuillus-25cm-palette',
                'description' => "Mélange équilibré de bois feuillus (chêne, hêtre, charme) en bûches de 25cm.

Parfait pour un usage quotidien, offre un excellent rapport qualité-prix. Combustion efficace et régulière.

Livré sur palette filmée (environ 1,5 stère). Format 25cm adapté aux petits foyers.",
                'short_description' => 'Mélange chêne/hêtre/charme 25cm sur palette',
                'wood_type' => 'melange',
                'usage_type' => 'chauffage',
                'humidity_rate' => 20.0,
                'conditioning' => 'palettes',
                'unit_type' => 'palette',
                'price_per_unit' => 110.00,
                'professional_price' => 95.00,
                'stock_quantity' => 25,
                'min_order_quantity' => 1,
                'alert_stock_level' => 5,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // BOIS DE CUISSON
            [
                'name' => 'Bois Fruitiers Barbecue - Sacs 25kg',
                'slug' => 'bois-fruitiers-barbecue-sacs-25kg',
                'description' => "Mélange de bois fruitiers (pommier, cerisier, prunier) spécialement sélectionné pour la cuisson.

Apporte des arômes délicats à vos grillades. Combustion lente et régulière, peu de fumée. Sans traitement chimique.

Parfait pour barbecue, plancha et fumage. Conditionnement pratique en sacs de 25kg.",
                'short_description' => 'Mélange fruitiers pour barbecue, arômes délicats',
                'wood_type' => 'fruitiers',
                'usage_type' => 'cuisson',
                'humidity_rate' => 15.8,
                'conditioning' => 'sacs_25kg',
                'unit_type' => 'sac',
                'price_per_unit' => 12.90,
                'stock_quantity' => 80,
                'min_order_quantity' => 2,
                'alert_stock_level' => 15,
                'category_id' => $cuissonCategory->id,
                'status' => 'active'
            ],
            [
                'name' => 'Chêne Four à Pizza 30cm',
                'slug' => 'chene-four-pizza-30cm',
                'description' => "Chêne spécialement coupé pour four à pizza traditionnel. Bûches de 30cm parfaites pour la cuisson au feu de bois.

Montée en température rapide, combustion intense. Goût authentique pour vos pizzas artisanales.

Bois non traité, adapté au contact alimentaire. Séché naturellement pour une combustion optimale.",
                'short_description' => 'Chêne 30cm spécial four à pizza, goût authentique',
                'wood_type' => 'chene',
                'usage_type' => 'cuisson',
                'humidity_rate' => 16.5,
                'conditioning' => 'steres',
                'unit_type' => 'stere',
                'price_per_unit' => 95.00,
                'professional_price' => 85.00,
                'stock_quantity' => 15,
                'min_order_quantity' => 1,
                'alert_stock_level' => 3,
                'category_id' => $cuissonCategory->id,
                'status' => 'active'
            ],

            // PROFESSIONNELS
            [
                'name' => 'Big Bag Hêtre Pro - 1000kg',
                'slug' => 'big-bag-hetre-pro-1000kg',
                'description' => "Solution professionnelle en big bag de 1000kg pour restaurants et pizzerias.

Bois de hêtre premium, parfait pour la cuisson professionnelle. Livraison avec grue pour faciliter la manutention.

Prix dégressifs à partir de 5 big bags. Facturation professionnelle avec conditions de paiement adaptées.",
                'short_description' => 'Solution pro 1000kg, livraison avec grue',
                'wood_type' => 'hetre',
                'usage_type' => 'both',
                'humidity_rate' => 18.0,
                'conditioning' => 'big_bags',
                'unit_type' => 'sac',
                'price_per_unit' => 320.00,
                'professional_price' => 280.00,
                'stock_quantity' => 12,
                'min_order_quantity' => 2,
                'alert_stock_level' => 3,
                'is_professional_only' => true,
                'category_id' => $proCategory->id,
                'status' => 'active'
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);
            
            // Ajouter des images d'exemple
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => '/images/products/' . $product->slug . '-1.jpg',
                'alt_text' => $product->name . ' - Image principale',
                'sort_order' => 1,
                'is_primary' => true
            ]);
        }
    }
}