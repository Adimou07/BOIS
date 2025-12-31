<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'WoodShop - Vente de bois de chauffage et cuisson')</title>
    <meta name="description" content="@yield('meta_description', 'Vente en ligne de bois de chauffage et cuisson de qualité. Livraison rapide partout en France.')">

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
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('catalog.index') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Catalogue
                    </a>
                    @auth
                    <a href="{{ route('dashboard.index') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Mes Achats
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Mon Espace
                    </a>
                    @endauth
                    <a href="{{ route('conseils.index') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Conseils
                    </a>
                    <a href="{{ route('contact.show') }}" class="text-gray-700 hover:text-amber-600 transition-colors">
                        Contact
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="hidden lg:flex max-w-48 mx-2" x-data="{ 
                    query: '{{ request('q') }}', 
                    results: [], 
                    loading: false,
                    showResults: false,
                    searchDisabled: false,
                    pageJustLoaded: true,
                    init() {
                        // Forcer l'état initial propre
                        this.showResults = false;
                        this.loading = false;
                        this.results = [];
                        
                        // Empêcher la recherche automatique au chargement
                        setTimeout(() => {
                            this.pageJustLoaded = false;
                        }, 1000);
                        
                        // Désactiver la recherche quand un formulaire est soumis
                        document.addEventListener('submit', () => {
                            this.searchDisabled = true;
                            this.showResults = false;
                            this.loading = false;
                        });
                        
                        // Désactiver aussi avant le déchargement de page
                        window.addEventListener('beforeunload', () => {
                            this.searchDisabled = true;
                            this.showResults = false;
                            this.loading = false;
                        });
                    },
                    search() {
                        // Ne pas faire de recherche si la page vient de charger, désactivé ou conditions non remplies
                        if (this.pageJustLoaded || this.searchDisabled || document.hidden || this.query.length < 2) {
                            this.results = [];
                            this.showResults = false;
                            this.loading = false;
                            return;
                        }
                        
                        this.loading = true;
                        fetch(`{{ route('catalog.search') }}?q=${encodeURIComponent(this.query)}&ajax=1`)
                            .then(response => response.json())
                            .then(data => {
                                this.results = data.products;
                                this.showResults = true;
                                this.loading = false;
                            })
                            .catch(error => {
                                console.error('Erreur de recherche:', error);
                                this.loading = false;
                                this.showResults = false;
                            });
                    }
                }">
                    <div class="relative w-full">
                        <div class="relative">
                            <input type="text" 
                                   x-model="query"
                                   @input.debounce.300ms="search()"
                                   @focus="showResults = query.length >= 2"
                                   @click.away="showResults = false"
                                   placeholder="Rechercher..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent text-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                <svg x-show="!loading" class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <svg x-show="loading" class="h-4 w-4 text-amber-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="m15.84 12.48-1.84-1.84.84-.84 2.68 2.68-2.68 2.68-.84-.84z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Results dropdown -->
                        <div x-show="showResults && results.length > 0" 
                             class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg mt-1 z-50 max-h-80 overflow-y-auto">
                            <template x-for="product in results.slice(0, 6)" :key="product.id">
                                <a :href="`/catalogue/${product.id}`" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-center space-x-3">
                                        <img :src="product.image || '/images/default-wood.jpg'" :alt="product.name" class="w-10 h-10 object-cover rounded">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate" x-text="product.name"></p>
                                            <p class="text-xs text-gray-500" x-text="product.wood_type"></p>
                                        </div>
                                        <div class="text-sm font-bold text-amber-600" x-text="`${product.price}€`"></div>
                                    </div>
                                </a>
                            </template>
                            
                            <!-- View all results -->
                            <div x-show="results.length > 6" class="px-4 py-2 bg-gray-50 text-center">
                                <a :href="`{{ route('catalog.search') }}?q=${encodeURIComponent(query)}`" 
                                   class="text-sm text-amber-600 hover:text-amber-700 font-medium">
                                    Voir tous les résultats (<span x-text="results.length"></span>)
                                </a>
                            </div>
                        </div>
                        
                        <!-- No results -->
                        <div x-show="!pageJustLoaded && showResults && query.length >= 2 && results.length === 0 && !loading" 
                             class="absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg mt-1 z-50 px-4 py-3">
                            <p class="text-sm text-gray-500 text-center">Aucun résultat trouvé</p>
                        </div>
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-amber-100 text-amber-700 px-2 py-1 rounded hover:bg-amber-200 transition-colors">
                                🔧 Admin
                            </a>
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
                    <h3 class="text-lg font-semibold mb-4">WoodShop</h3>
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
                <p>&copy; {{ date('Y') }} WoodShop. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>