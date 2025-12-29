@extends('layouts.app')

@section('title', 'Catalogue - Bois de chauffage et cuisson')
@section('meta_description', 'Découvrez notre large sélection de bois de chauffage et cuisson : chêne, hêtre, charme. Livraison rapide partout en France.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Notre Catalogue de Bois</h1>
        <p class="text-gray-600">Bois de chauffage et cuisson de qualité premium, séché et livré chez vous</p>
    </div>

    <div class="lg:grid lg:grid-cols-4 lg:gap-8">
        <!-- Filtres Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4" x-data="{ filtersOpen: false }">
                <div class="flex items-center justify-between lg:hidden mb-4">
                    <h2 class="text-lg font-semibold">Filtres</h2>
                    <button @click="filtersOpen = !filtersOpen" class="text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <form method="GET" action="{{ route('catalog.index') }}" x-show="filtersOpen || window.innerWidth >= 1024">
                    <!-- Catégories -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Catégories</h3>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="category" value="" 
                                       {{ !request('category') ? 'checked' : '' }}
                                       class="text-amber-600 focus:ring-amber-500">
                                <span class="ml-2 text-sm text-gray-700">Tous</span>
                            </label>
                            @foreach($categories as $category)
                            <label class="flex items-center">
                                <input type="radio" name="category" value="{{ $category->slug }}" 
                                       {{ request('category') === $category->slug ? 'checked' : '' }}
                                       class="text-amber-600 focus:ring-amber-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Essence de bois -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Essence de bois</h3>
                        <select name="wood_type" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Toutes les essences</option>
                            @foreach($woodTypes as $key => $label)
                            <option value="{{ $key }}" {{ request('wood_type') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type d'usage -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Usage</h3>
                        <select name="usage_type" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Tous usages</option>
                            @foreach($usageTypes as $key => $label)
                            <option value="{{ $key }}" {{ request('usage_type') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Conditionnement -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Conditionnement</h3>
                        <select name="conditioning" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Tous conditionnements</option>
                            @foreach($conditioningTypes as $key => $label)
                            <option value="{{ $key }}" {{ request('conditioning') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Prix -->
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Prix (€)</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="price_min" value="{{ request('price_min') }}" 
                                   placeholder="Min" step="0.01"
                                   class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                            <input type="number" name="price_max" value="{{ request('price_max') }}" 
                                   placeholder="Max" step="0.01"
                                   class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="space-y-2">
                        <button type="submit" class="w-full bg-amber-600 text-white py-2 px-4 rounded-md hover:bg-amber-700 transition-colors">
                            Appliquer les filtres
                        </button>
                        <a href="{{ route('catalog.index') }}" class="block w-full text-center border border-gray-300 py-2 px-4 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="lg:col-span-3 mt-8 lg:mt-0">
            <!-- Tri et résultats -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <p class="text-sm text-gray-700 mb-4 sm:mb-0">
                    {{ $products->total() }} produit(s) trouvé(s)
                </p>
                
                <form method="GET" action="{{ route('catalog.index') }}" class="flex items-center space-x-2">
                    @foreach(request()->except(['sort', 'order']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <select name="sort" onchange="this.form.submit()" 
                            class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nom A-Z</option>
                        <option value="price" {{ request('sort') === 'price' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="stock" {{ request('sort') === 'stock' ? 'selected' : '' }}>Stock</option>
                    </select>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                                
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
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty state -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m0 0l2-2m0 0l2 2" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun produit trouvé</h3>
                    <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection