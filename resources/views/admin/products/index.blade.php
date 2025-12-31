<x-admin-layout title="Gestion des Produits">
    <div class="mb-6">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Produits 
                    <span class="text-lg text-gray-500 font-normal">({{ $products->total() }} total)</span>
                </h2>
                <p class="text-gray-600">Gérez vos produits de bois de chauffage</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition-colors">
                Nouveau produit
            </a>
        </div>
        
        <!-- Barre de recherche et filtres -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Nom, essence, description..." 
                                   class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filtre par essence -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Essence</label>
                        <select name="wood_type" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Toutes les essences</option>
                            @foreach(['chene', 'hetre', 'charme', 'fruitiers', 'frene', 'erable', 'bouleau', 'chataignier', 'aulne', 'tilleul', 'peuplier', 'acacia', 'melange_dur', 'melange_tendre'] as $wood)
                                <option value="{{ $wood }}" {{ request('wood_type') === $wood ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $wood)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Filtre par statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded-md text-sm hover:bg-amber-700 transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Rechercher
                        </button>
                        
                        @if(request()->hasAny(['search', 'wood_type', 'status']))
                            <a href="{{ route('admin.products.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-400 transition-colors">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Réinitialiser
                            </a>
                        @endif
                    </div>
                    
                    @if(request()->hasAny(['search', 'wood_type', 'status']))
                        <div class="bg-blue-50 border border-blue-200 rounded-md px-3 py-2">
                            <span class="text-sm text-blue-700 font-medium">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $products->total() }} résultat(s) trouvé(s)
                            </span>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des produits -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Essence</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <!-- Image -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->images->first())
                                <img src="{{ $product->images->first()->image_url }}" 
                                     alt="{{ $product->images->first()->alt_text ?? $product->name }}" 
                                     class="w-12 h-12 rounded-lg object-cover">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        
                        <!-- Produit -->
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            <div class="text-sm text-gray-500">{{ $product->category->name ?? 'Aucune catégorie' }}</div>
                        </td>
                        
                        <!-- Essence -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                {{ ucfirst($product->wood_type) }}
                            </span>
                        </td>
                        
                        <!-- Prix -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                <div>Part.: {{ number_format($product->price_per_unit, 2) }} €</div>
                                <div>Pro: {{ number_format($product->professional_price ?? $product->price_per_unit, 2) }} €</div>
                            </div>
                        </td>
                        
                        <!-- Stock -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $product->stock_quantity }} {{ $product->conditioning }}</div>
                            @if($product->stock_quantity <= $product->alert_stock_level)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Stock faible
                                </span>
                            @endif
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="text-blue-600 hover:text-blue-900">Voir</a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-amber-600 hover:text-amber-900">Modifier</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Aucun produit trouvé. 
                            <a href="{{ route('admin.products.create') }}" class="text-amber-600 hover:text-amber-500">
                                Créez votre premier produit
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
    @endif
</x-admin-layout>