<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use Illuminate\Database\Seeder;

class DeliveryZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Paris et petite couronne',
                'postal_codes' => [
                    '75001', '75002', '75003', '75004', '75005', '75006', '75007', '75008', 
                    '75009', '75010', '75011', '75012', '75013', '75014', '75015', '75016',
                    '75017', '75018', '75019', '75020',
                    '92001', '92002', '92003', '92004', '92007', '92009', '92012', '92014',
                    '92015', '92019', '92020', '92022', '92023', '92024', '92025', '92026',
                    '93001', '93006', '93007', '93008', '93010', '93013', '93014', '93015',
                    '94001', '94002', '94003', '94004', '94005', '94011', '94015', '94016'
                ],
                'delivery_cost' => 25.00,
                'free_delivery_threshold' => 150.00,
                'min_delivery_days' => 1,
                'max_delivery_days' => 2,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Île-de-France étendue',
                'postal_codes' => [
                    '77001', '77002', '77003', '77004', '77005', '77006', '77007', '77008',
                    '78000', '78001', '78002', '78003', '78004', '78005', '78006', '78007',
                    '91001', '91002', '91003', '91004', '91005', '91006', '91007', '91008',
                    '95001', '95002', '95003', '95004', '95005', '95006', '95007', '95008'
                ],
                'delivery_cost' => 45.00,
                'free_delivery_threshold' => 200.00,
                'min_delivery_days' => 2,
                'max_delivery_days' => 3,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Nord - Pas-de-Calais',
                'postal_codes' => [
                    '59000', '59001', '59002', '59003', '59004', '59005', '59006',
                    '62000', '62001', '62002', '62003', '62004', '62005', '62006'
                ],
                'delivery_cost' => 65.00,
                'free_delivery_threshold' => 250.00,
                'min_delivery_days' => 3,
                'max_delivery_days' => 5,
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Rhône-Alpes',
                'postal_codes' => [
                    '69000', '69001', '69002', '69003', '69004', '69005', '69006',
                    '38000', '38001', '38002', '38003', '38004', '38005', '38006',
                    '42000', '42001', '42002', '42003', '42004', '42005', '42006'
                ],
                'delivery_cost' => 75.00,
                'free_delivery_threshold' => 300.00,
                'min_delivery_days' => 4,
                'max_delivery_days' => 6,
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'PACA',
                'postal_codes' => [
                    '13000', '13001', '13002', '13003', '13004', '13005', '13006',
                    '83000', '83001', '83002', '83003', '83004', '83005', '83006',
                    '06000', '06001', '06002', '06003', '06004', '06005', '06006'
                ],
                'delivery_cost' => 85.00,
                'free_delivery_threshold' => 350.00,
                'min_delivery_days' => 5,
                'max_delivery_days' => 7,
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($zones as $zone) {
            DeliveryZone::create($zone);
        }
    }
}