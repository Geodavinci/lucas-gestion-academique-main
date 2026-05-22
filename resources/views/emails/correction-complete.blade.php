<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #8b5cf6; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; background: #8b5cf6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 20px; }
        .info-box { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #8b5cf6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✍️ Votre Mémoire a Été Révisé</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $student->nom }} {{ $student->prenom }}</strong>,</p>

            <p>La révision de votre mémoire est terminée. Veuillez consulter les commentaires et suggestions.</p>

            <div class="info-box">
                <p><strong>Titre du mémoire:</strong> {{ $memoire->titre }}</p>
                <p><strong>Statut:</strong> <strong style="color: #8b5cf6;">{{ $memoire->statut ?? 'Non spécifié' }}</strong></p>
                <p><strong>Revu le:</strong> {{ $memoire->updated_at->format('d/m/Y H:i') }}</p>
            </div>

            <p>Consultez votre mémoire pour voir les notes et commentaires du directeur.</p>

            <center>
                <a href="{{ route('memoires.show', $memoire) }}" class="button">Consulter le mémoire</a>
            </center>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

            <p>Si vous avez des questions, n'hésitez pas à contacter votre directeur.</p>
        </div>

        <div class="footer">
            <p>© 2026 Lucas Gestion Académique - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
