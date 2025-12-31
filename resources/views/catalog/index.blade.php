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
            <!-- Barre de recherche en temps réel -->
            <div class="mb-6">
                <div class="relative">
                    <input type="text" 
                           id="realTimeSearch" 
                           placeholder="Tapez pour filtrer en temps réel (ex: Acacia, chêne, 20cm...)"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500 focus:border-transparent shadow-sm">
                    <button id="clearRealTimeSearch" 
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="searchStats" class="text-sm text-green-600 font-medium mt-2"></div>
            </div>

            <!-- Tri et résultats -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                @php
                    $hasFilters = request()->hasAny(['category', 'wood_type', 'q']);
                @endphp
                @if($hasFilters)
                    <p class="text-sm text-gray-700 mb-4 sm:mb-0">
                        {{ $products->total() }} produit(s) trouvé(s)
                    </p>
                @else
                    <div class="mb-4 sm:mb-0"></div>
                @endif
                
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
                <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="product-card bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow"
                             data-name="{{ strtolower($product->name) }}" 
                             data-wood="{{ strtolower(str_replace('_', ' ', $product->wood_type)) }}" 
                             data-usage="{{ strtolower($product->usage_type) }}"
                             data-description="{{ strtolower($product->description ?? '') }}"
                             data-search="{{ strtolower($product->name . ' ' . str_replace('_', ' ', $product->wood_type) . ' ' . $product->usage_type . ' ' . ($product->description ?? '')) }}">
                            <!-- Image -->
                            <div class="relative">
                                @if($product->images && $product->images->first())
                                    <img src="{{ asset($product->images->first()->image_url) }}" 
                                         alt="{{ $product->images->first()->alt_text ?? $product->name }}"
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
                                    
                                    <a href="/produit/{{ $product->slug }}" 
                                       class="bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition-colors text-sm">
                                        Voir détails
                                    </a>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('realTimeSearch');
    const clearButton = document.getElementById('clearRealTimeSearch');
    const searchStats = document.getElementById('searchStats');
    const productCards = document.querySelectorAll('.product-card');
    const productsGrid = document.getElementById('productsGrid');
    
    // Fonction pour supprimer les accents
    function removeAccents(str) {
        return str.normalize('NFD')
                 .replace(/[\u0300-\u036f]/g, '')
                 .toLowerCase();
    }
    
    // Fonction de filtrage en temps réel
    function filterProducts(searchTerm) {
        searchTerm = removeAccents(searchTerm.toLowerCase().trim());
        let visibleCount = 0;
        
        productCards.forEach(card => {
            const searchData = removeAccents(card.getAttribute('data-search'));
            
            if (searchTerm === '' || searchData.includes(searchTerm)) {
                card.style.display = 'block';
                card.classList.remove('hidden');
                visibleCount++;
                
                // Mettre en évidence le texte trouvé
                if (searchTerm !== '') {
                    highlightText(card, searchTerm);
                } else {
                    removeHighlight(card);
                }
            } else {
                card.style.display = 'none';
                card.classList.add('hidden');
            }
        });
        
        // Afficher les statistiques
        if (searchTerm === '') {
            searchStats.textContent = '';
            clearButton.classList.add('hidden');
        } else {
            searchStats.innerHTML = `<span class="text-green-600 font-medium">${visibleCount} produit(s) trouvé(s) pour "${searchTerm}"</span>`;
            clearButton.classList.remove('hidden');
            
            // Message si aucun résultat
            if (visibleCount === 0) {
                searchStats.innerHTML = `<span class="text-red-600">Aucun produit trouvé pour "${searchTerm}". Essayez "chêne", "hêtre", "acacia", "20cm", etc.</span>`;
            }
        }
        
        // Animation smooth
        productsGrid.style.opacity = '0.7';
        setTimeout(() => {
            productsGrid.style.opacity = '1';
        }, 100);
    }
    
    // Fonction pour mettre en évidence le texte
    function highlightText(card, searchTerm) {
        const titleElement = card.querySelector('h3');
        if (titleElement) {
            const originalText = titleElement.textContent;
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            titleElement.innerHTML = originalText.replace(regex, '<mark class="bg-yellow-200 px-1 rounded">$1</mark>');
        }
    }
    
    // Fonction pour supprimer la mise en évidence
    function removeHighlight(card) {
        const titleElement = card.querySelector('h3');
        if (titleElement) {
            const text = titleElement.textContent; // Récupère le texte sans HTML
            titleElement.textContent = text; // Remet le texte propre
        }
    }
    
    // Écouter les frappes de touches avec délai
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterProducts(this.value);
        }, 150); // Délai de 150ms pour éviter trop d'appels
    });
    
    // Bouton de suppression
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        filterProducts('');
        searchInput.focus();
    });
    
    // Focus automatique si on tape n'importe où
    document.addEventListener('keydown', function(e) {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA' && !e.ctrlKey && !e.altKey) {
            if (e.key.length === 1) {
                searchInput.focus();
                searchInput.value = e.key;
                filterProducts(e.key);
            }
        }
    });
});
</script>

@endsection