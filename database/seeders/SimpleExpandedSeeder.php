<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class SimpleExpandedSeeder extends Seeder
{
    public function run(): void
    {
        // Utiliser les essences existantes
        $categories = [
            'chauffage' => Category::first(),
            'cuisson' => Category::skip(1)->first() ?? Category::first(),
        ];

        $newProducts = [
            // Plus de variantes CHÊNE
            [
                'name' => 'Bois de Chêne Sec 25cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de chêne sec 25cm, parfait pour poêles. Même qualité premium que notre chêne 33cm.',
                'wood_type' => 'chene',
                'conditioning' => 'Stère 25cm',
                'price_per_unit' => 88.00,
                'professional_price' => 78.00,
                'stock_quantity' => 35,
                'alert_stock_level' => 5,
            ],
            [
                'name' => 'Chêne Premium - Sacs 35kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs de chêne premium 35kg. Bois sec, haute qualité, idéal pour usage domestique.',
                'wood_type' => 'chene',
                'conditioning' => 'Sac 35kg',
                'price_per_unit' => 16.50,
                'professional_price' => 14.50,
                'stock_quantity' => 75,
                'alert_stock_level' => 8,
            ],
            [
                'name' => 'Big Bag Chêne Premium - 1200kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Big Bag chêne sec 1200kg. Format professionnel pour gros besoins de chauffage.',
                'wood_type' => 'chene',
                'conditioning' => 'Big Bag',
                'price_per_unit' => 850.00,
                'professional_price' => 780.00,
                'stock_quantity' => 8,
                'alert_stock_level' => 1,
                'is_professional_only' => true,
            ],

            // Plus de variantes HÊTRE
            [
                'name' => 'Bois de Hêtre Sec 30cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de hêtre sec en stère 30cm. Excellent rapport qualité/prix pour chauffage domestique.',
                'wood_type' => 'hetre',
                'conditioning' => 'Stère 30cm',
                'price_per_unit' => 92.00,
                'professional_price' => 82.00,
                'stock_quantity' => 40,
                'alert_stock_level' => 5,
            ],
            [
                'name' => 'Hêtre Séché - Sacs 30kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs de hêtre séché 30kg. Bois dense, excellent pouvoir calorifique.',
                'wood_type' => 'hetre',
                'conditioning' => 'Sac 30kg',
                'price_per_unit' => 13.50,
                'professional_price' => 12.00,
                'stock_quantity' => 95,
                'alert_stock_level' => 10,
            ],

            // Plus de variantes CHARME
            [
                'name' => 'Bois de Charme Sec 30cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de charme sec, le roi du chauffage. Pouvoir calorifique exceptionnel.',
                'wood_type' => 'charme',
                'conditioning' => 'Stère 30cm',
                'price_per_unit' => 105.00,
                'professional_price' => 95.00,
                'stock_quantity' => 25,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Charme Premium - Sacs 25kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs de charme premium 25kg. Le meilleur bois de chauffage disponible.',
                'wood_type' => 'charme',
                'conditioning' => 'Sac 25kg',
                'price_per_unit' => 17.90,
                'professional_price' => 16.00,
                'stock_quantity' => 45,
                'alert_stock_level' => 5,
            ],

            // Plus de variantes BOULEAU
            [
                'name' => 'Bois de Bouleau Sec 25cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de bouleau sec, excellent pour allumage. Flamme vive et belle écorce.',
                'wood_type' => 'bouleau',
                'conditioning' => 'Stère 25cm',
                'price_per_unit' => 75.00,
                'professional_price' => 68.00,
                'stock_quantity' => 30,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Bouleau Allumage - Sacs 20kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs de bouleau 20kg, parfait pour allumer vos feux. Écorce conservée.',
                'wood_type' => 'bouleau',
                'conditioning' => 'Sac 20kg',
                'price_per_unit' => 9.90,
                'professional_price' => 8.50,
                'stock_quantity' => 85,
                'alert_stock_level' => 10,
            ],

            // Plus de MÉLANGES
            [
                'name' => 'Mélange Chêne-Hêtre Premium - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange premium 70% chêne 30% hêtre. Le meilleur des deux essences.',
                'wood_type' => 'melange',
                'conditioning' => 'Stère mixte',
                'price_per_unit' => 98.00,
                'professional_price' => 88.00,
                'stock_quantity' => 30,
                'alert_stock_level' => 4,
            ],
            [
                'name' => 'Mélange Allumage Rapide - Sacs 15kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange spécial allumage rapide. Bouleau et résineux secs.',
                'wood_type' => 'melange',
                'conditioning' => 'Sac 15kg',
                'price_per_unit' => 7.90,
                'professional_price' => 6.50,
                'stock_quantity' => 120,
                'alert_stock_level' => 15,
            ],

            // Plus de BOIS FRUITIERS
            [
                'name' => 'Bois Fruitiers Fumage - Sacs 20kg',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Mélange bois fruitiers pour fumage. Pommier, cerisier, prunier. Saveur délicate.',
                'wood_type' => 'fruitiers',
                'conditioning' => 'Sac 20kg',
                'price_per_unit' => 22.50,
                'professional_price' => 20.00,
                'stock_quantity' => 55,
                'alert_stock_level' => 6,
            ],
            [
                'name' => 'Fruitiers Premium Barbecue - Sacs 30kg',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Bois fruitiers premium pour barbecue et plancha. Goût authentique garanti.',
                'wood_type' => 'fruitiers',
                'conditioning' => 'Sac 30kg',
                'price_per_unit' => 28.90,
                'professional_price' => 26.00,
                'stock_quantity' => 40,
                'alert_stock_level' => 5,
            ],

            // CONDITIONNEMENTS PROS
            [
                'name' => 'Palette Mélange Pro - 600kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Palette professionnelle mélange dur 600kg. Chêne, hêtre, charme.',
                'wood_type' => 'melange',
                'conditioning' => 'Palette 600kg',
                'price_per_unit' => 480.00,
                'professional_price' => 420.00,
                'stock_quantity' => 12,
                'alert_stock_level' => 2,
                'is_professional_only' => true,
            ],
            [
                'name' => 'Big Bag Hêtre Professionnel - 1000kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Big Bag hêtre 1000kg spécial professionnels. Livraison directe chantier.',
                'wood_type' => 'hetre',
                'conditioning' => 'Big Bag 1000kg',
                'price_per_unit' => 720.00,
                'professional_price' => 650.00,
                'stock_quantity' => 6,
                'alert_stock_level' => 1,
                'is_professional_only' => true,
            ],

            // PETITS FORMATS
            [
                'name' => 'Chêne Starter - Sacs 10kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Petit format chêne 10kg pour tester. Parfait pour découvrir notre qualité.',
                'wood_type' => 'chene',
                'conditioning' => 'Sac 10kg',
                'price_per_unit' => 8.50,
                'professional_price' => 7.50,
                'stock_quantity' => 150,
                'alert_stock_level' => 20,
            ],
            [
                'name' => 'Hêtre Découverte - Sacs 15kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Format découverte hêtre 15kg. Idéal pour premiers essais.',
                'wood_type' => 'hetre',
                'conditioning' => 'Sac 15kg',
                'price_per_unit' => 6.90,
                'professional_price' => 6.00,
                'stock_quantity' => 180,
                'alert_stock_level' => 25,
            ],
        ];

        foreach ($newProducts as $productData) {
            $product = Product::create($productData);
            echo "✅ {$product->name}" . PHP_EOL;
        }

        echo PHP_EOL . "🎉 " . count($newProducts) . " nouveaux produits ajoutés !" . PHP_EOL;
        echo "📊 Total catalogue: " . Product::count() . " produits" . PHP_EOL;
    }
}