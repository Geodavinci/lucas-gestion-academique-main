<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue sur Lucas Gestion Académique!</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $name }}</strong>,</p>

            <p>Un compte {{ match($role) { 'student' => 'd\'étudiant', 'teacher' => 'd\'enseignant', default => 'utilisateur' } }} a été créé pour vous.</p>

            <p><strong>Email:</strong> {{ $email }}</p>

            <p>Pour vous connecter, veuillez d'abord définir votre mot de passe en cliquant le lien ci-dessous:</p>

            <center>
                <a href="{{ $resetUrl }}" class="button">Définir mon mot de passe</a>
            </center>

            <p>Ce lien expirera dans 60 minutes.</p>

            <p>Si vous n'avez pas demandé la création de ce compte, veuillez ignorer cet email.</p>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

            <p><strong>Besoin d'aide?</strong></p>
            <p>Si vous rencontrez des problèmes, contactez votre administrateur.</p>
        </div>

        <div class="footer">
            <p>© 2026 Lucas Gestion Académique - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
