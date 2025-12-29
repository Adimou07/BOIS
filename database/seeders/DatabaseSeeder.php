<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            DeliveryZoneSeeder::class,
        ]);

        // Créer des utilisateurs de test
        User::factory()->create([
            'name' => 'Client Particulier',
            'email' => 'client@woodshop.fr',
            'type' => 'individual',
            'is_active' => true,
        ]);

        User::factory()->create([
            'name' => 'Restaurant Le Feu de Bois',
            'email' => 'pro@restaurant.fr',
            'type' => 'professional',
            'company_name' => 'Restaurant Le Feu de Bois',
            'siret' => '12345678901234',
            'phone' => '01 23 45 67 89',
            'is_active' => true,
        ]);
    }
}
