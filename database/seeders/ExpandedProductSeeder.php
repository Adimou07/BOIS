<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ExpandedProductSeeder extends Seeder
{
    public function run(): void
    {
        // Récupérer les catégories existantes
        $categories = [
            'chauffage' => Category::where('slug', 'like', '%chauffage%')->orWhere('name', 'like', '%chauffage%')->first(),
            'cuisson' => Category::where('slug', 'like', '%cuisson%')->orWhere('name', 'like', '%cuisson%')->first(),
        ];
        
        // Si pas trouvé, utiliser les premières catégories disponibles
        if (!$categories['chauffage']) {
            $categories['chauffage'] = Category::first();
        }
        if (!$categories['cuisson']) {
            $categories['cuisson'] = Category::skip(1)->first() ?? Category::first();
        }
        
        echo "Utilisation des catégories:" . PHP_EOL;
        echo "Chauffage: {$categories['chauffage']->name} (ID: {$categories['chauffage']->id})" . PHP_EOL;
        echo "Cuisson: {$categories['cuisson']->name} (ID: {$categories['cuisson']->id})" . PHP_EOL . PHP_EOL;

        // Nouvelles essences à ajouter
        $newProducts = [
            // FRÊNE - Bois dur excellent pour chauffage
            [
                'name' => 'Bois de Frêne Sec 33cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de frêne sec, excellent pouvoir calorifique. Idéal pour poêles et cheminées. Combustion longue et régulière.',
                'wood_type' => 'fresne',
                'conditioning' => 'Stère',
                'price_per_unit' => 95.00,
                'professional_price' => 85.00,
                'stock_quantity' => 45,
                'alert_stock_level' => 5,
            ],
            [
                'name' => 'Bois de Frêne Sec - Sacs 30kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs de bois de frêne sec 25-30cm. Parfait pour usage ponctuel. Bois dur de qualité premium.',
                'wood_type' => 'fresne',
                'conditioning' => 'Sac 30kg',
                'length' => 28,
                'price_per_unit' => 12.50,
                'professional_price' => 11.00,
                'stock_quantity' => 120,
                'alert_stock_level' => 15,
            ],

            // BOULEAU - Bois tendre, allumage facile
            [
                'name' => 'Bois de Bouleau Sec 25cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de bouleau sec, excellent pour l\'allumage et le démarrage. Flamme vive et agréable.',
                'wood_type' => 'bouleau',
                'conditioning' => 'Stère',
                'length' => 25,
                'price_per_unit' => 75.00,
                'professional_price' => 68.00,
                'stock_quantity' => 30,
                'alert_stock_level' => 3,
            ],
            [
                'name' => 'Bois de Bouleau - Sacs 25kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Sacs de bouleau sec 20-25cm. Idéal pour allumer vos feux rapidement. Écorce naturelle conservée.',
                'wood_type' => 'bouleau',
                'conditioning' => 'Sac 25kg',
                'length' => 22,
                'price_per_unit' => 10.90,
                'professional_price' => 9.50,
                'stock_quantity' => 85,
                'alert_stock_level' => 10,
            ],

            // CHARME - Bois très dur, excellent calorifique
            [
                'name' => 'Bois de Charme Sec 30cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de charme sec, le roi du chauffage. Pouvoir calorifique exceptionnel, combustion très longue.',
                'wood_type' => 'charme',
                'conditioning' => 'Stère',
                'length' => 30,
                'price_per_unit' => 105.00,
                'professional_price' => 95.00,
                'stock_quantity' => 25,
                'alert_stock_level' => 3,
            ],

            // ACACIA - Bois dur, résistant
            [
                'name' => 'Bois d\'Acacia Sec 33cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois d\'acacia sec, très dur et résistant. Excellent rendement calorifique, peu de cendres.',
                'wood_type' => 'acacia',
                'conditioning' => 'Stère',
                'length' => 33,
                'price_per_unit' => 98.00,
                'professional_price' => 88.00,
                'stock_quantity' => 20,
                'alert_stock_level' => 3,
            ],

            // CHÂTAIGNIER - Pour cuisson
            [
                'name' => 'Châtaignier Four à Pizza 30cm',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Bois de châtaignier sec pour four à pizza. Combustion rapide, flamme vive. Goût neutre.',
                'wood_type' => 'chataignier',
                'conditioning' => 'Sac 30kg',
                'length' => 30,
                'price_per_unit' => 16.50,
                'professional_price' => 14.50,
                'stock_quantity' => 65,
                'alert_stock_level' => 8,
            ],

            // VARIANTES EXISTANTES - Plus de tailles
            [
                'name' => 'Bois de Chêne Sec 25cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de chêne sec 25cm, parfait pour poêles. Même qualité que notre chêne 33cm mais plus petit.',
                'wood_type' => 'chene',
                'conditioning' => 'Stère',
                'length' => 25,
                'price_per_unit' => 88.00,
                'professional_price' => 78.00,
                'stock_quantity' => 35,
                'alert_stock_level' => 5,
            ],
            [
                'name' => 'Bois de Hêtre Sec 33cm - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Bois de hêtre sec 33cm en stère. Version professionnelle de notre hêtre en sacs.',
                'wood_type' => 'hetre',
                'conditioning' => 'Stère',
                'length' => 33,
                'price_per_unit' => 92.00,
                'professional_price' => 82.00,
                'stock_quantity' => 40,
                'alert_stock_level' => 5,
            ],

            // MÉLANGES SPÉCIAUX
            [
                'name' => 'Mélange Chêne-Hêtre Premium - Stère',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange premium 70% chêne 30% hêtre. Le meilleur des deux essences pour un chauffage optimal.',
                'wood_type' => 'melange',
                'conditioning' => 'Stère',
                'length' => 33,
                'price_per_unit' => 98.00,
                'professional_price' => 88.00,
                'stock_quantity' => 30,
                'alert_stock_level' => 4,
            ],
            [
                'name' => 'Mélange Allumage - Sacs 20kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Mélange spécial allumage : bouleau, châtaignier et résineux sec. Parfait pour démarrer vos feux.',
                'wood_type' => 'melange',
                'conditioning' => 'Sac 20kg',
                'length' => 25,
                'price_per_unit' => 8.90,
                'professional_price' => 7.50,
                'stock_quantity' => 95,
                'alert_stock_level' => 12,
            ],

            // CONDITIONNEMENTS PROS
            [
                'name' => 'Big Bag Chêne Pro - 1200kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Big Bag professionnel chêne sec 33cm. 1200kg de bois premium pour professionnels et gros consommateurs.',
                'wood_type' => 'chene',
                'conditioning' => 'Big Bag 1200kg',
                'length' => 33,
                'price_per_unit' => 850.00,
                'professional_price' => 780.00,
                'stock_quantity' => 8,
                'alert_stock_level' => 1,
                'is_professional_only' => true,
            ],
            [
                'name' => 'Palette Frêne Pro - 500kg',
                'category_id' => $categories['chauffage']->id,
                'description' => 'Palette de frêne sec pour professionnels. 500kg de bois de qualité, livraison directe.',
                'wood_type' => 'fresne',
                'conditioning' => 'Palette 500kg',
                'length' => 30,
                'price_per_unit' => 420.00,
                'professional_price' => 380.00,
                'stock_quantity' => 15,
                'alert_stock_level' => 2,
                'is_professional_only' => true,
            ],

            // CUISSON SPÉCIALISÉE
            [
                'name' => 'Pommier Fumage - Sacs 15kg',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Bois de pommier sec pour fumage. Goût fruité délicat, parfait pour poissons et volailles.',
                'wood_type' => 'pommier',
                'conditioning' => 'Sac 15kg',
                'length' => 20,
                'price_per_unit' => 24.90,
                'professional_price' => 22.00,
                'stock_quantity' => 45,
                'alert_stock_level' => 6,
            ],
            [
                'name' => 'Cerisier Barbecue - Sacs 20kg',
                'category_id' => $categories['cuisson']->id,
                'description' => 'Bois de cerisier sec pour barbecue et fumoir. Goût sucré et délicat, ideal pour viandes rouges.',
                'wood_type' => 'cerisier',
                'conditioning' => 'Sac 20kg',
                'length' => 25,
                'price_per_unit' => 26.50,
                'professional_price' => 23.50,
                'stock_quantity' => 38,
                'alert_stock_level' => 5,
            ],
        ];

        foreach ($newProducts as $productData) {
            $product = Product::create($productData);
            echo "✅ Produit créé: {$product->name}" . PHP_EOL;
        }

        echo PHP_EOL . "🎉 " . count($newProducts) . " nouveaux produits ajoutés au catalogue !" . PHP_EOL;
        echo "📊 Total produits: " . Product::count() . PHP_EOL;
    }
}