@extends('layouts.app')

@section('title', $product->seo_title ?: $product->name . ' - WoodShop')
@section('meta_description', $product->meta_description ?: $product->short_description)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center space-x-4">
            <li>
                <div>
                    <a href="{{ route('catalog.index') }}" class="text-gray-400 hover:text-gray-500">
                        Catalogue
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="ml-4 text-gray-400 hover:text-gray-500">
                        {{ $product->category->name }}
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-4 text-gray-500" aria-current="page">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
        <!-- Galerie d'images -->
        <div class="flex flex-col-reverse">
            <!-- Thumbnails -->
            @if($product->images->count() > 1)
            <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                <div class="grid grid-cols-4 gap-6">
                    @foreach($product->images as $image)
                    <div class="relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-offset-4 focus:ring-amber-500">
                        <img src="{{ $image->image_url }}" alt="{{ $image->alt_text }}" class="w-full h-full object-center object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Main image -->
            <div class="w-full aspect-w-1 aspect-h-1">
                @if($product->primaryImage)
                    <img src="{{ $product->primaryImage->image_url }}" 
                         alt="{{ $product->primaryImage->alt_text }}" 
                         class="w-full h-full object-center object-cover sm:rounded-lg">
                @else
                    <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informations produit -->
        <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $product->name }}</h1>
            
            <!-- Prix -->
            <div class="mt-3">
                <p class="text-3xl tracking-tight text-amber-600 font-bold">
                    {{ number_format($product->getPriceForUser(auth()->user()?->isProfessional()), 2) }}€
                </p>
                <p class="text-sm text-gray-500">par {{ $product->unit_type }}</p>
                
                @if($product->professional_price && auth()->user()?->isProfessional())
                    <p class="text-sm text-green-600 font-medium mt-1">Prix professionnel appliqué</p>
                @endif
            </div>

            <!-- Badges -->
            <div class="mt-4 flex flex-wrap gap-2">
                @if($product->isLowStock())
                    <span class="badge badge-warning">Stock limité ({{ $product->stock_quantity }})</span>
                @else
                    <span class="badge badge-success">En stock ({{ $product->stock_quantity }})</span>
                @endif
                
                @if($product->is_professional_only)
                    <span class="badge badge-info">Réservé aux professionnels</span>
                @endif
            </div>

            <!-- Caractéristiques -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900">Caractéristiques</h3>
                <div class="mt-4 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Essence de bois</span>
                        <span class="text-sm text-gray-900">{{ $product->getWoodTypeLabel() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Usage</span>
                        <span class="text-sm text-gray-900">{{ $product->getUsageTypeLabel() }}</span>
                    </div>
                    @if($product->humidity_rate)
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Taux d'humidité</span>
                        <span class="text-sm text-gray-900">{{ $product->humidity_rate }}%</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Conditionnement</span>
                        <span class="text-sm text-gray-900">{{ \App\Models\Product::CONDITIONING_TYPES[$product->conditioning] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-500">Quantité minimum</span>
                        <span class="text-sm text-gray-900">{{ $product->min_order_quantity }} {{ $product->unit_type }}(s)</span>
                    </div>
                </div>
            </div>

            <!-- Calculateur de quantité -->
            <div class="mt-8" x-data="cartComponent({{ $product->min_order_quantity }}, {{ $product->getPriceForUser(auth()->user()?->isProfessional()) }}, '{{ route('cart.add', $product) }}', '{{ route('cart.count') }}')">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Commande</h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Quantité</label>
                        <div class="mt-1 flex items-center space-x-3">
                            <button type="button" @click="quantity = Math.max({{ $product->min_order_quantity }}, quantity - 1); total = quantity * {{ $product->getPriceForUser(auth()->user()?->isProfessional()) }}" 
                                    class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50">
                                -
                            </button>
                            <input type="number" 
                                   x-model="quantity"
                                   @input="total = quantity * {{ $product->getPriceForUser(auth()->user()?->isProfessional()) }}"
                                   min="{{ $product->min_order_quantity }}" 
                                   max="{{ $product->stock_quantity }}"
                                   class="w-20 text-center border border-gray-300 rounded-md px-3 py-2">
                            <button type="button" @click="quantity = Math.min({{ $product->stock_quantity }}, quantity + 1); total = quantity * {{ $product->getPriceForUser(auth()->user()?->isProfessional()) }}" 
                                    class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50">
                                +
                            </button>
                            <span class="text-sm text-gray-500">{{ $product->unit_type }}(s)</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Minimum: {{ $product->min_order_quantity }}</p>
                    </div>
                    
                    <div class="bg-amber-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-amber-600" x-text="total.toFixed(2) + '€'"></span>
                        </div>
                    </div>
                    
                    <button type="button" 
                            @click="addToCart()"
                            :disabled="adding || quantity < {{ $product->min_order_quantity }} || quantity > {{ $product->stock_quantity }}"
                            class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition-colors disabled:bg-gray-300 disabled:cursor-not-allowed">
                        <span x-show="!adding">Ajouter au panier</span>
                        <span x-show="adding" class="flex items-center justify-center">
                            <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="m15.84 12.48-1.84-1.84.84-.84 2.68 2.68-2.68 2.68-.84-.84z"></path>
                            </svg>
                            Ajout en cours...
                        </span>
                    </button>
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900">Description</h3>
                <div class="mt-4 prose prose-sm text-gray-600">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Produits similaires -->
    @if($relatedProducts->count() > 0)
    <div class="mt-16">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Produits similaires</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                <div class="relative h-48">
                    @if($relatedProduct->primaryImage)
                        <img src="{{ $relatedProduct->primaryImage->image_url }}" 
                             alt="{{ $relatedProduct->primaryImage->alt_text }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                    <p class="text-lg font-bold text-amber-600">
                        {{ number_format($relatedProduct->getPriceForUser(auth()->user()?->isProfessional()), 2) }}€
                        <span class="text-xs text-gray-500">/ {{ $relatedProduct->unit_type }}</span>
                    </p>
                    <a href="{{ route('catalog.show', $relatedProduct) }}" 
                       class="mt-3 block text-center bg-amber-600 text-white py-2 px-4 rounded-md hover:bg-amber-700 transition-colors text-sm">
                        Voir détails
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection