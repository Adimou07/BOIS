@extends('layouts.app')

@section('title', 'Vérifiez votre email - WoodShop')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
            Entrez votre code de vérification
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <!-- Success message -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                Un nouvel email de vérification a été envoyé !
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Instructions -->
            <div class="text-center mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Un code de vérification a été envoyé !
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Vérifiez votre email et entrez le code à 6 chiffres :<br>
                    <strong class="text-gray-900">{{ auth()->user()->email }}</strong>
                </p>
            </div>

            <!-- Formulaire de saisie du code -->
            <form method="POST" action="{{ route('verification.verify-code') }}" class="mb-6" x-data="{ code: '' }">
                @csrf
                <div class="text-center">
                    <label for="verification_code" class="block text-sm font-medium text-gray-700 mb-3">
                        Entrez le code reçu par email
                    </label>
                    
                    <!-- Code input -->
                    <div class="flex justify-center mb-4">
                        <input type="text" 
                               id="verification_code" 
                               name="verification_code" 
                               x-model="code"
                               maxlength="6" 
                               placeholder="000000"
                               class="w-32 text-center text-2xl font-mono tracking-wider border-2 border-amber-300 rounded-lg py-3 focus:border-amber-500 focus:ring-amber-500"
                               required
                               autofocus>
                    </div>
                    
                    @error('verification_code')
                        <p class="text-red-600 text-sm mb-3">{{ $message }}</p>
                    @enderror
                    
                    <!-- Submit button -->
                    <button type="submit" 
                            :disabled="code.length !== 6"
                            :class="code.length === 6 ? 'bg-amber-600 hover:bg-amber-700' : 'bg-gray-400 cursor-not-allowed'"
                            class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Vérifier mon compte
                    </button>
                </div>
            </form>

            <!-- Actions alternatives -->
            <div class="mt-6">
                <!-- Renvoyer code -->
                <form method="POST" action="{{ route('verification.resend-code') }}">
                    @csrf
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        Renvoyer un nouveau code
                    </button>
                </form>
            </div>


            @if(auth()->user()->isProfessional())
            <!-- Avantages pro -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h4 class="text-sm font-medium text-blue-800 mb-2">🏢 Votre compte professionnel :</h4>
                <ul class="text-xs text-blue-700 space-y-1">
                    <li>• Prix dégressifs automatiques</li>
                    <li>• Facturation adaptée aux entreprises</li>
                    <li>• Support dédié aux professionnels</li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection