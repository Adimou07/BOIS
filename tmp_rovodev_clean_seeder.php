<?php

// Script pour nettoyer le seeder et supprimer les colonnes 'length'

$seederFile = 'database/seeders/ExpandedProductSeeder.php';
$content = file_get_contents($seederFile);

// Supprimer toutes les lignes contenant 'length'
$content = preg_replace('/\s*\'length\'\s*=>\s*\d+,?\n/', '', $content);

// Sauvegarder
file_put_contents($seederFile, $content);

echo "✅ Seeder nettoyé - colonnes 'length' supprimées" . PHP_EOL;