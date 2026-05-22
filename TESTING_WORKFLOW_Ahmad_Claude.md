# 🧪 Workflow de Test Complet - Phase 1

## 🚀 Démarrage

```bash
# Terminal 1: Démarrer le serveur
php artisan serve

# Terminal 2: Démarrer Vite
npm run dev
```

L'app sera disponible sur: **http://localhost:8000**

---

## ✅ Test #1 - Comptes Utilisateurs Automatiques

### Step 1: Se connecter comme Admin
```
Email: admin@lucas.edu
Password: password
```

### Step 2: Créer un nouvel étudiant
1. Aller à: **Étudiants** → **Ajouter étudiant**
2. Remplir:
   - Matricule: `STU999`
   - Nom: `Dupont`
   - Prénom: `Jean`
   - Email: `jean.dupont.test@univ.edu`
   - Filière: `Informatique`
   - Niveau: `L3`
3. **Soumettre**
4. ✅ Vérifier message: "Étudiant enregistré avec succès. Un email d'activation a été envoyé."

### Step 3: Vérifier la création de l'utilisateur
**En développement, les emails vont dans les logs.**

1. Voir les logs:
```bash
php artisan tinker
> DB::table('users')->where('email', 'jean.dupont.test@univ.edu')->first();
```
✅ Doit retourner un user avec role='student'

### Step 4: Tester la liaison Student-User
```bash
> DB::table('students')->where('email', 'jean.dupont.test@univ.edu')->first();
```
✅ Doit avoir `user_id` rempli

---

## ✅ Test #2 - Notifications (Email + In-App)

### Step 1: Créer une notification de test
```bash
php artisan tinker

use App\Models\Notification;
use App\Models\User;

$user = User::where('email', 'admin@lucas.edu')->first();
Notification::create([
    'user_id' => $user->id,
    'type' => 'test',
    'title' => 'Test de notification 🔔',
    'message' => 'Ceci est un test du système de notifications',
    'data' => ['test' => true],
]);
exit;
```

### Step 2: Voir la cloche de notification
1. Recharger la page: **http://localhost:8000/app**
2. Regarder le header (haut à droite)
3. ✅ Doit voir 🔔 avec un badge rouge "1"

### Step 3: Cliquer sur la cloche
1. Voir le dropdown avec la notification
2. Cliquer dessus
3. ✅ Elle disparaît du badge
4. Aller à: **/notifications**
5. ✅ Voir la liste complète

### Step 4: Marquer comme lu
1. Sur la page **/notifications**
2. Voir la notification
3. ✅ Badge vert "✓ Lu"

---

## ✅ Test #3 - Dashboard Analytique

### Step 1: Admin Dashboard
1. Se connecter comme admin
2. Aller à: **/dashboard**
3. ✅ Voir 5 KPI cards:
   - Étudiants
   - Enseignants
   - Mémoires
   - Soutenances
   - À venir (30j)

### Step 2: Graphiques
Sur la même page:
1. ✅ **Graphique 1**: Mémoires par filière (Bar chart)
2. ✅ **Graphique 2**: Mémoires par niveau (Bar chart)
3. ✅ **Graphique 3**: Répartition des étudiants (Pie chart)
4. ✅ **Graphique 4**: Soutenances par mois (Line chart)
5. ✅ **Graphique 5**: Charge de travail enseignants (Bar chart)

