@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Mes commandes</h1>
        <p class="text-gray-600">Retrouvez l'historique de toutes vos commandes</p>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden">
                    <!-- Order Header -->
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Commande {{ $order->order_number }}
                                </h3>
                                <p class="text-sm text-gray-500 mt-1">
                                    Passée le {{ $order->created_at->format('d/m/Y à H:i') }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-4 mt-3 sm:mt-0">
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $order->status_color }}">
                                    {{ $order->status_label }}
                                </span>
                                <span class="text-lg font-semibold text-gray-900">
                                    {{ number_format($order->total, 2, ',', ' ') }} €
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items Preview -->
                    <div class="px-6 py-4">
                        <div class="flex items-center space-x-4 overflow-x-auto">
                            @foreach($order->items->take(3) as $item)
                                <div class="flex-shrink-0 flex items-center space-x-3">
                                    @if($item->product && $item->product->primaryImage)
                                        <img src="{{ $item->product->primaryImage->image_url }}" 
                                            alt="{{ $item->product_name }}" 
                                            class="w-12 h-12 object-cover rounded">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 truncate max-w-32">
                                            {{ $item->product_name }}
                                        </p>
                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                            @if($order->items->count() > 3)
                                <div class="flex-shrink-0 text-sm text-gray-500">
                                    +{{ $order->items->count() - 3 }} autre{{ $order->items->count() - 3 > 1 ? 's' : '' }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-2 sm:space-y-0">
                            <div class="text-sm text-gray-600">
                                {{ $order->items->count() }} article{{ $order->items->count() > 1 ? 's' : '' }}
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('orders.show', $order) }}" 
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-200">
                                    <i class="fas fa-eye mr-2"></i>Voir détails
                                </a>
                                
                                @if($order->canBeCancelled())
                                    <button onclick="if(confirm('Êtes-vous sûr de vouloir annuler cette commande ?')) { /* TODO: Add cancel logic */ }"
                                        class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 transition duration-200">
                                        <i class="fas fa-times mr-2"></i>Annuler
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-shopping-bag text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">Aucune commande</h3>
            <p class="text-gray-600 mb-6">Vous n'avez pas encore passé de commande.</p>
            <a href="{{ route('catalog.index') }}" 
                class="inline-flex items-center px-6 py-3 border border-transparent rounded-md font-medium text-white bg-blue-600 hover:bg-blue-700 transition duration-200">
                <i class="fas fa-shopping-cart mr-2"></i>Découvrir nos produits
            </a>
        </div>
    @endif
</div>
@endsection