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
                            @foreach(['chene', 'hetre', 'charme', 'fruitiers', 'frene', 'erable', 'bouleau', 'chataignier', 'aulne', 'tilleul', 'peuplier', 'melange_dur', 'melange_tendre'] as $wood)
                                <option value="{{ $wood }}" {{ old('wood_type') === $wood ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $wood)) }}
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
                        <select name="packaging" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Sélectionnez le conditionnement</option>
                            @foreach(['stere', 'palette', 'sac', 'vrac'] as $pkg)
                                <option value="{{ $pkg }}" {{ old('packaging') === $pkg ? 'selected' : '' }}>
                                    {{ ucfirst($pkg) }}
                                </option>
                            @endforeach
                        </select>
                        @error('packaging')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Usage -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Usage *</label>
                        <select name="usage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                            <option value="">Sélectionnez l'usage</option>
                            @foreach(['chauffage', 'cuisson', 'mixte'] as $use)
                                <option value="{{ $use }}" {{ old('usage') === $use ? 'selected' : '' }}>
                                    {{ ucfirst($use) }}
                                </option>
                            @endforeach
                        </select>
                        @error('usage')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Prix particulier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix particulier (€) *</label>
                        <input type="number" name="price_particular" value="{{ old('price_particular') }}" 
                               step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('price_particular')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Prix professionnel -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prix professionnel (€) *</label>
                        <input type="number" name="price_professional" value="{{ old('price_professional') }}" 
                               step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('price_professional')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock *</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" 
                               min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Quantité minimale -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantité minimale *</label>
                        <input type="number" name="min_quantity" value="{{ old('min_quantity', 1) }}" 
                               min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500" required>
                        @error('min_quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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

            <!-- Images -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium mb-4">Images du produit</h3>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ajouter des images</label>
                    <input type="file" name="images[]" multiple accept="image/*" 
                           class="mt-1 block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-amber-50 file:text-amber-700
                                  hover:file:bg-amber-100">
                    <p class="text-xs text-gray-500 mt-1">
                        Formats acceptés: JPG, PNG, WebP. Taille max: 2MB par image. 
                        <strong>Conseil:</strong> Ajoutez plusieurs photos pour une meilleure présentation.
                    </p>
                    @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

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