### Step 3: Teacher Dashboard
1. Créer un enseignant avec email et user (voir Test #1)
2. Se déconnecter et se reconnecter avec l'email du prof
3. Aller à: **/dashboard**
4. ✅ Voir stats personnelles:
   - Nombre de soutenances comme directeur
   - Nombre comme évaluateur
   - Nombre comme président
   - Total

### Step 4: Student Dashboard
1. Se reconnecter comme l'étudiant créé (voir Test #1)
2. Aller à: **/dashboard** (ou **/mon-dossier**)
3. ✅ Voir:
   - Ses mémoires (count)
   - Ses soutenances (count)
   - Prochaine soutenance (si existe)
   - Liste de ses mémoires
   - Quick links

---

## ✅ Test #4 - Workflow d'Approbation des Mémoires

### Step 1: Créer un mémoire
1. Admin → **Mémoires** → **Ajouter mémoire**
2. Remplir:
   - Titre: "Mon Premier Mémoire"
   - Année: 2026
   - Étudiant: Jean Dupont (créé en Test #1)
   - Fichier PDF: (n'importe quel PDF)
3. Soumettre
4. ✅ Voir badge: 📝 **Brouillon**

### Step 2: Voir le mémoire
1. Cliquer sur le mémoire dans la liste
2. Aller à: **/memoires/{id}**
3. ✅ Voir:
   - Titre du mémoire
   - Étudiant
   - Status badge (Brouillon)
   - Historique vide

### Step 3: Soumettre le mémoire
1. En tant qu'admin (simulant l'étudiant):
2. Bouton: **📤 Soumettre pour révision**
3. ✅ Status change à: 📤 **Soumis**
4. ✅ Historique affiche: "📤 Soumis par Admin"

### Step 4: Réviser le mémoire
1. Admin ouvre le mémoire
2. ✅ Status change à: 👀 **En révision**
3. Voir le panneau bleu "🔍 Panneau d'examen"

### Step 5: Demander des corrections
1. Dans le panneau bleu
2. Remplir "Demander des corrections":
   - Texte: "Améliorer l'introduction, ajouter plus de références"
3. Cliquer: **⚠️ Demander des corrections**
4. ✅ Status → ✏️ **Corrections demandées**
5. ✅ Historique affiche: "✏️ Corrections demandées"
6. ✅ Notes visibles: "Améliorer l'introduction..."

### Step 6: Resubmission après corrections
1. Admin (simulant l'étudiant) peut modifier
2. Soumettre à nouveau: **📤 Soumettre pour révision**
3. ✅ Status → 📤 **Soumis**
4. ✅ Version passe de 1 à 2

### Step 7: Approuver
1. Admin révise à nouveau
2. Bouton: **✅ Approuver**
3. ✅ Status → ✅ **Approuvé**
4. ✅ Historique complet visible avec timeline

### Step 8: Vérifier l'historique
1. Scroller vers le bas
2. ✅ Voir la section **📜 Historique des modifications**
3. ✅ Voir tous les changements:
   - Création
   - Soumission
   - En révision
   - Corrections demandées
   - Resoumission
   - Approbation

### Step 9: Reject alternative
1. Créer un autre mémoire
2. Soumettre
3. Au lieu d'approuver, cliquer: **❌ Rejeter**
4. Ajouter raison: "Document insuffisant"
5. ✅ Status → ❌ **Rejeté**
6. ✅ Notes affichent la raison

---

## 🎯 Checklist de Validation

- [ ] ✅ Étudiant créé automatiquement avec user
- [ ] ✅ Enseignant créé automatiquement avec user
- [ ] ✅ Notification créée et visible (cloche)
- [ ] ✅ Notification dans la liste complète
- [ ] ✅ Admin dashboard avec 5 KPIs
- [ ] ✅ Admin dashboard avec 5 graphiques
- [ ] ✅ Teacher dashboard avec stats personnelles
- [ ] ✅ Student dashboard avec ses mémoires
- [ ] ✅ Mémoire créé en état Brouillon
- [ ] ✅ Mémoire peut être soumis
- [ ] ✅ Status change à "Soumis"
- [ ] ✅ Status change à "En révision" automatiquement
- [ ] ✅ Admin peut demander des corrections
- [ ] ✅ Historique affiche les modifications
- [ ] ✅ Admin peut approuver
- [ ] ✅ Admin peut rejeter
- [ ] ✅ Version du mémoire increment

---

## 💾 SQL Utiles pour Tester

```bash
php artisan tinker

# Voir tous les utilisateurs
> DB::table('users')->get();

# Voir les notifications
> DB::table('notifications')->where('user_id', 1)->get();

# Voir les mémoires
> DB::table('memoires')->get();

# Voir l'historique d'un mémoire
> DB::table('memoire_history')->where('memoire_id', 1)->get();

# Réinitialiser (pour refaire les tests)
> DB::table('notifications')->delete();
> DB::table('memoire_history')->delete();
> DB::table('memoires')->delete();
```

---

## 🐛 Troubleshooting

**Graphiques ne s'affichent pas?**
```bash
npm run build
```

**Emails n'arrivent pas?**
- En dev, ils vont dans `storage/logs/`
- Check: `tail -f storage/logs/laravel.log`

**User-Student pas liés?**
```bash
php artisan app:create-users-for-existing-students-teachers
```

**Besoin de réinitialiser?**
```bash
php artisan migrate:fresh --seed
php artisan db:seed
```

---

## ✨ Bon testing ! 🎉
