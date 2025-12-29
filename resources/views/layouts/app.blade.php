<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'WoodShop Pro - Vente de bois de chauffage et cuisson')</title>
    <meta name="description" content="@yield('meta_description', 'Vente en ligne de bois de chauffage et cuisson de qualité. Livraison rapide partout en France.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('head')
</head>
<body class="h-full bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-amber-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">W</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">WoodShop Pro</span>
                    </a>
                </div>

                <!-- Navigation Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('catalog.index') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Catalogue
                    </a>
                    <a href="#" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Professionnels
                    </a>
                    <a href="#" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Conseils
                    </a>
                    <a href="#" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Contact
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden lg:flex flex-1 max-w-md mx-8">
                    <form action="{{ route('catalog.search') }}" method="GET" class="w-full">
                        <div class="relative">
                            <input type="text" 
                                   name="q" 
                                   value="{{ request('q') }}"
                                   placeholder="Rechercher du bois..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('profile') }}" class="text-sm text-gray-700 hover:text-amber-600">
                                {{ auth()->user()->getDisplayName() }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-amber-600">
                            Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-amber-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-amber-700 transition-colors">
                            Inscription
                        </a>
                    @endauth

                    <!-- Panier -->
                    <a href="#" class="relative p-2 text-gray-700 hover:text-amber-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5-5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6" />
                        </svg>
                        <span class="absolute -top-2 -right-2 bg-amber-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            0
                        </span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" class="md:hidden py-4 border-t">
                <div class="space-y-2">
                    <a href="{{ route('catalog.index') }}" class="block px-3 py-2 text-gray-700">Catalogue</a>
                    <a href="#" class="block px-3 py-2 text-gray-700">Professionnels</a>
                    <a href="#" class="block px-3 py-2 text-gray-700">Conseils</a>
                    <a href="#" class="block px-3 py-2 text-gray-700">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">WoodShop Pro</h3>
                    <p class="text-gray-300">Votre spécialiste en bois de chauffage et cuisson de qualité.</p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Produits</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Bois de chauffage</a></li>
                        <li><a href="#" class="hover:text-white">Bois de cuisson</a></li>
                        <li><a href="#" class="hover:text-white">Professionnels</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">Livraison</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Légal</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-white">CGV</a></li>
                        <li><a href="#" class="hover:text-white">Mentions légales</a></li>
                        <li><a href="#" class="hover:text-white">Confidentialité</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} WoodShop Pro. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>