<x-admin-layout title="Détails du produit">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <!-- En-tête avec actions -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $product->slug }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.edit', $product) }}" class="bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-amber-700 transition-colors">
                        Modifier
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-700 transition-colors">
                        Retour à la liste
                    </a>
                </div>
            </div>

            <!-- Statut -->
            <div class="mb-6">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($product->status === 'active') bg-green-100 text-green-800
                    @elseif($product->status === 'draft') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($product->status) }}
                </span>
            </div>

            <!-- Informations principales -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Colonne gauche -->
                <div class="space-y-6">
                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700">{{ $product->description }}</p>
                        @if($product->short_description)
                            <p class="mt-2 text-sm text-gray-600"><strong>Description courte:</strong> {{ $product->short_description }}</p>
                        @endif
                    </div>

                    <!-- Caractéristiques bois -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Caractéristiques</h3>
                        <dl class="space-y-2">
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Essence:</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $product->wood_type)) }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Usage:</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $product->usage_type)) }}</dd>
                            </div>
                            @if($product->humidity_rate)
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Humidité:</dt>
                                <dd class="text-sm text-gray-900">{{ $product->humidity_rate }}%</dd>
                            </div>
                            @endif
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Conditionnement:</dt>
                                <dd class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $product->conditioning)) }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Unité:</dt>
                                <dd class="text-sm text-gray-900">{{ $product->unit_type }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Catégorie</h3>
                        <p class="text-gray-700">{{ $product->category->name ?? 'Non définie' }}</p>
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="space-y-6">
                    <!-- Prix et stock -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Prix et stock</h3>
                        <dl class="space-y-2">
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Prix public:</dt>
                                <dd class="text-sm text-gray-900 font-semibold">{{ number_format($product->price_per_unit, 2) }} €</dd>
                            </div>
                            @if($product->professional_price)
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Prix pro:</dt>
                                <dd class="text-sm text-gray-900 font-semibold">{{ number_format($product->professional_price, 2) }} €</dd>
                            </div>
                            @endif
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Stock:</dt>
                                <dd class="text-sm text-gray-900 
                                    @if($product->stock_quantity <= $product->alert_stock_level) text-red-600 font-semibold @endif">
                                    {{ $product->stock_quantity }} {{ $product->unit_type }}(s)
                                    @if($product->stock_quantity <= $product->alert_stock_level)
                                        <span class="text-red-500 text-xs">(Stock faible!)</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Commande min:</dt>
                                <dd class="text-sm text-gray-900">{{ $product->min_order_quantity }} {{ $product->unit_type }}(s)</dd>
                            </div>
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Alerte stock:</dt>
                                <dd class="text-sm text-gray-900">{{ $product->alert_stock_level }} {{ $product->unit_type }}(s)</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Options -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Options</h3>
                        <dl class="space-y-2">
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Réservé aux pros:</dt>
                                <dd class="text-sm text-gray-900">{{ $product->is_professional_only ? 'Oui' : 'Non' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- SEO -->
                    @if($product->seo_title || $product->meta_description)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">SEO</h3>
                        <dl class="space-y-2">
                            @if($product->seo_title)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Titre SEO:</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $product->seo_title }}</dd>
                            </div>
                            @endif
                            @if($product->meta_description)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Meta description:</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $product->meta_description }}</dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                    @endif

                    <!-- Dates -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Informations système</h3>
                        <dl class="space-y-2">
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Créé le:</dt>
                                <dd class="text-sm text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div class="flex">
                                <dt class="text-sm font-medium text-gray-500 w-32">Modifié le:</dt>
                                <dd class="text-sm text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Images (si disponibles) -->
            @if($product->images && $product->images->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Images</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden">
                            <img src="{{ $image->full_image_url }}" alt="{{ $image->alt_text }}" class="w-full h-full object-center object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Actions en bas -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                <a href="{{ route('catalog.show', $product) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                    Voir sur le site public
                </a>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.edit', $product) }}" class="bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-amber-700 transition-colors">
                        Modifier ce produit
                    </a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>