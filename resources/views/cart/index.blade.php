@extends('layouts.app')

@section('title', 'Mon panier - WoodShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Mon panier</h1>

    @if($cartItems->count() > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
            <!-- Cart Items -->
            <div class="lg:col-span-7">
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-6 sm:px-6">
                        <div class="flow-root">
                            <ul role="list" class="-my-6 divide-y divide-gray-200">
                                @foreach($cartItems as $item)
                                <li class="flex py-6" x-data="cartItem({{ $item->id }}, {{ $item->quantity }}, {{ $item->unit_price }}, {{ $item->getTotalPrice() }})">
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                        @if($item->product->primaryImage)
                                            <img src="{{ $item->product->primaryImage->image_url }}" 
                                                 alt="{{ $item->product->primaryImage->alt_text }}" 
                                                 class="h-full w-full object-cover object-center">
                                        @else
                                            <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="ml-4 flex flex-1 flex-col">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a href="{{ route('catalog.show', $item->product) }}">{{ $item->product->name }}</a>
                                                </h3>
                                                <p class="ml-4 text-right">
                                                    <span class="text-lg font-semibold" x-text="displayTotal + '€'"></span>
                                                </p>
                                            </div>
                                            <div class="mt-1 text-sm text-gray-500 space-y-1">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p>{{ $item->product->getWoodTypeLabel() }} • {{ $item->product->getUsageTypeLabel() }}</p>
                                                        @if($item->product->humidity_rate)
                                                            <p>Humidité: {{ $item->product->humidity_rate }}%</p>
                                                        @endif
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="font-medium">{{ number_format($item->unit_price, 2) }}€ / {{ $item->product->unit_type }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-1 items-end justify-between text-sm">
                                            <div class="flex items-center space-x-2">
                                                <button type="button" @click="updateQuantity(quantity - 1)" 
                                                        :disabled="quantity <= {{ $item->product->min_order_quantity }}"
                                                        class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                                    -
                                                </button>
                                                <span x-text="quantity" class="w-8 text-center"></span>
                                                <button type="button" @click="updateQuantity(quantity + 1)" 
                                                        :disabled="quantity >= {{ $item->product->stock_quantity }}"
                                                        class="w-8 h-8 flex items-center justify-center border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                                    +
                                                </button>
                                                <span class="text-gray-500">{{ $item->product->unit_type }}(s)</span>
                                            </div>

                                            <div class="flex">
                                                <button type="button" @click="removeItem()" 
                                                        class="font-medium text-amber-600 hover:text-amber-500">
                                                    Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                        <div class="flex justify-between">
                            <a href="{{ route('catalog.index') }}" class="text-amber-600 hover:text-amber-500 font-medium">
                                ← Continuer mes achats
                            </a>
                            <button type="button" @click="clearCart()" class="text-red-600 hover:text-red-500 font-medium">
                                Vider le panier
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-10 lg:mt-0 lg:col-span-5">
                <div class="bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 sticky top-4" x-data="cartSummary({{ $cartTotal }}, {{ $cartCount }})">
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Résumé de la commande</h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Sous-total (<span x-text="itemCount"></span> articles)</span>
                            <span class="text-sm font-medium text-gray-900" x-text="subtotal.toFixed(2) + '€'"></span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Livraison</span>
                            <span class="text-sm text-gray-500">Calculée à l'étape suivante</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base font-medium text-gray-900">Total</span>
                                <span class="text-xl font-bold text-amber-600" x-text="subtotal.toFixed(2) + '€'"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        @auth
                            <a href="{{ route('orders.checkout') }}" class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition-colors block text-center">
                                <i class="fas fa-credit-card mr-2"></i>Procéder au paiement
                            </a>
                        @else
                            <div class="space-y-3">
                                <a href="{{ route('register') }}" class="w-full bg-amber-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-amber-700 transition-colors block text-center">
                                    Créer un compte et commander
                                </a>
                                <a href="{{ route('login') }}" class="w-full border border-gray-300 py-3 px-6 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors block text-center">
                                    Se connecter
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Payment Information -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">
                            <i class="fas fa-credit-card text-blue-500 mr-2"></i>Modalités de paiement
                        </h3>
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 border border-green-200">
                            <div class="flex items-start space-x-2">
                                <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-shipping-fast text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">Frais de livraison inclus</h4>
                                    <p class="text-sm text-gray-600">Aucun frais supplémentaire</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Avantages -->
                    <div class="mt-6 border-t border-gray-200 pt-6">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Nos garanties</h3>
                        <ul class="text-xs text-gray-600 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Bois séché < 20% d'humidité
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Livraison soignée et rapide
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Satisfaction garantie
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5-5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6" />
            </svg>
            <h2 class="mt-6 text-2xl font-semibold text-gray-900">Votre panier est vide</h2>
            <p class="mt-2 text-gray-600">Découvrez notre sélection de bois de qualité.</p>
            <a href="{{ route('catalog.index') }}" class="mt-6 inline-block bg-amber-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-amber-700 transition-colors">
                Parcourir le catalogue
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
function cartItem(itemId, initialQuantity, unitPrice, initialTotal) {
    return {
        quantity: initialQuantity,
        unitPrice: unitPrice,
        itemTotal: parseFloat(initialTotal),
        
        get displayTotal() {
            return this.itemTotal.toFixed(2);
        },
        
        updateQuantity(newQuantity) {
            if (newQuantity < 1) return;
            
            // Mettre à jour immédiatement l'affichage côté client
            const oldQuantity = this.quantity;
            this.quantity = newQuantity;
            this.itemTotal = newQuantity * this.unitPrice;
            
            // Mettre à jour immédiatement le résumé côté client (estimation)
            const quantityDiff = newQuantity - oldQuantity;
            const priceDiff = quantityDiff * this.unitPrice;
            window.dispatchEvent(new CustomEvent('cart-updated-instant', { 
                detail: { priceDiff: priceDiff, quantityDiff: quantityDiff }
            }));
            
            fetch(`/panier/update/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Confirmer la quantité côté serveur
                    this.quantity = newQuantity;
                    // Mettre à jour le résumé global avec les vraies données du serveur
                    window.dispatchEvent(new CustomEvent('cart-updated', { 
                        detail: { total: data.cartTotal, count: data.cartCount }
                    }));
                } else {
                    // En cas d'erreur, revenir à l'ancienne quantité
                    this.quantity = oldQuantity;
                    alert(data.message);
                }
            })
            .catch(error => {
                // En cas d'erreur réseau, revenir à l'ancienne quantité
                this.quantity = oldQuantity;
                console.error('Erreur mise à jour panier:', error);
                alert('Erreur lors de la mise à jour du panier');
            });
        },
        
        removeItem() {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
                fetch(`/panier/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }
    }
}

function cartSummary(initialTotal, initialCount) {
    return {
        subtotal: initialTotal,
        itemCount: initialCount,
        
        init() {
            // Mise à jour depuis le serveur (données exactes)
            window.addEventListener('cart-updated', (event) => {
                this.subtotal = event.detail.total;
                this.itemCount = event.detail.count;
            });
            
            // Mise à jour instantanée côté client (estimation)
            window.addEventListener('cart-updated-instant', (event) => {
                this.subtotal = parseFloat(this.subtotal) + event.detail.priceDiff;
                this.itemCount = parseInt(this.itemCount) + event.detail.quantityDiff;
            });
        }
    }
}

function clearCart() {
    if (confirm('Êtes-vous sûr de vouloir vider votre panier ?')) {
        fetch('/panier/clear', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection