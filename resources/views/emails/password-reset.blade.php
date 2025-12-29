<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de votre mot de passe - WoodShop</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            padding: 30px;
            text-align: center;
        }
        .logo {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            color: #d97706;
            margin-bottom: 16px;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 30px;
            line-height: 1.7;
        }
        .button {
            display: inline-block;
            background: #d97706;
            color: white;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
            transition: background-color 0.2s;
        }
        .button:hover {
            background: #b45309;
        }
        .security-note {
            background: #fef3cd;
            border: 1px solid #fbbf24;
            border-radius: 6px;
            padding: 16px;
            margin: 30px 0;
        }
        .security-note h3 {
            color: #92400e;
            margin: 0 0 8px 0;
            font-size: 16px;
        }
        .security-note p {
            color: #92400e;
            margin: 0;
            font-size: 14px;
        }
        .footer {
            background: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
        .footer a {
            color: #d97706;
            text-decoration: none;
        }
        .expiry {
            color: #ef4444;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">W</div>
            <h1>WoodShop</h1>
        </div>
        
        <div class="content">
            <p class="greeting">Bonjour {{ $user->name }},</p>
            
            <div class="message">
                <p>Vous avez demandé la réinitialisation de votre mot de passe pour votre compte WoodShop.</p>
                
                <p>Cliquez sur le bouton ci-dessous pour définir un nouveau mot de passe :</p>
                
                <div style="text-align: center;">
                    <a href="{{ $resetUrl }}" class="button">Réinitialiser mon mot de passe</a>
                </div>
                
                <p>Si le bouton ne fonctionne pas, vous pouvez copier et coller ce lien dans votre navigateur :</p>
                <p style="word-break: break-all; background: #f3f4f6; padding: 12px; border-radius: 4px; font-family: monospace; font-size: 12px;">{{ $resetUrl }}</p>
            </div>
            
            <div class="security-note">
                <h3>🔒 Note de sécurité</h3>
                <p><strong class="expiry">Ce lien expire dans 1 heure</strong> pour votre sécurité.</p>
                <p style="margin-top: 8px;">Si vous n'avez pas demandé cette réinitialisation, ignorez simplement cet email. Votre mot de passe actuel reste inchangé.</p>
            </div>
            
            <p>Si vous avez des questions, n'hésitez pas à nous contacter.</p>
            
            <p>Cordialement,<br>L'équipe WoodShop</p>
        </div>
        
        <div class="footer">
            <p>Cet email a été envoyé par <a href="{{ config('app.url') }}">WoodShop</a></p>
            <p style="margin-top: 8px;">© {{ date('Y') }} WoodShop. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>