<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class QuickCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'chauffage' => Category::first(),
            'cuisson' => Category::skip(1)->first() ?? Category::first(),
        ];

        // Utiliser EXACTEMENT les mêmes formats que les produits existants
        $newProducts = [
            // CHÊNE - variantes
            [
                'name' => 'Chêne Premium Sec - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Chêne premium sec qualité supérieure, idéal chauffage domestique.',
                'wood_type' => 'chene',
                'conditioning' => 'Stère',
                'price_per_unit' => 105.00,
                'professional_price' => 95.00,
                'stock_quantity' => 25,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Chêne Sec - Sacs 30kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs chêne sec 30kg, parfait usage ponctuel et test qualité.',
                'wood_type' => 'chene',
                'conditioning' => 'Sacs 30kg',
                'price_per_unit' => 15.50,
                'professional_price' => 13.50,
                'stock_quantity' => 80,
                'alert_stock_level' => 8,
            ],

            // HÊTRE - variantes  
            [
                'name' => 'Hêtre Premium - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Hêtre premium sec en stère, excellent rapport qualité prix.',
                'wood_type' => 'hetre',
                'conditioning' => 'Stère',
                'price_per_unit' => 92.00,
                'professional_price' => 82.00,
                'stock_quantity' => 35,
                'alert_stock_level' => 5,
            ],
            [
                'name' => 'Hêtre Sec - Sacs 30kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs hêtre sec 30kg, bois dense excellent pouvoir calorifique.',
                'wood_type' => 'hetre',
                'conditioning' => 'Sacs 30kg',
                'price_per_unit' => 13.90,
                'professional_price' => 12.50,
                'stock_quantity' => 90,
                'alert_stock_level' => 10,
            ],

            // CHARME - nouvelles options
            [
                'name' => 'Charme Sec Premium - Stère', 
                'category_id' => $categories['chauffage']->id,
                'description' => 'Charme sec premium, le roi du chauffage, combustion longue.',
                'wood_type' => 'charme',
                'conditioning' => 'Stère',
                'price_per_unit' => 118.00,
                'professional_price' => 108.00,
                'stock_quantity' => 15,
                'alert_stock_level' => 2,
            ],
            [
                'name' => 'Charme Sec - Sacs 25kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs charme sec 25kg, le meilleur bois disponible sur le marché.',
                'wood_type' => 'charme',
                'conditioning' => 'Sacs 25kg',
                'price_per_unit' => 18.90,
                'professional_price' => 17.00,
                'stock_quantity' => 45,
                'alert_stock_level' => 5,
            ],

            // BOULEAU
            [
                'name' => 'Bouleau Sec Allumage - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bouleau sec excellent allumage, flamme vive, écorce conservée.',
                'wood_type' => 'bouleau',
                'conditioning' => 'Stère',
                'price_per_unit' => 78.00,
                'professional_price' => 70.00,
                'stock_quantity' => 28,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Bouleau Allumage - Sacs 20kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs bouleau 20kg spécial allumage, démarrage rapide garanti.',
                'wood_type' => 'bouleau',
                'conditioning' => 'Sacs 20kg',
                'price_per_unit' => 10.50,
                'professional_price' => 9.00,
                'stock_quantity' => 75,
                'alert_stock_level' => 8,
            ],

            // MÉLANGES
            [
                'name' => 'Mélange Premium - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange premium chêne hêtre charme, le top du chauffage.',
                'wood_type' => 'melange',
                'conditioning' => 'Stère',
                'price_per_unit' => 98.00,
                'professional_price' => 88.00,
                'stock_quantity' => 22,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Mélange Allumage - Sacs 15kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange spécial allumage rapide, bouleau et résineux secs.',
                'wood_type' => 'melange',
                'conditioning' => 'Sacs 15kg',
                'price_per_unit' => 8.50,
                'professional_price' => 7.50,
                'stock_quantity' => 95,
                'alert_stock_level' => 12,
            ],

            // FRUITIERS - plus de variantes
            [
                'name' => 'Fruitiers Fumage - Sacs 15kg',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Bois fruitiers fumage pommier cerisier, goût authentique.',
                'wood_type' => 'fruitiers',
                'conditioning' => 'Sacs 15kg',
                'price_per_unit' => 19.90,
                'professional_price' => 18.00,
                'stock_quantity' => 55,
                'alert_stock_level' => 6,
            ],
            [
                'name' => 'Fruitiers BBQ Premium - Sacs 30kg',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Fruitiers premium barbecue et plancha, saveur exceptionnelle.',
                'wood_type' => 'fruitiers',
                'conditioning' => 'Sacs 30kg',
                'price_per_unit' => 32.50,
                'professional_price' => 29.00,
                'stock_quantity' => 35,
                'alert_stock_level' => 4,
            ],

            // FORMATS PROS
            [
                'name' => 'Big Bag Chêne Pro',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Big Bag chêne professionnel 1000kg, livraison directe.',
                'wood_type' => 'chene',
                'conditioning' => 'Big Bag',
                'price_per_unit' => 790.00,
                'professional_price' => 720.00,
                'stock_quantity' => 6,
                'alert_stock_level' => 1,
                'is_professional_only' => true,
            ],
            [
                'name' => 'Big Bag Hêtre Pro',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Big Bag hêtre professionnel 1000kg, qualité garantie.',
                'wood_type' => 'hetre',
                'conditioning' => 'Big Bag',
                'price_per_unit' => 750.00,
                'professional_price' => 680.00,
                'stock_quantity' => 8,
                'alert_stock_level' => 1,
                'is_professional_only' => true,
            ],
            [
                'name' => 'Palette Mélange Pro',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Palette professionnelle mélange dur 500kg, chêne hêtre.',
                'wood_type' => 'melange',
                'conditioning' => 'Palette',
                'price_per_unit' => 420.00,
                'professional_price' => 380.00,
                'stock_quantity' => 12,
                'alert_stock_level' => 2,
                'is_professional_only' => true,
            ],

            // PETITS FORMATS
            [
                'name' => 'Chêne Starter - Sacs 10kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Format découverte chêne 10kg, parfait pour tester.',
                'wood_type' => 'chene',
                'conditioning' => 'Sacs 10kg',
                'price_per_unit' => 8.90,
                'professional_price' => 7.90,
                'stock_quantity' => 120,
                'alert_stock_level' => 15,
            ],
            [
                'name' => 'Hêtre Découverte - Sacs 10kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Format découverte hêtre 10kg, idéal premiers essais.',
                'wood_type' => 'hetre',
                'conditioning' => 'Sacs 10kg',
                'price_per_unit' => 7.50,
                'professional_price' => 6.50,
                'stock_quantity' => 140,
                'alert_stock_level' => 18,
            ]
        ];

        foreach ($newProducts as $productData) {
            $product = Product::create($productData);
            echo "✅ {$product->name}" . PHP_EOL;
        }

        echo PHP_EOL . "🎉 " . count($newProducts) . " produits ajoutés au catalogue !" . PHP_EOL;
        echo "📊 Votre catalogue contient maintenant " . Product::count() . " produits" . PHP_EOL;
    }
}