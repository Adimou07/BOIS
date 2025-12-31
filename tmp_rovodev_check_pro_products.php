<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== PRODUITS AVEC MENTIONS PRO ===\n\n";

$proProducts = \App\Models\Product::where('name', 'like', '%Pro%')
    ->orWhere('name', 'like', '%Restaurant%')
    ->orWhere('name', 'like', '%Premium%')
    ->get();

echo "Nombre total: " . $proProducts->count() . "\n\n";

foreach ($proProducts as $product) {
    echo "- " . $product->name . "\n";
    echo "  → Essence: " . $product->wood_type . "\n";
    echo "  → Pro uniquement: " . ($product->is_professional_only ? 'OUI' : 'NON') . "\n\n";
}