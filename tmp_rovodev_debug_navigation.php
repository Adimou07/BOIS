<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUG NAVIGATION ET COMPOSANT ===\n\n";

// 1. Vérifier le layout
$layoutPath = resource_path('views/layouts/app.blade.php');
echo "📄 Contenu du layout autour du sélecteur de langue:\n";

$content = file_get_contents($layoutPath);
$lines = explode("\n", $content);

// Trouver la ligne avec language-selector
$found = false;
foreach ($lines as $num => $line) {
    if (strpos($line, 'language-selector') !== false) {
        echo "Lignes " . ($num - 2) . " à " . ($num + 2) . ":\n";
        for ($i = max(0, $num - 2); $i <= min(count($lines) - 1, $num + 2); $i++) {
            $marker = ($i == $num) ? ">>> " : "    ";
            echo $marker . ($i + 1) . ": " . trim($lines[$i]) . "\n";
        }
        $found = true;
        break;
    }
}

if (!$found) {
    echo "❌ 'language-selector' NOT trouvé dans le layout !\n";
}

echo "\n📄 Contenu du composant language-selector:\n";
$selectorPath = resource_path('views/components/language-selector.blade.php');
$selectorContent = file_get_contents($selectorPath);
echo substr($selectorContent, 0, 300) . "...\n\n";

// 2. Vérifier AlpineJS dans le layout
echo "🔧 Vérification AlpineJS:\n";
if (strpos($content, 'alpinejs') !== false) {
    echo "   ✅ AlpineJS trouvé dans le layout\n";
} else {
    echo "   ❌ AlpineJS NOT trouvé dans le layout\n";
}

// 3. Générer un test HTML simple
echo "\n💡 SOLUTION: Ajouter un test visible dans le layout...\n";