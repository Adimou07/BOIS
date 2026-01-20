<x-admin-layout title="Modifier le Produit">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Modifier : {{ $product->name }}</h2>
        <p class="text-gray-600">Modifiez les informations et photos du produit</p>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Informations générales</h3>
                    <div class="bg-blue-50 border border-blue-200 rounded-md px-3 py-1">
                        <p class="text-xs text-blue-700">
                            <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Modifiez seulement les champs que vous voulez changer
                        </p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom du produit</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Essence de bois -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Essence de bois</label>
                        <select name="wood_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Sélectionnez une essence</option>
                            @foreach(array_keys(\App\Models\Product::WOOD_TYPES) as $wood)
                                <option value="{{ $wood }}" {{ old('wood_type', $product->wood_type) === $wood ? 'selected' : '' }}>
                                    {{ \App\Models\Product::WOOD_TYPES[$wood] }}
                                </option>
                            @endforeach
                        </select>
                        @error('wood_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Sélectionnez une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Conditionnement -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Conditionnement</label>
                        <select name="conditioning" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Sélectionnez le conditionnement</option>
                            @foreach(['vrac', 'sacs_25kg', 'sacs_40kg', 'palettes', 'steres', 'big_bags'] as $pkg)
                                <option value="{{ $pkg }}" {{ old('conditioning', $product->conditioning) === $pkg ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $pkg)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('conditioning')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Usage -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Usage</label>
                        <select name="usage_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Sélectionnez l'usage</option>
                            @foreach(['chauffage', 'cuisson', 'both'] as $use)
                                <option value="{{ $use }}" {{ old('usage_type', $product->usage_type) === $use ? 'selected' : '' }}>
                                    {{ $use === 'both' ? 'Mixte' : ucfirst($use) }}
                                </option>
                            @endforeach
                        </select>
                        @error('usage_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Prix particulier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix particulier (€)</label>
                        <input type="number" name="price_per_unit" value="{{ old('price_per_unit', $product->price_per_unit) }}" 
                               step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('price_per_unit')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Prix professionnel -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix professionnel (€)</label>
                        <input type="number" name="professional_price" value="{{ old('professional_price', $product->professional_price) }}" 
                               step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('professional_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock</label>
                        <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" 
                               min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('stock_quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Quantité minimale -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantité minimale</label>
                        <input type="number" name="min_order_quantity" value="{{ old('min_order_quantity', $product->min_order_quantity) }}" 
                               min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                        @error('min_order_quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">{{ old('description', $product->description) }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Gestion des Images -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="border-b border-gray-200 pb-4 mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Gestion des images</h3>
                    <p class="text-sm text-gray-500 mt-1">Gérez les photos de votre produit</p>
                </div>
                
                <!-- Images actuelles -->
                @if($product->images->count() > 0)
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-md font-medium text-gray-800">Images actuelles ({{ $product->images->count() }})</h4>
                            <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Cliquez "Supprimer" sous l'image</span>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                            @foreach($product->images as $image)
                                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow" id="image-{{ $image->id }}">
                                    <!-- Image -->
                                    <div class="relative">
                                        <img src="{{ $image->full_image_url }}" 
                                             alt="{{ $image->alt_text ?? 'Image produit' }}" 
                                             class="w-full h-32 object-cover">
                                        
                                        <!-- Overlay de suppression -->
                                        <div id="delete-overlay-{{ $image->id }}" class="absolute inset-0 bg-red-500 bg-opacity-75 hidden items-center justify-center">
                                            <div class="text-white text-center">
                                                <svg class="w-8 h-8 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                <p class="text-xs font-medium">À supprimer</p>
                                                <button type="button" onclick="toggleImageForDeletion({{ $image->id }})" 
                                                        class="text-xs underline mt-1">Annuler</button>
                                            </div>
                                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" id="delete-{{ $image->id }}" class="sr-only">
                                        </div>
                                        
                                        <!-- Indicateur image primaire -->
                                        @if($loop->first)
                                            <div class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded">
                                                Principal
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Bouton de suppression en bas -->
                                    <div class="p-2 bg-gray-50 border-t">
                                        <button type="button" onclick="toggleImageForDeletion({{ $image->id }})"
                                                class="w-full bg-red-600 text-white text-xs py-2 px-3 rounded hover:bg-red-700 transition-colors"
                                                id="delete-btn-{{ $image->id }}">
                                            🗑️ Supprimer
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                            <div class="flex">
                                <svg class="w-4 h-4 text-blue-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-xs text-blue-700">
                                    <strong>Comment supprimer :</strong> Cliquez sur le bouton "🗑️ Supprimer" sous l'image que vous voulez supprimer. 
                                    L'image devient rouge et le bouton change en "↶ Annuler". Cliquez "Mettre à jour le produit" pour confirmer la suppression.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mb-8 text-center py-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-500">Aucune image pour ce produit</p>
                    </div>
                @endif

                <!-- Zone d'upload -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-medium text-gray-800 mb-4">Ajouter de nouvelles images</h4>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-amber-400 transition-colors">
                        <div class="space-y-3">
                            <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            
                            <div>
                                <label for="new_images" class="cursor-pointer">
                                    <span class="bg-amber-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-amber-700 transition-colors inline-block">
                                        Sélectionner des images
                                    </span>
                                    <input id="new_images" type="file" name="new_images[]" multiple accept="image/*" class="sr-only" 
                                           onchange="updateFileList(this)">
                                </label>
                                <p class="text-sm text-gray-500 mt-2">ou glissez-déposez vos images ici</p>
                            </div>
                            
                            <div id="file-list" class="text-sm text-gray-600"></div>
                        </div>
                    </div>
                    
                    <div class="mt-3 bg-blue-50 border border-blue-200 rounded-md p-3">
                        <div class="flex">
                            <svg class="w-4 h-4 text-blue-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-xs text-blue-700">
                                <p><strong>Formats acceptés :</strong> JPG, JPEG, PNG, WebP</p>
                                <p><strong>Taille maximale :</strong> 2 MB par image</p>
                                <p><strong>Recommandé :</strong> Images carrées 800x800px minimum</p>
                            </div>
                        </div>
                    </div>
                    
                    @error('new_images.*')
                        <div class="mt-3 bg-red-50 border border-red-200 rounded-md p-3">
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <script>
                // Gestion de l'upload de fichiers
                function updateFileList(input) {
                    const fileList = document.getElementById('file-list');
                    const files = input.files;
                    
                    if (files.length > 0) {
                        let html = '<div class="mt-2"><strong>Fichiers sélectionnés :</strong><ul class="list-disc list-inside mt-1">';
                        for (let i = 0; i < files.length; i++) {
                            html += `<li>${files[i].name} (${(files[i].size / 1024 / 1024).toFixed(2)} MB)</li>`;
                        }
                        html += '</ul></div>';
                        fileList.innerHTML = html;
                    } else {
                        fileList.innerHTML = '';
                    }
                }

                // Gestion de la suppression d'images
                function toggleImageForDeletion(imageId) {
                    const overlay = document.getElementById(`delete-overlay-${imageId}`);
                    const checkbox = document.getElementById(`delete-${imageId}`);
                    const imageContainer = document.getElementById(`image-${imageId}`);
                    const deleteBtn = document.getElementById(`delete-btn-${imageId}`);
                    
                    if (overlay.classList.contains('hidden')) {
                        // Marquer pour suppression
                        overlay.classList.remove('hidden');
                        overlay.classList.add('flex');
                        checkbox.checked = true;
                        imageContainer.classList.add('ring-2', 'ring-red-500');
                        deleteBtn.textContent = '↶ Annuler';
                        deleteBtn.classList.remove('bg-red-600', 'hover:bg-red-700');
                        deleteBtn.classList.add('bg-gray-600', 'hover:bg-gray-700');
                        
                        // Animation
                        overlay.style.opacity = '0';
                        setTimeout(() => {
                            overlay.style.opacity = '1';
                        }, 50);
                    } else {
                        // Annuler la suppression
                        overlay.classList.add('hidden');
                        overlay.classList.remove('flex');
                        checkbox.checked = false;
                        imageContainer.classList.remove('ring-2', 'ring-red-500');
                        deleteBtn.textContent = '🗑️ Supprimer';
                        deleteBtn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                        deleteBtn.classList.add('bg-red-600', 'hover:bg-red-700');
                    }
                    
                    updateDeleteCounter();
                }

                // Compteur d'images à supprimer
                function updateDeleteCounter() {
                    const checkedBoxes = document.querySelectorAll('input[name="remove_images[]"]:checked');
                    const counter = document.getElementById('delete-counter');
                    
                    if (checkedBoxes.length > 0) {
                        if (!counter) {
                            const headerDiv = document.querySelector('.flex.items-center.justify-between.mb-4');
                            const newCounter = document.createElement('span');
                            newCounter.id = 'delete-counter';
                            newCounter.className = 'text-xs text-red-600 bg-red-100 px-2 py-1 rounded ml-2';
                            headerDiv.appendChild(newCounter);
                        }
                        document.getElementById('delete-counter').textContent = `${checkedBoxes.length} image(s) à supprimer`;
                    } else {
                        if (counter) {
                            counter.remove();
                        }
                    }
                }

                // Confirmation avant soumission si des images sont marquées pour suppression
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.querySelector('form');
                    form.addEventListener('submit', function(e) {
                        const checkedBoxes = document.querySelectorAll('input[name="remove_images[]"]:checked');
                        if (checkedBoxes.length > 0) {
                            const confirmed = confirm(`Êtes-vous sûr de vouloir supprimer ${checkedBoxes.length} image(s) ? Cette action est irréversible.`);
                            if (!confirmed) {
                                e.preventDefault();
                            }
                        }
                    });
                });
            </script>

            <!-- Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="bg-amber-600 text-white px-6 py-2 rounded-md hover:bg-amber-700 transition-colors">
                    Mettre à jour le produit
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>