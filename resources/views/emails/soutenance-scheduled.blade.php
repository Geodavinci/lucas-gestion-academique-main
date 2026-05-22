<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f59e0b; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; background: #f59e0b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 20px; }
        .info-box { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #f59e0b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Votre Soutenance est Programmée</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $student->nom }} {{ $student->prenom }}</strong>,</p>

            <p>Votre soutenance de mémoire a été programmée. Veuillez noter les détails ci-dessous.</p>

            <div class="info-box">
                <p><strong>Titre du mémoire:</strong> {{ $soutenance->memoire->titre ?? 'Non spécifié' }}</p>
                <p><strong>Date et heure:</strong> <strong style="color: #f59e0b;">{{ $soutenance->date_soutenance->format('d/m/Y à H:i') }}</strong></p>
                <p><strong>Lieu:</strong> {{ $soutenance->lieu }}</p>
            </div>

            <p><strong>Jury:</strong></p>
            <ul>
                @if($soutenance->directeurMemoire)
                    <li>Directeur: {{ $soutenance->directeurMemoire->nom }} {{ $soutenance->directeurMemoire->prenom }}</li>
                @endif
                @if($soutenance->evaluateur)
                    <li>Évaluateur: {{ $soutenance->evaluateur->nom }} {{ $soutenance->evaluateur->prenom }}</li>
                @endif
                @if($soutenance->presidentJury)
                    <li>Président du jury: {{ $soutenance->presidentJury->nom }} {{ $soutenance->presidentJury->prenom }}</li>
                @endif
            </ul>

            <p>Préparez-vous bien pour cette présentation importante!</p>

            <center>
                <a href="{{ route('soutenances.show', $soutenance) }}" class="button">Voir les détails</a>
            </center>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

            <p>Bonne chance pour votre soutenance!</p>
        </div>

        <div class="footer">
            <p>© 2026 Lucas Gestion Académique - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
