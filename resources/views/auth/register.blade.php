@extends('layouts.app')

@section('title', 'Inscription - WoodShop Pro')
@section('meta_description', 'Créez votre compte WoodShop Pro pour commander du bois de qualité en ligne.')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->
        <div class="flex justify-center">
            <div class="w-12 h-12 bg-amber-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-lg">W</span>
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
            Créer un compte
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Ou
            <a href="{{ route('login') }}" class="font-medium text-amber-600 hover:text-amber-500">
                connectez-vous à votre compte existant
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form method="POST" action="{{ route('register') }}" x-data="registrationForm()">
                @csrf

                <!-- Type de compte -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Type de compte
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative">
                            <input type="radio" name="type" value="individual" 
                                   x-model="accountType" 
                                   {{ old('type') === 'individual' ? 'checked' : '' }}
                                   class="sr-only">
                            <div class="flex items-center justify-center px-4 py-3 border rounded-lg cursor-pointer transition-colors"
                                 :class="accountType === 'individual' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                                <div class="text-center">
                                    <div class="text-sm font-medium">Particulier</div>
                                    <div class="text-xs text-gray-500">Usage personnel</div>
                                </div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="type" value="professional" 
                                   x-model="accountType"
                                   {{ old('type') === 'professional' ? 'checked' : '' }}
                                   class="sr-only">
                            <div class="flex items-center justify-center px-4 py-3 border rounded-lg cursor-pointer transition-colors"
                                 :class="accountType === 'professional' ? 'border-amber-500 bg-amber-50 text-amber-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                                <div class="text-center">
                                    <div class="text-sm font-medium">Professionnel</div>
                                    <div class="text-xs text-gray-500">Restaurant, pizzeria</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        <span x-show="accountType === 'individual'">Nom complet</span>
                        <span x-show="accountType === 'professional'">Nom du responsable</span>
                    </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champs professionnels -->
                <div x-show="accountType === 'professional'" x-transition class="space-y-4 mb-4">
                    <!-- Nom entreprise -->
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700">
                            Nom de l'entreprise *
                        </label>
                        <div class="mt-1">
                            <input id="company_name" name="company_name" type="text" value="{{ old('company_name') }}"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SIRET -->
                    <div>
                        <label for="siret" class="block text-sm font-medium text-gray-700">
                            N° SIRET *
                        </label>
                        <div class="mt-1">
                            <input id="siret" name="siret" type="text" value="{{ old('siret') }}" 
                                   maxlength="14" placeholder="14 chiffres"
                                   class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        @error('siret')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Adresse email
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        Téléphone (optionnel)
                    </label>
                    <div class="mt-1">
                        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" 
                               placeholder="01 23 45 67 89"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Mot de passe
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmer le mot de passe
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <!-- CGU -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" required
                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-900">
                            J'accepte les <a href="#" class="text-amber-600 hover:text-amber-500">conditions d'utilisation</a> 
                            et la <a href="#" class="text-amber-600 hover:text-amber-500">politique de confidentialité</a>
                        </label>
                    </div>
                    @error('terms')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Créer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function registrationForm() {
    return {
        accountType: '{{ old("type", "individual") }}'
    }
}
</script>
@endpush
@endsection