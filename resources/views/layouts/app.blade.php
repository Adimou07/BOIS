<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'WoodShop - Vente de bois de chauffage et cuisson')</title>
    <meta name="description" content="@yield('meta_description', 'Vente en ligne de bois de chauffage et cuisson de qualité. Livraison rapide partout en France.')"

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Charger le compteur du panier au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            // Force reset du compteur TOUJOURS à 0 au démarrage
            const countElement = document.querySelector('.cart-count');
            if (countElement) {
                countElement.textContent = '0';
                console.log('Compteur forcé à 0');
            }
            // Puis charge la vraie valeur du serveur
            setTimeout(() => {
                updateGlobalCartCount();
                console.log('Mise à jour depuis serveur');
            }, 200);
        });

        function updateGlobalCartCount() {
            fetch('/panier/count')
                .then(response => response.json())
                .then(data => {
                    const countElement = document.querySelector('.cart-count');
                    if (countElement) {
                        countElement.textContent = data.count;
                    }
                })
                .catch(error => console.error('Erreur chargement compteur panier:', error));
        }

        function cartComponent(minQuantity, unitPrice, addUrl, countUrl) {
            return {
                quantity: minQuantity,
                total: minQuantity * unitPrice,
                adding: false,
                init() {
                    this.total = this.quantity * unitPrice;
                    console.log('Cart component initialized');
                },
                addToCart() {
                    console.log('=== DEBUT addToCart ===');
                    console.log('Quantité:', this.quantity);
                    
                    if (this.adding) return;
                    this.adding = true;
                    
                    fetch(addUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: this.quantity
                        })
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);
                        if (data.success) {
                            this.showNotification('Produit ajouté au panier !', 'success');
                            this.updateCartCount();
                        } else {
                            this.showNotification(data.message || 'Erreur lors de l\'ajout au panier', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        this.showNotification('Erreur lors de l\'ajout au panier', 'error');
                    })
                    .finally(() => {
                        console.log('=== FIN addToCart ===');
                        this.adding = false;
                    });
                },
                showNotification(message, type) {
                    const notification = document.createElement('div');
                    let bgClass = 'bg-blue-500 text-white';
                    if (type === 'success') bgClass = 'bg-green-500 text-white';
                    if (type === 'error') bgClass = 'bg-red-500 text-white';
                    
                    notification.className = 'fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 ' + bgClass;
                    notification.textContent = message;
                    document.body.appendChild(notification);
                    
                    setTimeout(() => notification.style.transform = 'translateX(0)', 100);
                    setTimeout(() => {
                        notification.style.transform = 'translateX(100%)';
                        setTimeout(() => document.body.removeChild(notification), 300);
                    }, 3000);
                },
                updateCartCount() {
                    updateGlobalCartCount();
                }
            }
        }
    </script>

    @stack('head')
</head>
<body class="h-full bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center mr-12">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-amber-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">W</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">WoodShop</span>
                    </a>
                </div>

                <!-- Navigation Desktop -->
                <div class="hidden md:flex items-center justify-center space-x-8 flex-1 max-w-lg">
                    <a href="{{ route('catalog.index') }}" class="text-gray-700 hover:text-amber-600 transition-colors font-medium">
                        Catalogue
                    </a>
                    <a href="{{ route('conseils.index') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Conseils
                    </a>
                    <a href="{{ route('contact.show') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Contact
                    </a>
                    @auth
                    <a href="{{ route('dashboard.index') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Mes Commandes
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Mon Espace
                    </a>
                    @endauth
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class=\"flex items-center space-x-3\">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-amber-100 text-amber-700 px-2 py-1 rounded hover:bg-amber-200 transition-colors">
                                Admin
                            </a>
                            <a href="{{ route('profile') }}" class="text-sm text-gray-700 hover:text-amber-600">
                                {{ auth()->user()->getDisplayName() }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-bold">
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
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-amber-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5-5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6" />
                        </svg>
                        <span class="cart-count absolute -top-2 -right-2 bg-amber-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
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
                    <a href="{{ route('conseils.index') }}" class="block px-3 py-2 text-gray-700">Conseils</a>
                    <a href="{{ route('contact.show') }}" class="block px-3 py-2 text-gray-700">Contact</a>
                    @auth
                        <a href="{{ route('dashboard.index') }}" class="block px-3 py-2 text-gray-700">Mes Achats</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700">Connexion</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-gray-700">Inscription</a>
                    @endauth
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
                    <h3 class="text-lg font-semibold mb-4">WoodShop</h3>
                    <p class="text-gray-300">Votre spécialiste en bois de chauffage et cuisson de qualité.</p>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Produits</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-white">Bois de chauffage</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-white">Bois de cuisson</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-white">Professionnels</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-md font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="{{ route('delivery.zones') }}" class="hover:text-white">Livraison</a></li>
                        <li><a href="#" class="hover:text-white">FAQ</a></li>
                        <li><a href="{{ route('contact.show') }}" class="hover:text-white">Contact</a></li>
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
                <p>&copy; {{ date('Y') }} WoodShop. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>