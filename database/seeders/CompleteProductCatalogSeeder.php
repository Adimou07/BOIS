<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class CompleteProductCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $chauffageCategory = Category::where('slug', 'bois-de-chauffage')->first();
        $cuissonCategory = Category::where('slug', 'bois-de-cuisson')->first();

        // Vider les produits existants de façon sécurisée
        ProductImage::query()->delete();
        Product::query()->delete();

        $products = [
            // ======== CHÊNE ========
            [
                'name' => 'Bois de Chêne Sec 33cm - Stère Premium',
                'slug' => 'bois-chene-sec-33cm-stere-premium',
                'description' => "Chêne de première qualité, séché naturellement pendant 24 mois minimum. Taux d'humidité inférieur à 20%. Excellent pouvoir calorifique de 4,2 kWh/kg. Combustion lente et régulière, parfait pour les longues soirées d'hiver. Idéal pour cheminées ouvertes, poêles à bois et inserts. Conditionné en stère (1m³ empilé), livré sur palette.",
                'short_description' => 'Chêne premium séché 24 mois, excellent pouvoir calorifique',
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
                'status' => 'active'
            ],
            [
                'name' => 'Chêne Cuisson Four à Pizza 30cm',
                'slug' => 'chene-cuisson-four-pizza-30cm',
                'description' => "Chêne spécialement sélectionné pour la cuisson au feu de bois. Bûches de 30cm parfaites pour four à pizza traditionnel. Montée en température rapide et combustion intense. Apporte un goût authentique à vos pizzas artisanales. Bois non traité, adapté au contact alimentaire.",
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
            [
                'name' => 'Chêne 25cm - Sacs 40kg',
                'slug' => 'chene-25cm-sacs-40kg',
                'description' => "Chêne sec en sacs pratiques de 40kg. Format 25cm idéal pour poêles et inserts. Excellent rapport qualité-prix pour du chêne premium. Sacs étanches pour préserver la qualité. Facile à manipuler et à stocker.",
                'short_description' => 'Chêne 25cm premium en sacs pratiques 40kg',
                'wood_type' => 'chene',
                'usage_type' => 'chauffage',
                'humidity_rate' => 19.0,
                'conditioning' => 'sacs_40kg',
                'unit_type' => 'sac',
                'price_per_unit' => 9.50,
                'professional_price' => 8.80,
                'stock_quantity' => 100,
                'min_order_quantity' => 3,
                'alert_stock_level' => 15,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== HÊTRE ========
            [
                'name' => 'Bois de Hêtre Sec - Sacs 40kg',
                'slug' => 'bois-hetre-sec-sacs-40kg',
                'description' => "Hêtre de première qualité en sacs de 40kg. Combustion régulière avec de belles flammes et chaleur constante. Idéal pour poêles à bois et inserts. Conditionnement étanche pour préserver la qualité.",
                'short_description' => 'Hêtre premium en sacs pratiques de 40kg',
                'wood_type' => 'hetre',
                'usage_type' => 'chauffage',
                'humidity_rate' => 19.2,
                'conditioning' => 'sacs_40kg',
                'unit_type' => 'sac',
                'price_per_unit' => 8.50,
                'professional_price' => 7.80,
                'stock_quantity' => 120,
                'min_order_quantity' => 5,
                'alert_stock_level' => 20,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],
            [
                'name' => 'Hêtre 33cm - Stère',
                'slug' => 'hetre-33cm-stere',
                'description' => "Hêtre sec en stère, format 33cm. Excellent bois de chauffage avec combustion vive et régulière. Pouvoir calorifique élevé. Parfait pour un chauffage d'appoint ou principal.",
                'short_description' => 'Hêtre 33cm en stère, combustion vive',
                'wood_type' => 'hetre',
                'usage_type' => 'chauffage',
                'humidity_rate' => 18.8,
                'conditioning' => 'steres',
                'unit_type' => 'stere',
                'price_per_unit' => 78.00,
                'professional_price' => 72.00,
                'stock_quantity' => 35,
                'min_order_quantity' => 1,
                'alert_stock_level' => 5,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],
            [
                'name' => 'Big Bag Hêtre Pro - 1000kg',
                'slug' => 'big-bag-hetre-pro-1000kg',
                'description' => "Solution professionnelle en big bag de 1000kg pour restaurants et pizzerias. Hêtre premium pour cuisson professionnelle. Livraison avec grue. Prix dégressifs dès 5 big bags.",
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
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== CHARME ========
            [
                'name' => 'Charme 30cm - Palette',
                'slug' => 'charme-30cm-palette',
                'description' => "Charme sec sur palette, format 30cm. Bois dense avec excellent pouvoir calorifique. Combustion longue et régulière. Idéal pour maintenir la chaleur toute la nuit. Environ 1,4 stère par palette.",
                'short_description' => 'Charme dense 30cm, combustion longue',
                'wood_type' => 'charme',
                'usage_type' => 'chauffage',
                'humidity_rate' => 19.5,
                'conditioning' => 'palettes',
                'unit_type' => 'palette',
                'price_per_unit' => 115.00,
                'professional_price' => 105.00,
                'stock_quantity' => 20,
                'min_order_quantity' => 1,
                'alert_stock_level' => 4,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],
            [
                'name' => 'Charme 25cm - Sacs 25kg',
                'slug' => 'charme-25cm-sacs-25kg',
                'description' => "Charme en sacs de 25kg, format 25cm. Bois très dense, combustion lente et régulière. Parfait pour les petits foyers. Excellent rapport qualité-prix pour ce bois noble.",
                'short_description' => 'Charme dense en sacs 25kg, combustion lente',
                'wood_type' => 'charme',
                'usage_type' => 'chauffage',
                'humidity_rate' => 20.0,
                'conditioning' => 'sacs_25kg',
                'unit_type' => 'sac',
                'price_per_unit' => 7.90,
                'stock_quantity' => 80,
                'min_order_quantity' => 4,
                'alert_stock_level' => 12,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== BOIS FRUITIERS ========
            [
                'name' => 'Bois Fruitiers Barbecue - Sacs 25kg',
                'slug' => 'bois-fruitiers-barbecue-sacs-25kg',
                'description' => "Mélange de bois fruitiers (pommier, cerisier, prunier) pour barbecue. Arômes délicats, combustion lente et régulière. Peu de fumée. Sans traitement chimique. Parfait pour grillades et fumage.",
                'short_description' => 'Mélange fruitiers barbecue, arômes délicats',
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
                'name' => 'Fruitiers Premium Mix - Stère',
                'slug' => 'fruitiers-premium-mix-stere',
                'description' => "Mélange premium de bois fruitiers en stère. Excellent pour chauffage d'agrément et cuisson. Parfum délicat qui embaume votre intérieur. Bois noble aux propriétés exceptionnelles.",
                'short_description' => 'Mix fruitiers premium, parfum délicat',
                'wood_type' => 'fruitiers',
                'usage_type' => 'both',
                'humidity_rate' => 17.0,
                'conditioning' => 'steres',
                'unit_type' => 'stere',
                'price_per_unit' => 110.00,
                'professional_price' => 98.00,
                'stock_quantity' => 8,
                'min_order_quantity' => 1,
                'alert_stock_level' => 2,
                'category_id' => $cuissonCategory->id,
                'status' => 'active'
            ],

            // ======== SAPIN ========
            [
                'name' => 'Sapin Allumage - Sacs 25kg',
                'slug' => 'sapin-allumage-sacs-25kg',
                'description' => "Sapin sec pour allumage, en sacs de 25kg. Prend feu rapidement grâce à sa résine naturelle. Parfait pour démarrer vos feux. Complément idéal aux bois durs. Prix très économique.",
                'short_description' => 'Sapin allumage rapide, très économique',
                'wood_type' => 'sapin',
                'usage_type' => 'chauffage',
                'humidity_rate' => 22.0,
                'conditioning' => 'sacs_25kg',
                'unit_type' => 'sac',
                'price_per_unit' => 4.90,
                'stock_quantity' => 150,
                'min_order_quantity' => 5,
                'alert_stock_level' => 30,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],
            [
                'name' => 'Sapin 30cm - Palette Économique',
                'slug' => 'sapin-30cm-palette-economique',
                'description' => "Sapin en palette, format 30cm. Solution très économique pour chauffage d'appoint. Allumage facile, combustion rapide. Idéal en mélange avec des bois durs.",
                'short_description' => 'Sapin économique 30cm, allumage facile',
                'wood_type' => 'sapin',
                'usage_type' => 'chauffage',
                'humidity_rate' => 23.0,
                'conditioning' => 'palettes',
                'unit_type' => 'palette',
                'price_per_unit' => 65.00,
                'stock_quantity' => 40,
                'min_order_quantity' => 1,
                'alert_stock_level' => 8,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== ÉPICÉA ========
            [
                'name' => 'Épicéa 25cm - Sacs 40kg',
                'slug' => 'epicea-25cm-sacs-40kg',
                'description' => "Épicéa sec en sacs de 40kg, format 25cm. Résineux de qualité pour allumage et chauffage d'appoint. Combustion vive avec bonne montée en température. Parfum agréable de résine.",
                'short_description' => 'Épicéa 25cm, combustion vive et parfumée',
                'wood_type' => 'epicea',
                'usage_type' => 'chauffage',
                'humidity_rate' => 21.5,
                'conditioning' => 'sacs_40kg',
                'unit_type' => 'sac',
                'price_per_unit' => 5.50,
                'stock_quantity' => 90,
                'min_order_quantity' => 4,
                'alert_stock_level' => 18,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== BOULEAU ========
            [
                'name' => 'Bouleau 30cm - Palette Premium',
                'slug' => 'bouleau-30cm-palette-premium',
                'description' => "Bouleau premium en palette, format 30cm. Écorce blanche caractéristique. Excellent bois de transition entre résineux et feuillus. Combustion régulière avec belles flammes dorées.",
                'short_description' => 'Bouleau premium, belles flammes dorées',
                'wood_type' => 'bouleau',
                'usage_type' => 'chauffage',
                'humidity_rate' => 19.8,
                'conditioning' => 'palettes',
                'unit_type' => 'palette',
                'price_per_unit' => 82.00,
                'professional_price' => 76.00,
                'stock_quantity' => 25,
                'min_order_quantity' => 1,
                'alert_stock_level' => 5,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],
            [
                'name' => 'Bouleau 25cm - Sacs 25kg',
                'slug' => 'bouleau-25cm-sacs-25kg',
                'description' => "Bouleau en sacs de 25kg, format 25cm. Bois blanc aux propriétés intéressantes. Combustion propre et régulière. Excellent pour les poêles modernes. Peu de cendres.",
                'short_description' => 'Bouleau blanc, combustion propre',
                'wood_type' => 'bouleau',
                'usage_type' => 'chauffage',
                'humidity_rate' => 20.2,
                'conditioning' => 'sacs_25kg',
                'unit_type' => 'sac',
                'price_per_unit' => 6.80,
                'stock_quantity' => 60,
                'min_order_quantity' => 3,
                'alert_stock_level' => 12,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== MÉLANGE ========
            [
                'name' => 'Mélange Feuillus 25cm - Palette',
                'slug' => 'melange-feuillus-25cm-palette',
                'description' => "Mélange équilibré de feuillus (chêne, hêtre, charme) en bûches 25cm. Excellent rapport qualité-prix. Combustion efficace et régulière. Livré sur palette filmée (≈1,5 stère).",
                'short_description' => 'Mélange chêne/hêtre/charme 25cm',
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
            [
                'name' => 'Mélange Économique - Sacs 40kg',
                'slug' => 'melange-economique-sacs-40kg',
                'description' => "Mélange économique de différentes essences en sacs 40kg. Solution abordable pour chauffage quotidien. Composition variable selon arrivages. Bon rapport qualité-prix.",
                'short_description' => 'Mélange économique, bon rapport qualité-prix',
                'wood_type' => 'melange',
                'usage_type' => 'chauffage',
                'humidity_rate' => 22.0,
                'conditioning' => 'sacs_40kg',
                'unit_type' => 'sac',
                'price_per_unit' => 6.50,
                'stock_quantity' => 200,
                'min_order_quantity' => 5,
                'alert_stock_level' => 40,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== FRÊNE ========
            [
                'name' => 'Frêne 30cm - Stère Premium',
                'slug' => 'fresne-30cm-stere-premium',
                'description' => "Frêne premium en stère, format 30cm. Bois noble avec excellent pouvoir calorifique. Combustion vive et régulière. Parfait pour chauffage principal. Bois clair aux veines marquées.",
                'short_description' => 'Frêne premium, combustion vive',
                'wood_type' => 'fresne',
                'usage_type' => 'chauffage',
                'humidity_rate' => 18.2,
                'conditioning' => 'steres',
                'unit_type' => 'stere',
                'price_per_unit' => 82.00,
                'professional_price' => 75.00,
                'stock_quantity' => 18,
                'min_order_quantity' => 1,
                'alert_stock_level' => 3,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== ACACIA ========
            [
                'name' => 'Acacia 25cm - Palette',
                'slug' => 'acacia-25cm-palette',
                'description' => "Acacia en palette, format 25cm. Bois très dense avec pouvoir calorifique élevé. Combustion lente et braises durables. Excellent pour chauffage de longue durée. Résistant naturellement.",
                'short_description' => 'Acacia très dense, braises durables',
                'wood_type' => 'acacia',
                'usage_type' => 'chauffage',
                'humidity_rate' => 17.5,
                'conditioning' => 'palettes',
                'unit_type' => 'palette',
                'price_per_unit' => 125.00,
                'professional_price' => 115.00,
                'stock_quantity' => 12,
                'min_order_quantity' => 1,
                'alert_stock_level' => 3,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== CHÂTAIGNIER ========
            [
                'name' => 'Châtaignier 30cm - Sacs 40kg',
                'slug' => 'chataignier-30cm-sacs-40kg',
                'description' => "Châtaignier en sacs de 40kg, format 30cm. Bois de caractère avec tanins naturels. Combustion vive avec crépitements. Parfait pour ambiance chaleureuse. Résistant à l'humidité.",
                'short_description' => 'Châtaignier de caractère, combustion vive',
                'wood_type' => 'chataignier',
                'usage_type' => 'chauffage',
                'humidity_rate' => 19.0,
                'conditioning' => 'sacs_40kg',
                'unit_type' => 'sac',
                'price_per_unit' => 7.80,
                'stock_quantity' => 70,
                'min_order_quantity' => 4,
                'alert_stock_level' => 15,
                'category_id' => $chauffageCategory->id,
                'status' => 'active'
            ],

            // ======== POMMIER ========
            [
                'name' => 'Pommier Cuisson - Sacs 25kg',
                'slug' => 'pommier-cuisson-sacs-25kg',
                'description' => "Pommier pur pour cuisson, en sacs de 25kg. Arôme fruité délicat pour vos grillades. Combustion douce et régulière. Idéal pour viandes blanches et poissons. Bois fruitier noble.",
                'short_description' => 'Pommier pur, arôme fruité délicat',
                'wood_type' => 'pommier',
                'usage_type' => 'cuisson',
                'humidity_rate' => 16.0,
                'conditioning' => 'sacs_25kg',
                'unit_type' => 'sac',
                'price_per_unit' => 15.90,
                'stock_quantity' => 40,
                'min_order_quantity' => 2,
                'alert_stock_level' => 8,
                'category_id' => $cuissonCategory->id,
                'status' => 'active'
            ],

            // ======== CERISIER ========
            [
                'name' => 'Cerisier Fumage - Sacs 25kg',
                'slug' => 'cerisier-fumage-sacs-25kg',
                'description' => "Cerisier spécial fumage en sacs de 25kg. Arôme subtil et délicat pour fumage à froid et à chaud. Donne une couleur dorée aux aliments. Très apprécié des chefs cuisiniers.",
                'short_description' => 'Cerisier fumage, arôme subtil et délicat',
                'wood_type' => 'cerisier',
                'usage_type' => 'cuisson',
                'humidity_rate' => 15.5,
                'conditioning' => 'sacs_25kg',
                'unit_type' => 'sac',
                'price_per_unit' => 18.90,
                'stock_quantity' => 30,
                'min_order_quantity' => 1,
                'alert_stock_level' => 6,
                'category_id' => $cuissonCategory->id,
                'status' => 'active'
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);
            
            // Ajouter image d'exemple
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => '/storage/images/products/' . $product->slug . '-1.jpg',
                'alt_text' => $product->name . ' - Image principale',
                'sort_order' => 1,
                'is_primary' => true
            ]);
        }
    }
}