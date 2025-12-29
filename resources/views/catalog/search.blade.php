@extends('layouts.app')

@section('title', 'Recherche: ' . $query . ' - WoodShop')
@section('meta_description', 'Résultats de recherche pour "' . $query . '" dans notre catalogue de bois de chauffage et cuisson.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <nav class="text-sm text-gray-500 mb-4">
            <a href="{{ route('catalog.index') }}" class="hover:text-amber-600">Catalogue</a>
            <span class="mx-2">›</span>
            <span>Recherche</span>
        </nav>
        
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Résultats pour "{{ $query }}"
        </h1>
        <p class="text-gray-600">{{ $products->total() }} produit(s) trouvé(s)</p>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <form method="GET" action="{{ route('catalog.search') }}" class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="q" value="{{ $query }}"
                   placeholder="Rechercher du bois (nom, essence, usage)..."
                   class="w-full pl-10 pr-20 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-lg">
            <button type="submit" 
                    class="absolute right-2 top-2 bottom-2 bg-amber-600 text-white px-6 rounded-md hover:bg-amber-700 transition-colors">
                Rechercher
            </button>
        </form>
    </div>

    @if($products->count() > 0)
        <!-- Sorting -->
        <div class="flex justify-between items-center mb-6">
            <p class="text-sm text-gray-700">
                {{ $products->firstItem() }} - {{ $products->lastItem() }} sur {{ $products->total() }} résultats
            </p>
            
            <form method="GET" action="{{ route('catalog.search') }}" class="flex items-center space-x-2">
                <input type="hidden" name="q" value="{{ $query }}">
                <label class="text-sm text-gray-600">Trier par:</label>
                <select name="sort" onchange="this.form.submit()" 
                        class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring-amber-500 focus:border-amber-500">
                    <option value="relevance" {{ !request('sort') || request('sort') === 'relevance' ? 'selected' : '' }}>Pertinence</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nom A-Z</option>
                    <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                </select>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <!-- Image -->
                    <div class="relative">
                        @if($product->primaryImage)
                            <img src="{{ $product->primaryImage->image_url }}" 
                                 alt="{{ $product->primaryImage->alt_text }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Stock badge -->
                        @if($product->isLowStock())
                            <div class="absolute top-2 left-2 bg-orange-500 text-white px-2 py-1 text-xs rounded-full">
                                Stock limité
                            </div>
                        @endif
                        
                        <!-- Professional badge -->
                        @if($product->is_professional_only)
                            <div class="absolute top-2 right-2 bg-blue-600 text-white px-2 py-1 text-xs rounded-full">
                                Pro
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">
                            {!! str_ireplace($query, '<mark class="bg-yellow-200">' . $query . '</mark>', $product->name) !!}
                        </h3>
                        
                        <div class="space-y-1 text-sm text-gray-600 mb-3">
                            <p><span class="font-medium">Essence:</span> {{ $product->getWoodTypeLabel() }}</p>
                            <p><span class="font-medium">Usage:</span> {{ $product->getUsageTypeLabel() }}</p>
                            @if($product->humidity_rate)
                                <p><span class="font-medium">Humidité:</span> {{ $product->humidity_rate }}%</p>
                            @endif
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xl font-bold text-amber-600">
                                    {{ number_format($product->getPriceForUser(auth()->user()?->isProfessional()), 2) }}€
                                </span>
                                <span class="text-sm text-gray-500">/ {{ $product->unit_type }}</span>
                            </div>
                            
                            <a href="{{ route('catalog.show', $product) }}" 
                               class="bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition-colors text-sm">
                                Voir détails
                            </a>
                        </div>
                        
                        <!-- Stock info -->
                        <div class="mt-2 text-xs text-gray-500">
                            Stock: {{ $product->stock_quantity }} {{ $product->unit_type }}(s)
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->appends(['q' => $query])->links() }}
        </div>
        
    @else
        <!-- No results -->
        <div class="text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Aucun résultat trouvé</h3>
            <p class="mt-2 text-sm text-gray-500">
                Nous n'avons trouvé aucun produit correspondant à "{{ $query }}".
            </p>
            
            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-900 mb-2">Suggestions:</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• Vérifiez l'orthographe de votre recherche</li>
                    <li>• Utilisez des mots-clés plus généraux (ex: "chêne" au lieu de "chêne sec 33cm")</li>
                    <li>• Essayez des termes alternatifs (ex: "bûches" au lieu de "bois")</li>
                </ul>
                
                <div class="mt-4">
                    <a href="{{ route('catalog.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700">
                        Voir tout le catalogue
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection