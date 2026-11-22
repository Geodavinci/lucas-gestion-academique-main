<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
        .button { display: inline-block; background: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; color: #6b7280; font-size: 12px; margin-top: 20px; }
        .info-box { background: white; padding: 15px; margin: 15px 0; border-left: 4px solid #10b981; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👥 Assignation à un Jury</h1>
        </div>

        <div class="content">
            <p>Bonjour <strong>{{ $teacher->nom }} {{ $teacher->prenom }}</strong>,</p>

            <p>Vous avez été assigné au jury de soutenance de mémoire.</p>

            <div class="info-box">
                <p><strong>Étudiant:</strong> {{ $student->nom }} {{ $student->prenom }}</p>
                <p><strong>Titre du mémoire:</strong> {{ $soutenance->memoire->first()?->titre ?? 'Non spécifié' }}</p>
                <p><strong>Date et heure:</strong> {{ $soutenance->date_soutenance->format('d/m/Y à H:i') }}</p>
                <p><strong>Lieu:</strong> {{ $soutenance->lieu }}</p>
            </div>

            <p>Veuillez confirmer votre présence ou toute contrainte de calendrier.</p>

            <center>
                <a href="{{ route('soutenances.show', $soutenance) }}" class="button">Voir les détails</a>
            </center>

            <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;">

            <p>Merci pour votre disponibilité.</p>
        </div>

        <div class="footer">
            <p>© 2026 Lucas Gestion Académique - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
