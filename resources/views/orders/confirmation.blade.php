@extends('layouts.app')

@section('title', 'Commande confirmée')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="text-center mb-8">
        <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-4">
            <i class="fas fa-check text-2xl text-green-600"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Commande confirmée !</h1>
        <p class="text-lg text-gray-600">
            Merci {{ $order->user->name }}, votre commande a été enregistrée avec succès.
        </p>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Order Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4 text-white">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold">Commande {{ $order->order_number }}</h2>
                    <p class="text-green-100">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $order->status_color }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Details -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Détails de la commande</h3>
                    
                    <!-- Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($order->items as $item)
                            <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg">
                                @if($item->product && $item->product->primaryImage)
                                    <img src="{{ $item->product->primaryImage->image_url }}" 
                                        alt="{{ $item->product_name }}" 
                                        class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                                    @if($item->wood_type)
                                        <p class="text-sm text-gray-600">Essence: {{ $item->wood_type }}</p>
                                    @endif
                                    @if($item->conditioning)
                                        <p class="text-sm text-gray-600">Conditionnement: {{ $item->conditioning }}</p>
                                    @endif
                                    <div class="flex justify-between items-center mt-2">
                                        <span class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</span>
                                        <span class="font-medium">{{ number_format($item->total_price, 2, ',', ' ') }} €</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Sous-total</span>
                            <span>{{ number_format($order->subtotal, 2, ',', ' ') }} €</span>
                        </div>
                        
                        @if($order->delivery_cost > 0)
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Livraison</span>
                                <span>{{ number_format($order->delivery_cost, 2, ',', ' ') }} €</span>
                            </div>
                        @endif
                        
                        @if($order->tax_amount > 0)
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>TVA</span>
                                <span>{{ number_format($order->tax_amount, 2, ',', ' ') }} €</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between text-lg font-semibold text-gray-900 pt-2 border-t border-gray-300">
                            <span>Total</span>
                            <span>{{ number_format($order->total, 2, ',', ' ') }} €</span>
                        </div>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="space-y-6">
                    <!-- Shipping Address -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            <i class="fas fa-truck text-blue-500 mr-2"></i>Adresse de livraison
                        </h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="font-medium">{{ $order->shipping_name }}</p>
                            <p>{{ $order->shipping_address }}</p>
                            <p>{{ $order->shipping_postal_code }} {{ $order->shipping_city }}</p>
                            <p>{{ $order->shipping_country }}</p>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            <i class="fas fa-file-invoice text-green-500 mr-2"></i>Adresse de facturation
                        </h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="font-medium">{{ $order->billing_name }}</p>
                            <p>{{ $order->billing_address }}</p>
                            <p>{{ $order->billing_postal_code }} {{ $order->billing_city }}</p>
                            <p>{{ $order->billing_country }}</p>
                        </div>
                    </div>

                    @if($order->notes)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                <i class="fas fa-comment text-gray-500 mr-2"></i>Commentaires
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700">{{ $order->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
        <a href="{{ route('orders.index') }}" 
            class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-md font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
            <i class="fas fa-list mr-2"></i>Voir mes commandes
        </a>
        
        <a href="{{ route('catalog.index') }}" 
            class="inline-flex items-center px-6 py-3 border border-transparent rounded-md font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
            <i class="fas fa-shopping-bag mr-2"></i>Continuer mes achats
        </a>
    </div>

    <!-- Next Steps -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-medium text-blue-900 mb-2">Que se passe-t-il maintenant ?</h3>
        <ul class="text-sm text-blue-800 space-y-2">
            <li class="flex items-start">
                <i class="fas fa-envelope text-blue-600 mr-2 mt-0.5"></i>
                <span>Vous recevrez un email de confirmation à l'adresse {{ $order->user->email }}</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-cog text-blue-600 mr-2 mt-0.5"></i>
                <span>Nous préparons votre commande dans les plus brefs délais</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-shipping-fast text-blue-600 mr-2 mt-0.5"></i>
                <span>Vous serez informé dès l'expédition de votre colis</span>
            </li>
        </ul>
    </div>
</div>
@endsection