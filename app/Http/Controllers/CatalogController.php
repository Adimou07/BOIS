<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    /**
     * Display the product catalog
     */
    public function index(Request $request): View
    {
        $query = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock();

        // Filtres par catégorie
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filtres par essence de bois
        if ($request->filled('wood_type')) {
            $query->byWoodType($request->wood_type);
        }

        // Filtres par usage
        if ($request->filled('usage_type')) {
            $query->byUsage($request->usage_type);
        }

        // Filtre par conditionnement
        if ($request->filled('conditioning')) {
            $query->where('conditioning', $request->conditioning);
        }

        // Filtre par prix
        if ($request->filled('price_min')) {
            $query->where('price_per_unit', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price_per_unit', '<=', $request->price_max);
        }

        // Filtre professionnel uniquement
        $user = auth()->user();
        if (!$user || !$user->isProfessional()) {
            $query->where('is_professional_only', false);
        }

        // Tri
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        
        switch ($sortBy) {
            case 'price':
                $query->orderBy('price_per_unit', $sortOrder);
                break;
            case 'stock':
                $query->orderBy('stock_quantity', $sortOrder);
                break;
            default:
                $query->orderBy('name', $sortOrder);
        }

        $products = $query->paginate(12)->withQueryString();

        // Données pour les filtres
        $categories = Category::active()->ordered()->get();
        $woodTypes = Product::WOOD_TYPES;
        $usageTypes = Product::USAGE_TYPES;
        $conditioningTypes = Product::CONDITIONING_TYPES;

        return view('catalog.index', compact(
            'products', 
            'categories', 
            'woodTypes', 
            'usageTypes', 
            'conditioningTypes'
        ));
    }

    /**
     * Display a specific product
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'images']);
        
        // Produits similaires
        $relatedProducts = Product::active()
            ->inStock()
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('wood_type', $product->wood_type)
                      ->orWhere('category_id', $product->category_id);
            })
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products
     */
    public function search(Request $request): View
    {
        $query = $request->get('q');
        
        $products = Product::active()
            ->inStock()
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('wood_type', 'LIKE', "%{$query}%");
            })
            ->paginate(12)
            ->withQueryString();

        return view('catalog.search', compact('products', 'query'));
    }
}