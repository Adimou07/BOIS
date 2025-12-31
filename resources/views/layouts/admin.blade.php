<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Administration' }} - Bois de Chauffage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="min-h-full">
        <!-- Navigation -->
        <nav class="bg-amber-800 border-b border-amber-900">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-white">Admin Panel</h1>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="{{ route('admin.dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium text-amber-100 hover:bg-amber-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-amber-900 text-white' : '' }}">
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.products.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-amber-100 hover:bg-amber-700 hover:text-white {{ request()->routeIs('admin.products.*') ? 'bg-amber-900 text-white' : '' }}">
                                    Produits
                                </a>
                                <a href="{{ route('catalog.index') }}" target="_blank" class="rounded-md px-3 py-2 text-sm font-medium text-amber-100 hover:bg-amber-700 hover:text-white">
                                    Voir le site →
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="relative ml-3">
                                <span class="text-amber-100">{{ auth()->user()->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page header -->
        <header class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title ?? 'Administration' }}</h1>
            </div>
        </header>

        <!-- Main content -->
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <!-- Alerts -->
                @if(session('success'))
                    <div class="mb-6 rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.236 4.53L7.53 10.53a.75.75 0 00-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page content -->
                <div class="px-4 py-6 sm:px-0">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>