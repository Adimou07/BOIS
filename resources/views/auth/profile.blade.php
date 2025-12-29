@extends('layouts.app')

@section('title', 'Mon profil - WoodShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mon profil</h1>
            <p class="text-gray-600">Gérez vos informations personnelles et préférences</p>
        </div>

        <!-- Account Type Badge -->
        <div class="mb-6">
            @if(auth()->user()->isProfessional())
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Compte Professionnel
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Compte Particulier
                </span>
            @endif
        </div>

        <div class="space-y-6">
            <!-- Informations générales -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Informations générales</h2>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" class="px-6 py-4 space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            @if(auth()->user()->isProfessional())
                                Nom du responsable
                            @else
                                Nom complet
                            @endif
                        </label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" 
                                   class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Company Name (for professionals) -->
                    @if(auth()->user()->isProfessional())
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">
                            Nom de l'entreprise
                        </label>
                        <div class="mt-1">
                            <input type="text" name="company_name" id="company_name" 
                                   value="{{ old('company_name', auth()->user()->company_name) }}" 
                                   class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- Email (read-only) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Adresse email
                        </label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" 
                                   disabled
                                   class="shadow-sm bg-gray-50 border-gray-300 text-gray-500 block w-full sm:text-sm border rounded-md">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">L'email ne peut pas être modifié</p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">
                            Téléphone
                        </label>
                        <div class="mt-1">
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone) }}" 
                                   class="shadow-sm focus:ring-amber-500 focus:border-amber-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SIRET (for professionals, read-only) -->
                    @if(auth()->user()->isProfessional() && auth()->user()->siret)
                    <div>
                        <label for="siret" class="block text-sm font-medium text-gray-700">
                            N° SIRET
                        </label>
                        <div class="mt-1">
                            <input type="text" name="siret" id="siret" value="{{ auth()->user()->siret }}" 
                                   disabled
                                   class="shadow-sm bg-gray-50 border-gray-300 text-gray-500 block w-full sm:text-sm border rounded-md">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Le SIRET ne peut pas être modifié</p>
                    </div>
                    @endif

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>

            <!-- Statistiques compte -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-medium text-gray-900">Statistiques du compte</h2>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Membre depuis</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ auth()->user()->created_at->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dernière connexion</dt>
                            <dd class="mt-1 text-sm text-gray-900">Aujourd'hui</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total commandes</dt>
                            <dd class="mt-1 text-sm text-gray-900">0 commande</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Statut</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Actif
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Avantages du compte -->
            <div class="bg-amber-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-amber-800 mb-4">
                    @if(auth()->user()->isProfessional())
                        🏢 Avantages Professionnels
                    @else
                        🏠 Avantages Particulier
                    @endif
                </h3>
                <ul class="space-y-2 text-sm text-amber-700">
                    @if(auth()->user()->isProfessional())
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Prix professionnels dégressifs automatiques
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Accès aux produits professionnels (big bags)
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Facturation avec conditions de paiement
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Support dédié aux professionnels
                        </li>
                    @else
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Suivi de vos commandes et livraisons
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Historique d'achat et récommande rapide
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Offres exclusives et promotions
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Panier sauvegardé automatiquement
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection