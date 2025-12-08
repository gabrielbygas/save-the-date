<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Votre code OTP pour Save The Date RDC</title>
    <style>
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #fff;
            max-width: 600px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
            padding: 40px 30px;
        }

        .header {
            text-align: center;
            padding-bottom: 24px;
        }

        .header h1 {
            color: #6c63ff;
            margin: 0;
            font-size: 2rem;
        }

        .header p {
            color: #666;
            font-size: 1.1rem;
            margin-top: 8px;
        }

        .otp-details {
            margin: 32px 0;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 24px;
            text-align: center;
        }

        .otp-details h2 {
            margin-top: 0;
            color: #6c63ff;
            font-size: 1.2rem;
        }

        .otp-code {
            font-size: 2.5rem;
            font-weight: bold;
            letter-spacing: 8px;
            color: #6c63ff;
            margin: 20px 0;
            padding: 16px;
            background: rgba(108, 99, 255, 0.1);
            border-radius: 8px;
            display: inline-block;
        }

        .instructions {
            margin-top: 24px;
            text-align: center;
            color: #555;
        }

        .instructions p {
            margin: 8px 0;
        }

        .footer {
            text-align: center;
            color: #aaa;
            font-size: 0.95rem;
            margin-top: 32px;
        }

        .highlight {
            font-weight: bold;
            color: #6c63ff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Votre code OTP</h1>
            <p>Accès sécurisé à votre album Save The Date RDC</p>
        </div>

        <div class="otp-details">
            <h2>Code de vérification</h2>
            <p>Voici votre code OTP pour accéder à vos albums :</p>
            <div class="otp-code">{{ $otp->otp }}</div>
            <div class="instructions">
                <p>Ce code est valable pour <span class="highlight"> 10 minutes</span>.</p>
                <p>Ne le partagez avec personne pour des raisons de sécurité.</p>
            </div>
        </div>

        <div class="instructions">
            <p>Si vous n'avez pas demandé ce code, veuillez ignorer cet email.</p>
            <p>Pour toute question, contactez notre équipe à <a
                    href="mailto:support@savethedate-rdc.com">support@savethedate-rdc.com</a>.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Save The Date RDC. Tous droits réservés.<br>
            <small>Ce message a été envoyé automatiquement. Merci de ne pas y répondre.</small>
        </div>
    </div>
</body>

</html>
