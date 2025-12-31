@extends('layouts.app')

@section('title', 'Mes Achats - WoodShop')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes Achats</h1>
            <p class="text-gray-600 mt-2">Suivez vos dépenses et votre historique d'achats</p>
        </div>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Ce mois -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Ce mois</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($monthlyTotal, 2) }}€</p>
                        <p class="text-sm text-gray-500">{{ $monthlyCount }} commande(s)</p>
                    </div>
                </div>
            </div>

            <!-- Cette année -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Cette année</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ number_format($yearlyTotal, 2) }}€</p>
                        <p class="text-sm text-gray-500">{{ $yearlyCount }} commande(s)</p>
                    </div>
                </div>
            </div>

            <!-- Moyenne mensuelle -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Moyenne mensuelle</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $yearlyCount > 0 ? number_format($yearlyTotal / 12, 2) : '0.00' }}€</p>
                        <p class="text-sm text-gray-500">Sur 12 mois</p>
                    </div>
                </div>
            </div>

            <!-- Économies estimées -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Vs chauffage gaz</p>
                        <p class="text-2xl font-semibold text-green-600">-{{ number_format($yearlyTotal * 0.4, 2) }}€</p>
                        <p class="text-sm text-gray-500">Économies estimées</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
            
            <!-- Graphique évolution mensuelle -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Évolution des achats (12 mois)</h2>
                <div class="space-y-4">
                    @foreach($monthlyStats as $stat)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">{{ $stat['month'] }}</span>
                        <div class="flex items-center space-x-3">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                @if($yearlyTotal > 0)
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($stat['total'] / $yearlyTotal) * 100 }}%"></div>
                                @endif
                            </div>
                            <span class="text-sm font-medium text-gray-900 w-20 text-right">{{ number_format($stat['total'], 0) }}€</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Produits les plus achetés -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Mes produits préférés</h2>
                @if($topProducts->count() > 0)
                <div class="space-y-4">
                    @foreach($topProducts as $product)
                    <div class="flex items-center justify-between p-3 border rounded-lg">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600">{{ ucfirst($product->wood_type) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-900">{{ $product->total_quantity }} unité(s)</p>
                            <p class="text-sm text-gray-600">{{ number_format($product->total_spent, 2) }}€</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-500 text-center py-8">Aucun achat pour le moment</p>
                @endif
            </div>
        </div>

        <!-- Commandes récentes -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Commandes récentes</h2>
            </div>
            @if($recentOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Commande
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produits
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">#{{ $order->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $order->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ $order->items->count() }} produit(s)
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $order->items->first()->product->name ?? 'Produit supprimé' }}
                                    @if($order->items->count() > 1)
                                        et {{ $order->items->count() - 1 }} autre(s)
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full
                                    @switch($order->status)
                                        @case('en_attente') bg-yellow-100 text-yellow-800 @break
                                        @case('confirmee') bg-blue-100 text-blue-800 @break
                                        @case('en_preparation') bg-purple-100 text-purple-800 @break
                                        @case('expedie') bg-indigo-100 text-indigo-800 @break
                                        @case('livre') bg-green-100 text-green-800 @break
                                        @case('annule') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">{{ number_format($order->total_amount, 2) }}€</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('orders.show', $order) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Voir détails
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune commande</h3>
                <p class="mt-1 text-sm text-gray-500">Vous n'avez pas encore passé de commande.</p>
                <div class="mt-6">
                    <a href="{{ route('catalog.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Parcourir le catalogue
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- Liens rapides -->
        <div class="mt-8 bg-green-50 rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions rapides</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('catalog.index') }}" 
                   class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 00-2 2v2a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Parcourir le catalogue</p>
                        <p class="text-sm text-gray-600">{{ \App\Models\Product::count() }} produits disponibles</p>
                    </div>
                </a>
                
                <a href="{{ route('orders.index') }}" 
                   class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Toutes mes commandes</p>
                        <p class="text-sm text-gray-600">Historique complet</p>
                    </div>
                </a>
                
                <a href="{{ route('contact.show') }}" 
                   class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-gray-900">Besoin d'aide ?</p>
                        <p class="text-sm text-gray-600">Contactez-nous</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection