<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Bois de Chauffage',
                'slug' => 'bois-de-chauffage',
                'description' => 'Bois sec et de qualité pour votre cheminée, poêle ou insert',
                'seo_title' => 'Bois de Chauffage Sec - Livraison Rapide',
                'meta_description' => 'Achetez votre bois de chauffage sec en ligne. Chêne, hêtre, charme. Livraison rapide partout en France.',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Bois de Cuisson',
                'slug' => 'bois-de-cuisson',
                'description' => 'Bois spécialement sélectionné pour barbecue, four à pizza et cuisine au feu de bois',
                'seo_title' => 'Bois de Cuisson - Barbecue et Four à Pizza',
                'meta_description' => 'Bois de cuisson premium pour barbecue et four à pizza. Essences fruitières et chêne. Goût authentique garanti.',
                'is_active' => true,
                'sort_order' => 2
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::create($categoryData);
        }
    }
}