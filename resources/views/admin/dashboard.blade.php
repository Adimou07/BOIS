<x-admin-layout title="Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Produits -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-amber-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Produits</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_products'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Commandes -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Commandes</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_orders'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Commandes en attente -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">En attente</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_orders'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock faible -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Stock faible</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['low_stock_products'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Actions rapides -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Actions rapides</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.index') }}" class="block w-full bg-amber-600 text-white text-center py-2 px-4 rounded-md hover:bg-amber-700 transition-colors">
                        Gérer les produits
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700 transition-colors">
                        Ajouter un produit
                    </a>
                    <a href="{{ route('catalog.index') }}" target="_blank" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                        Voir le site public
                    </a>
                </div>
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Commandes récentes</h3>
                @if($stats['recent_orders']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['recent_orders'] as $order)
                            <div class="flex items-center justify-between border-b pb-2">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->name ?? 'Client supprimé' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-gray-900">{{ number_format($order->total_amount, 2) }} €</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($order->status === 'en_attente') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'confirmee') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'expediee') bg-purple-100 text-purple-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-sm">Aucune commande récente</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>