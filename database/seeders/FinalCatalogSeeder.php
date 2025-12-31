<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class FinalCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'chauffage' => Category::first(),
            'cuisson' => Category::skip(1)->first() ?? Category::first(),
        ];

        // Utiliser EXACTEMENT les conditionnements existants
        $newProducts = [
            // CHÊNE - variantes avec conditionnements existants
            [
                'name' => 'Chêne Premium Sec - Stère Plus',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Chêne premium sec qualité supérieure pour chauffage haut de gamme.',
                'wood_type' => 'chene',
                'conditioning' => 'Stère', // EXACT comme existant
                'price_per_unit' => 105.00,
                'professional_price' => 95.00,
                'stock_quantity' => 25,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Chêne Sec - Sacs Premium 40kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs chêne sec 40kg, format pratique usage domestique.',
                'wood_type' => 'chene',
                'conditioning' => 'Sacs 40kg', // EXACT comme hêtre
                'price_per_unit' => 18.50,
                'professional_price' => 16.50,
                'stock_quantity' => 65,
                'alert_stock_level' => 8,
            ],

            // HÊTRE - variantes
            [
                'name' => 'Hêtre Premium - Stère Qualité',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Hêtre premium sec en stère, excellent rapport qualité prix chauffage.',
                'wood_type' => 'hetre',
                'conditioning' => 'Stère', // EXACT
                'price_per_unit' => 92.00,
                'professional_price' => 82.00,
                'stock_quantity' => 35,
                'alert_stock_level' => 5,
            ],

            // CHARME
            [
                'name' => 'Charme Sec Premium - Stère Excellence',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Charme sec premium, le roi du chauffage, combustion exceptionnelle.',
                'wood_type' => 'charme',
                'conditioning' => 'Stère', // EXACT
                'price_per_unit' => 118.00,
                'professional_price' => 108.00,
                'stock_quantity' => 15,
                'alert_stock_level' => 2,
            ],

            // BOULEAU
            [
                'name' => 'Bouleau Sec Allumage - Stère Nature',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bouleau sec excellent allumage, flamme vive, écorce naturelle.',
                'wood_type' => 'bouleau',
                'conditioning' => 'Stère', // EXACT
                'price_per_unit' => 78.00,
                'professional_price' => 70.00,
                'stock_quantity' => 28,
                'alert_stock_level' => 3,
            ],

            // MÉLANGES avec conditionnements existants
            [
                'name' => 'Mélange Premium - Stère Qualité',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange premium chêne hêtre, le top du chauffage domestique.',
                'wood_type' => 'melange',
                'conditioning' => 'Stère', // EXACT
                'price_per_unit' => 98.00,
                'professional_price' => 88.00,
                'stock_quantity' => 22,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Mélange Feuillus - Palette Pro',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange feuillus sur palette, format professionnel pratique.',
                'wood_type' => 'melange',
                'conditioning' => 'Palette', // EXACT comme existant
                'price_per_unit' => 420.00,
                'professional_price' => 380.00,
                'stock_quantity' => 12,
                'alert_stock_level' => 2,
                'is_professional_only' => true,
            ],

            // FRUITIERS avec conditionnements existants
            [
                'name' => 'Fruitiers Fumage Premium',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Bois fruitiers fumage premium, mélange pommier cerisier prunier.',
                'wood_type' => 'fruitiers',
                'conditioning' => 'Sacs 25kg', // EXACT comme existant
                'price_per_unit' => 22.50,
                'professional_price' => 20.00,
                'stock_quantity' => 45,
                'alert_stock_level' => 5,
            ],

            // BIG BAGS
            [
                'name' => 'Big Bag Chêne Professionnel',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Big Bag chêne 1000kg format professionnel, livraison incluse.',
                'wood_type' => 'chene',
                'conditioning' => 'Big Bag', // EXACT comme hêtre existant
                'price_per_unit' => 790.00,
                'professional_price' => 720.00,
                'stock_quantity' => 6,
                'alert_stock_level' => 1,
                'is_professional_only' => true,
            ],
            [
                'name' => 'Big Bag Charme Elite Pro',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Big Bag charme 1000kg qualité elite pour professionnels exigeants.',
                'wood_type' => 'charme',
                'conditioning' => 'Big Bag', // EXACT
                'price_per_unit' => 950.00,
                'professional_price' => 880.00,
                'stock_quantity' => 4,
                'alert_stock_level' => 1,
                'is_professional_only' => true,
            ]
        ];

        foreach ($newProducts as $productData) {
            $product = Product::create($productData);
            echo "✅ {$product->name}" . PHP_EOL;
        }

        echo PHP_EOL . "🎉 " . count($newProducts) . " nouveaux produits créés !" . PHP_EOL;
        echo "📊 Catalogue total: " . Product::count() . " produits" . PHP_EOL;
    }
}