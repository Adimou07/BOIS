<x-admin-layout title="Nouveau Produit">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Créer un nouveau produit</h2>
        <p class="text-gray-600">Ajoutez un nouveau produit de bois de chauffage</p>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Informations générales</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom du produit *</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Essence de bois -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Essence de bois *</label>
                        <select name="wood_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Sélectionnez une essence</option>
                            @foreach(array_keys(\App\Models\Product::WOOD_TYPES) as $wood)
                                <option value="{{ $wood }}" {{ old('wood_type') === $wood ? 'selected' : '' }}>
                                    {{ \App\Models\Product::WOOD_TYPES[$wood] }}
                                </option>
                            @endforeach
                        </select>
                        @error('wood_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catégorie *</label>
                        <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Conditionnement -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Conditionnement *</label>
                        <select name="conditioning" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Sélectionnez le conditionnement</option>
                            @foreach(['vrac', 'sacs_25kg', 'sacs_40kg', 'palettes', 'steres', 'big_bags'] as $pkg)
                                <option value="{{ $pkg }}" {{ old('conditioning') === $pkg ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $pkg)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('conditioning')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Usage -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Usage *</label>
                        <select name="usage_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Sélectionnez l'usage</option>
                            @foreach(['chauffage', 'cuisson', 'both'] as $use)
                                <option value="{{ $use }}" {{ old('usage_type') === $use ? 'selected' : '' }}>
                                    {{ $use === 'both' ? 'Mixte' : ucfirst($use) }}
                                </option>
                            @endforeach
                        </select>
                        @error('usage_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Prix particulier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix particulier (€) *</label>
                        <input type="number" name="price_per_unit" value="{{ old('price_per_unit') }}" 
                               step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('price_per_unit')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Prix professionnel -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix professionnel (€) *</label>
                        <input type="number" name="professional_price" value="{{ old('professional_price') }}" 
                               step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('professional_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock *</label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" 
                               min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('stock_quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Quantité minimale -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantité minimale *</label>
                        <input type="number" name="min_order_quantity" value="{{ old('min_order_quantity', 1) }}" 
                               min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('min_order_quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3" placeholder="Description du produit..."
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Images du produit -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Images du produit</h3>
                    <p class="text-sm text-gray-500 mt-1">Ajoutez des images pour présenter votre produit</p>
                </div>
                
                <!-- Zone d'upload moderne -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-amber-400 transition-colors">
                    <div class="space-y-4">
                        <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        
                        <div>
                            <label for="product_images" class="cursor-pointer">
                                <span class="bg-amber-600 text-white px-6 py-3 rounded-md text-sm font-medium hover:bg-amber-700 transition-colors inline-block">
                                    📸 Sélectionner des images
                                </span>
                                <input id="product_images" type="file" name="images[]" multiple accept="image/*" class="sr-only" 
                                       onchange="updateCreateFileList(this)">
                            </label>
                            <p class="text-sm text-gray-500 mt-2">ou glissez-déposez vos images ici</p>
                        </div>
                        
                        <div id="create-file-list" class="text-sm text-gray-600"></div>
                    </div>
                </div>
                
                <!-- Informations détaillées -->
                <div class="mt-4 bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium mb-2">Conseils pour de meilleures images :</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Formats acceptés :</strong> JPG, JPEG, PNG, WebP</li>
                                <li><strong>Taille maximale :</strong> 2 MB par image</li>
                                <li><strong>Résolution recommandée :</strong> Au moins 800x600 pixels</li>
                                <li><strong>Première image :</strong> Sera utilisée comme image principale</li>
                                <li><strong>Éclairage :</strong> Photos bien éclairées, naturelles</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                @error('images.*')
                    <div class="mt-3 bg-red-50 border border-red-200 rounded-md p-3">
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <script>
                function updateCreateFileList(input) {
                    const fileList = document.getElementById('create-file-list');
                    const files = input.files;
                    
                    if (files.length > 0) {
                        let html = '<div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-md">';
                        html += '<p class="text-sm font-medium text-green-800 mb-2">📁 ' + files.length + ' image(s) sélectionnée(s) :</p>';
                        html += '<ul class="text-sm text-green-700 space-y-1">';
                        
                        for (let i = 0; i < files.length; i++) {
                            const size = (files[i].size / 1024 / 1024).toFixed(2);
                            const icon = i === 0 ? '🌟' : '📷';
                            const label = i === 0 ? ' (Image principale)' : '';
                            html += `<li class="flex items-center"><span class="mr-2">${icon}</span>${files[i].name} (${size} MB)${label}</li>`;
                        }
                        
                        html += '</ul></div>';
                        fileList.innerHTML = html;
                    } else {
                        fileList.innerHTML = '';
                    }
                }
            </script>

            <!-- Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-amber-600 text-white px-6 py-2 rounded-md hover:bg-amber-700 transition-colors">
                    ✅ Créer le produit
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>