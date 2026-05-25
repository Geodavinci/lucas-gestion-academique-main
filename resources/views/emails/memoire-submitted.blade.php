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
        .info-box { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #3b82f6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Nouveau Mémoire à Réviser</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $director->nom }} {{ $director->prenom }}</strong>,</p>

            <p><strong>{{ $student->nom }} {{ $student->prenom }}</strong> a soumis un mémoire pour révision.</p>

            <div class="info-box">
                <p><strong>Titre du mémoire:</strong><br>{{ $memoire->titre }}</p>
                <p><strong>Soumis le:</strong> {{ $memoire->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <p>Veuillez consulter le mémoire pour revue et fournir vos commentaires.</p>

            <center>
                <a href="{{ route('memoires.show', $memoire) }}" class="button">Voir le mémoire</a>
            </center>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

            <p>Merci pour votre collaboration.</p>
        </div>

        <div class="footer">
            <p>© 2026 Lucas Gestion Académique - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
