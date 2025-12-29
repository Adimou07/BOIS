<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Notifications\CustomVerifyEmail;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'type' => 'required|in:individual,professional',
            'company_name' => 'required_if:type,professional|string|max:255|nullable',
            'siret' => 'required_if:type,professional|string|size:14|nullable',
            'phone' => 'nullable|string|max:20',
            'terms' => 'required|accepted'
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'type.required' => 'Le type de compte est obligatoire.',
            'company_name.required_if' => 'Le nom d\'entreprise est obligatoire pour un compte professionnel.',
            'siret.required_if' => 'Le SIRET est obligatoire pour un compte professionnel.',
            'siret.size' => 'Le SIRET doit contenir exactement 14 chiffres.',
            'terms.required' => 'Vous devez accepter les conditions d\'utilisation.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'company_name' => $request->company_name,
            'siret' => $request->siret,
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        // Créer et envoyer le code de vérification
        $this->sendVerificationCode($user);

        // Connecter l'utilisateur pour qu'il puisse accéder à la page de vérification
        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Votre compte a été créé ! Un code de vérification a été envoyé à votre email.');
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            if (!$user->is_active) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'Votre compte est désactivé. Contactez le support.']);
            }

            $message = $user->isProfessional() 
                ? 'Connexion réussie ! Bienvenue dans votre espace professionnel.'
                : 'Connexion réussie ! Bienvenue sur WoodShop Pro.';

            return redirect()->intended(route('catalog.index'))
                ->with('success', $message);
        }

        return redirect()->back()
            ->withErrors(['email' => 'Les identifiants sont incorrects.'])
            ->withInput($request->only('email'));
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalog.index')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }

    /**
     * Show user profile
     */
    public function profile()
    {
        return view('auth.profile');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'required_if:type,professional|string|max:255|nullable',
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'company_name.required_if' => 'Le nom d\'entreprise est obligatoire pour un compte professionnel.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
        ]);

        return redirect()->back()
            ->with('success', 'Votre profil a été mis à jour avec succès.');
    }

    /**
     * Verify email with code
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|string|size:6'
        ], [
            'verification_code.required' => 'Le code de vérification est obligatoire.',
            'verification_code.size' => 'Le code doit contenir exactement 6 chiffres.'
        ]);

        $user = Auth::user();
        $code = $request->verification_code;

        if (EmailVerificationCode::verifyCode($user, $code)) {
            // Marquer l'email comme vérifié
            $user->email_verified_at = now();
            $user->save();

            return redirect()->route('catalog.index')
                ->with('success', 'Email vérifié avec succès ! Bienvenue sur WoodShop Pro.');
        }

        return redirect()->back()
            ->withErrors(['verification_code' => 'Code invalide ou expiré. Veuillez demander un nouveau code.'])
            ->withInput();
    }

    /**
     * Resend verification code
     */
    public function resendCode(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('catalog.index')
                ->with('info', 'Votre email est déjà vérifié.');
        }

        $this->sendVerificationCode($user);

        return redirect()->back()
            ->with('status', 'verification-code-sent')
            ->with('success', 'Un nouveau code de vérification a été envoyé.');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.'
        ]);

        // Vérifier si l'utilisateur existe
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Aucun compte n\'est associé à cette adresse email.'])
                ->withInput();
        }

        // Créer un token unique
        $token = Str::random(64);
        
        // Supprimer les anciens tokens pour cet email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        
        // Créer un nouveau token
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        // Envoyer l'email avec le lien
        $this->sendPasswordResetEmail($user, $token);

        return redirect()->back()
            ->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
    }

    /**
     * Show reset password form
     */
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        // Vérifier le token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return redirect()->back()
                ->withErrors(['email' => 'Ce lien de réinitialisation est invalide ou expiré.'])
                ->withInput();
        }

        // Vérifier si le token n'est pas trop ancien (1 heure)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            return redirect()->back()
                ->withErrors(['email' => 'Ce lien de réinitialisation a expiré. Veuillez demander un nouveau lien.'])
                ->withInput();
        }

        // Mettre à jour le mot de passe
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Utilisateur non trouvé.'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Supprimer le token utilisé
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
    }

    /**
     * Send password reset email
     */
    private function sendPasswordResetEmail(User $user, $token)
    {
        $resetUrl = route('password.reset', ['token' => $token, 'email' => urlencode($user->email)]);
        
        $emailData = [
            'user' => $user,
            'resetUrl' => $resetUrl
        ];

        Mail::send('emails.password-reset', $emailData, function($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Réinitialisation de votre mot de passe - WoodShop Pro');
        });
    }

    /**
     * Send verification code to user
     */
    private function sendVerificationCode(User $user)
    {
        // Créer un nouveau code
        $verificationCode = EmailVerificationCode::createForUser($user);

        // Envoyer l'email avec le code
        $user->notify(new CustomVerifyEmail($verificationCode->code));
    }
}