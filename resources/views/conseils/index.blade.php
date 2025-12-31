@extends('layouts.app')

@section('title', 'Conseils et Guides - WoodShop')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Conseils & Guides</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Découvrez nos guides pratiques pour bien choisir, stocker et utiliser votre bois de chauffage. 
                Nos experts partagent leurs conseils pour optimiser votre chauffage au bois.
            </p>
        </div>

        <!-- Guides principaux -->
        <div class="grid lg:grid-cols-2 gap-8 mb-16">
            
            <!-- Guide choix du bois -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-gradient-to-br from-green-500 to-green-700 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Comment choisir son bois de chauffage</h3>
                    <p class="text-gray-600 mb-4">
                        Chêne, hêtre, charme... Apprenez à sélectionner la meilleure essence selon votre usage, 
                        votre installation et votre budget. Guide complet avec comparatif des essences.
                    </p>
                    <a href="{{ route('conseils.guide', 'choisir-bois-chauffage') }}" 
                       class="inline-flex items-center text-green-600 hover:text-green-700 font-medium">
                        Lire le guide
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Guide stockage -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-gradient-to-br from-amber-500 to-orange-600 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Bien stocker son bois de chauffage</h3>
                    <p class="text-gray-600 mb-4">
                        Préservez la qualité de votre bois avec nos conseils de stockage. 
                        Abri, aération, protection... Tout pour garder un bois sec et performant.
                    </p>
                    <a href="{{ route('conseils.guide', 'stocker-bois') }}" 
                       class="inline-flex items-center text-amber-600 hover:text-amber-700 font-medium">
                        Lire le guide
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Guide allumage -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-gradient-to-br from-red-500 to-pink-600 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Allumer un feu efficacement</h3>
                    <p class="text-gray-600 mb-4">
                        Techniques éprouvées pour allumer votre feu rapidement et proprement. 
                        Méthode du feu inversé, choix du petit bois, gestion de l'air...
                    </p>
                    <a href="{{ route('conseils.guide', 'allumer-feu') }}" 
                       class="inline-flex items-center text-red-600 hover:text-red-700 font-medium">
                        Lire le guide
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Guide entretien -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <div class="h-48 bg-gradient-to-br from-blue-500 to-indigo-600 relative">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Entretenir son poêle à bois</h3>
                    <p class="text-gray-600 mb-4">
                        Maintenance régulière pour optimiser les performances et la sécurité. 
                        Nettoyage, ramonage, vérification... Planning d'entretien complet.
                    </p>
                    <a href="{{ route('conseils.guide', 'entretenir-poele') }}" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium">
                        Lire le guide
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Section conseils rapides -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Conseils rapides</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Taux d'humidité</h3>
                    <p class="text-gray-600 text-sm">
                        Un bon bois de chauffage doit avoir un taux d'humidité inférieur à 20% pour une combustion optimale.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Séchage</h3>
                    <p class="text-gray-600 text-sm">
                        Le bois doit sécher 18 à 24 mois minimum à l'abri de la pluie mais avec une bonne aération.
                    </p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Combustion</h3>
                    <p class="text-gray-600 text-sm">
                        Démarrez avec du petit bois sec et alimentez progressivement avec des bûches plus grosses.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ rapide -->
        <div class="bg-green-50 rounded-lg p-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6 text-center">Questions fréquentes</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Quelle quantité commander ?</h3>
                    <p class="text-gray-600 text-sm">
                        Comptez 5 à 10 stères par hiver pour un chauffage principal, 2 à 4 stères pour un chauffage d'appoint.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Quand commander ?</h3>
                    <p class="text-gray-600 text-sm">
                        Idéalement au printemps ou en été pour bénéficier des meilleurs prix et de la disponibilité.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Différence entre chêne et hêtre ?</h3>
                    <p class="text-gray-600 text-sm">
                        Le chêne brûle plus longtemps, le hêtre s'allume plus facilement. Les deux sont d'excellents choix.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Peut-on mélanger les essences ?</h3>
                    <p class="text-gray-600 text-sm">
                        Oui ! Commencez par du bois tendre (sapin) puis ajoutez du bois dur (chêne, hêtre).
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection