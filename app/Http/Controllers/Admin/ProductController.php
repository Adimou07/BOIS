<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images']);
        
        // Recherche par nom ou description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('short_description', 'LIKE', "%{$search}%");
            });
        }
        
        // Filtre par essence de bois
        if ($request->filled('wood_type')) {
            $query->where('wood_type', $request->wood_type);
        }
        
        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Tri par défaut
        $query->orderBy('created_at', 'desc');
        
        $products = $query->paginate(20)->withQueryString();
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'wood_type' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price_per_unit' => 'required|numeric|min:0',
            'professional_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'conditioning' => 'required|string',
            'usage_type' => 'required|string',
            'description' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        // Préparer les données en gérant les valeurs nulles
        $data = $request->except('images');
        
        // Gérer les champs optionnels qui ne peuvent pas être null
        if (empty($data['description'])) {
            $data['description'] = '';
        }
        if (empty($data['professional_price'])) {
            $data['professional_price'] = null;
        }
        
        // Définir le statut par défaut comme 'active' pour que le produit soit visible
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }
        
        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_url' => 'storage/' . $path,
                    'alt_text' => $product->name,
                    'sort_order' => $index,
                    'is_primary' => $index === 0
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès !');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Validation plus souple pour les mises à jour
        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'wood_type' => 'sometimes|required|string',
            'category_id' => 'sometimes|required|exists:categories,id',
            'price_per_unit' => 'sometimes|required|numeric|min:0',
            'professional_price' => 'sometimes|nullable|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'min_order_quantity' => 'sometimes|required|integer|min:1',
            'conditioning' => 'sometimes|required|string',
            'usage_type' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ];

        // Si c'est juste une mise à jour d'images, on ne valide que les images
        if ($request->hasFile('new_images') || $request->has('remove_images')) {
            if (!$request->has('name') && !$request->has('wood_type')) {
                $rules = [
                    'new_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
                ];
            }
        }

        $request->validate($rules);

        // Ne mettre à jour que les champs présents dans la requête
        $dataToUpdate = $request->except(['new_images', 'remove_images', '_token', '_method']);
        
        // Nettoyer les données vides pour éviter d'écraser avec des valeurs nulles
        $dataToUpdate = array_filter($dataToUpdate, function($value) {
            return $value !== null && $value !== '';
        });

        if (!empty($dataToUpdate)) {
            $product->update($dataToUpdate);
        }

        // Supprimer les images sélectionnées
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = $product->images()->find($imageId);
                if ($image) {
                    // Extraire le chemin du fichier depuis l'URL
                    $parsedUrl = parse_url($image->image_url);
                    $path = $parsedUrl['path'] ?? '';
                    
                    // Supprimer '/storage/' du début pour avoir le chemin relatif
                    if (str_starts_with($path, '/storage/')) {
                        $relativePath = substr($path, strlen('/storage/'));
                        Storage::disk('public')->delete($relativePath);
                    }
                    
                    $image->delete();
                }
            }
        }

        // Ajouter nouvelles images
        if ($request->hasFile('new_images')) {
            $maxOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('new_images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_url' => 'storage/' . $path,
                    'alt_text' => $product->name,
                    'sort_order' => $maxOrder + $index + 1,
                    'is_primary' => $maxOrder === 0 && $index === 0
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroy(Product $product)
    {
        // Supprimer les images
        foreach ($product->images as $image) {
            // Extraire le chemin du fichier depuis l'URL
            $parsedUrl = parse_url($image->image_url);
            $path = $parsedUrl['path'] ?? '';
            
            // Supprimer '/storage/' du début pour avoir le chemin relatif
            if (str_starts_with($path, '/storage/')) {
                $relativePath = substr($path, strlen('/storage/'));
                Storage::disk('public')->delete($relativePath);
            }
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès !');
    }
}