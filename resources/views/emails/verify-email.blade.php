<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmez votre adresse email - WoodShop Pro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #d97706;
            padding-bottom: 20px;
        }
        .logo {
            background-color: #d97706;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .btn {
            background-color: #d97706;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            display: inline-block;
            font-weight: bold;
            margin: 20px 0;
        }
        .btn:hover {
            background-color: #b45309;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e5e5;
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .warning {
            background-color: #fffbeb;
            border-left: 4px solid #d97706;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">W</div>
            <h1>WoodShop Pro</h1>
            <p>Votre spécialiste en bois de chauffage et cuisson</p>
        </div>

        <!-- Content -->
        <h2>Bienvenue {{ $user->name }} !</h2>
        
        <p>Merci de vous être inscrit sur <strong>WoodShop Pro</strong> ! 
        @if($user->isProfessional())
            Votre compte professionnel est presque prêt.
        @else
            Votre compte particulier est presque prêt.
        @endif
        </p>

        <p>Pour finaliser votre inscription et accéder à tous nos services, veuillez entrer le code de vérification ci-dessous sur notre site :</p>

        <div style="text-align: center; background-color: #f3f4f6; padding: 30px; margin: 20px 0; border-radius: 10px;">
            <p style="font-size: 14px; color: #6b7280; margin-bottom: 10px;">Votre code de vérification :</p>
            <div style="font-size: 32px; font-weight: bold; color: #d97706; letter-spacing: 8px; font-family: monospace;">
                {{ $verificationCode }}
            </div>
        </div>

        <div class="warning">
            <h3>⏰ Important :</h3>
            <ul>
                <li>Ce code est valide pendant <strong>15 minutes</strong></li>
                <li>Saisissez-le sur la page de vérification de notre site</li>
                <li>Une fois confirmé, vous pourrez commander et accéder à votre espace client</li>
                @if($user->isProfessional())
                <li>Votre compte professionnel bénéficiera automatiquement des <strong>prix dégressifs</strong></li>
                @endif
            </ul>
        </div>

        <!-- Avantages -->
        <h3>Ce qui vous attend :</h3>
        <ul>
            @if($user->isProfessional())
                <li>🏢 <strong>Prix professionnels dégressifs</strong></li>
                <li>📋 <strong>Facturation adaptée</strong> avec conditions de paiement</li>
                <li>🚚 <strong>Livraison programmée</strong> pour vos besoins</li>
                <li>📞 <strong>Support dédié</strong> aux professionnels</li>
            @else
                <li>🛒 <strong>Commandes faciles</strong> et suivi en temps réel</li>
                <li>📦 <strong>Livraison soignée</strong> à domicile</li>
                <li>🔥 <strong>Bois de qualité</strong> séché < 20% d'humidité</li>
                <li>💯 <strong>Satisfaction garantie</strong></li>
            @endif
        </ul>

        <!-- Instructions -->
        <p style="text-align: center; margin: 20px 0;">
            <a href="{{ url('/') }}" style="color: #d97706; text-decoration: none; font-weight: bold;">
                👉 Retourner sur WoodShop Pro pour saisir le code
            </a>
        </p>

        <!-- Footer -->
        <div class="footer">
            <p><strong>WoodShop Pro</strong> - Votre spécialiste bois de chauffage et cuisson</p>
            <p>Cet email a été envoyé à {{ $user->email }} suite à votre inscription sur notre site.</p>
            <p>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.</p>
        </div>
    </div>
</body>
</html>