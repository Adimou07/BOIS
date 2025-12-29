@extends('layouts.app')

@section('title', 'Commande ' . $order->order_number)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-700">Mes commandes</a></li>
                <li><span class="text-gray-400 mx-1">/</span></li>
                <li class="text-gray-900 font-medium">{{ $order->order_number }}</li>
            </ol>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900">Détail de la commande {{ $order->order_number }}</h1>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Order Status Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 text-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold mb-1">{{ $order->order_number }}</h2>
                    <p class="text-blue-100">Commandé le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="mt-3 sm:mt-0">
                    <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Order Items (Takes 2 columns) -->
                <div class="xl:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Articles commandés</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg hover:border-gray-300 transition duration-200">
                                @if($item->product && $item->product->primaryImage)
                                    <img src="{{ $item->product->primaryImage->image_url }}" 
                                        alt="{{ $item->product_name }}" 
                                        class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">{{ $item->product_name }}</h4>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-sm text-gray-600 mb-3">
                                        @if($item->wood_type)
                                            <div class="flex items-center">
                                                <i class="fas fa-tree text-green-500 mr-2"></i>
                                                <span>{{ $item->wood_type }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($item->conditioning)
                                            <div class="flex items-center">
                                                <i class="fas fa-box text-blue-500 mr-2"></i>
                                                <span>{{ $item->conditioning }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($item->usage_type)
                                            <div class="flex items-center">
                                                <i class="fas fa-hammer text-orange-500 mr-2"></i>
                                                <span>{{ $item->usage_type }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <span class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</span>
                                            <span class="text-sm text-gray-600">Prix unitaire: {{ number_format($item->unit_price, 2, ',', ' ') }} €</span>
                                        </div>
                                        <span class="text-lg font-semibold text-gray-900">
                                            {{ number_format($item->total_price, 2, ',', ' ') }} €
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Totals -->
                    <div class="mt-6 bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Récapitulatif des coûts</h4>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600">
                                <span>Sous-total</span>
                                <span>{{ number_format($order->subtotal, 2, ',', ' ') }} €</span>
                            </div>
                            
                            @if($order->delivery_cost > 0)
                                <div class="flex justify-between text-gray-600">
                                    <span>Frais de livraison</span>
                                    <span>{{ number_format($order->delivery_cost, 2, ',', ' ') }} €</span>
                                </div>
                            @else
                                <div class="flex justify-between text-gray-600">
                                    <span>Frais de livraison</span>
                                    <span class="text-green-600 font-medium">Gratuit</span>
                                </div>
                            @endif
                            
                            @if($order->tax_amount > 0)
                                <div class="flex justify-between text-gray-600">
                                    <span>TVA</span>
                                    <span>{{ number_format($order->tax_amount, 2, ',', ' ') }} €</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between text-xl font-bold text-gray-900 pt-3 border-t border-gray-300">
                                <span>Total</span>
                                <span>{{ number_format($order->total, 2, ',', ' ') }} €</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Info Sidebar -->
                <div class="xl:col-span-1 space-y-6">
                    <!-- Shipping Address -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">
                            <i class="fas fa-truck text-blue-500 mr-2"></i>Livraison
                        </h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p class="font-medium text-gray-900">{{ $order->shipping_name }}</p>
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_postal_code }} {{ $order->shipping_city }}</p>
                            <p>{{ $order->shipping_country }}</p>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">
                            <i class="fas fa-file-invoice text-green-500 mr-2"></i>Facturation
                        </h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p class="font-medium text-gray-900">{{ $order->billing_name }}</p>
                            <p>{{ $order->billing_address }}</p>
                            <p>{{ $order->billing_postal_code }} {{ $order->billing_city }}</p>
                            <p>{{ $order->billing_country }}</p>
                        </div>
                    </div>

                    <!-- Company Info (if applicable) -->
                    @if($order->company_name || $order->siret)
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">
                                <i class="fas fa-building text-purple-500 mr-2"></i>Informations entreprise
                            </h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                @if($order->company_name)
                                    <p><span class="font-medium">Entreprise:</span> {{ $order->company_name }}</p>
                                @endif
                                @if($order->siret)
                                    <p><span class="font-medium">SIRET:</span> {{ $order->siret }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Payment Status -->
                    <div class="bg-white border border-gray-200 rounded-lg p-4">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">
                            <i class="fas fa-credit-card text-yellow-500 mr-2"></i>Paiement
                        </h4>
                        <div class="text-sm text-gray-600">
                            <p class="mb-1">
                                <span class="font-medium">Statut:</span> 
                                <span class="capitalize {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ $order->payment_status === 'paid' ? 'Payé' : 'En attente' }}
                                </span>
                            </p>
                            @if($order->payment_method)
                                <p><span class="font-medium">Méthode:</span> {{ $order->payment_method }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Order Notes -->
                    @if($order->notes)
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <h4 class="text-lg font-semibold text-gray-900 mb-3">
                                <i class="fas fa-comment text-gray-500 mr-2"></i>Commentaires
                            </h4>
                            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="space-y-2">
                        @if($order->canBeCancelled())
                            <button onclick="if(confirm('Êtes-vous sûr de vouloir annuler cette commande ?')) { /* TODO: Add cancel logic */ }"
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition duration-200">
                                <i class="fas fa-times mr-2"></i>Annuler la commande
                            </button>
                        @endif
                        
                        <a href="{{ route('orders.index') }}" 
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Retour aux commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection