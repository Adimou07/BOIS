@extends('layouts.app')

@section('title', 'Finaliser ma commande')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Finaliser ma commande</h1>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ route('catalog.index') }}" class="text-gray-500 hover:text-gray-700">Catalogue</a></li>
                <li><span class="text-gray-400 mx-1">/</span></li>
                <li><a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-gray-700">Panier</a></li>
                <li><span class="text-gray-400 mx-1">/</span></li>
                <li class="text-gray-900 font-medium">Commande</li>
            </ol>
        </nav>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" class="space-y-8">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Section -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-truck text-blue-500 mr-2"></i>Adresse de livraison
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet *</label>
                            <input type="text" name="shipping_name" id="shipping_name" 
                                value="{{ old('shipping_name', $user->name) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('shipping_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                            <input type="text" name="shipping_address" id="shipping_address" 
                                value="{{ old('shipping_address') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('shipping_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                            <input type="text" name="shipping_city" id="shipping_city" 
                                value="{{ old('shipping_city') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('shipping_city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Code postal *</label>
                            <input type="text" name="shipping_postal_code" id="shipping_postal_code" 
                                value="{{ old('shipping_postal_code') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            @error('shipping_postal_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Billing Address -->
                <div class="bg-white rounded-lg shadow p-6" x-data="{ sameBilling: true }">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-file-invoice text-green-500 mr-2"></i>Adresse de facturation
                    </h3>
                    
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="billing_same_as_shipping" value="1" 
                                x-model="sameBilling" checked
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Identique à l'adresse de livraison</span>
                        </label>
                    </div>
                    
                    <div x-show="!sameBilling" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label for="billing_name" class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" name="billing_name" id="billing_name" 
                                value="{{ old('billing_name') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('billing_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="md:col-span-2">
                            <label for="billing_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                            <input type="text" name="billing_address" id="billing_address" 
                                value="{{ old('billing_address') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('billing_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                            <input type="text" name="billing_city" id="billing_city" 
                                value="{{ old('billing_city') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('billing_city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="billing_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                            <input type="text" name="billing_postal_code" id="billing_postal_code" 
                                value="{{ old('billing_postal_code') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('billing_postal_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-comment text-gray-500 mr-2"></i>Commentaires (optionnel)
                    </h3>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Instructions de livraison ou commentaires</label>
                        <textarea name="notes" id="notes" rows="3" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Informations particulières pour la livraison...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Récapitulatif de commande</h3>
                    
                    <!-- Cart Items -->
                    <div class="space-y-3 mb-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-3 pb-3 border-b border-gray-200">
                                @if($item->product->primaryImage)
                                    <img src="{{ $item->product->primaryImage->image_url }}" 
                                        alt="{{ $item->product->name }}" 
                                        class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">
                                        {{ $item->product->name }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        Quantité: {{ $item->quantity }}
                                    </p>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ number_format($item->product->getPriceForUser($user && $user->type === 'professional') * $item->quantity, 2, ',', ' ') }} €
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Totals -->
                    <div class="space-y-2 pt-4 border-t border-gray-200">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Sous-total</span>
                            <span>{{ number_format($subtotal, 2, ',', ' ') }} €</span>
                        </div>
                        
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Livraison</span>
                            <span class="text-green-600">À calculer</span>
                        </div>
                        
                        <div class="flex justify-between text-base font-semibold text-gray-900 pt-2 border-t border-gray-200">
                            <span>Total</span>
                            <span>{{ number_format($subtotal, 2, ',', ' ') }} € + livraison</span>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full mt-6 bg-blue-600 text-white py-3 px-4 rounded-md font-medium hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-shopping-cart mr-2"></i>Confirmer ma commande
                    </button>
                    
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        En confirmant votre commande, vous acceptez nos conditions générales de vente.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection