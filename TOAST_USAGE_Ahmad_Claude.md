# 🍞 Système de Notifications (Toasts)

## Vue d'ensemble

Le système de toasts offre des notifications visuelles élégantes pour les actions utilisateur. Les toasts s'affichent automatiquement dans le coin inférieur droit de l'écran et se ferment après 4-5 secondes.

## Types de Toasts

- **Success** (Vert) - Actions réussies
- **Error** (Rouge) - Erreurs et validations
- **Info** (Bleu) - Informations générales
- **Warning** (Amber) - Avertissements

## Utilisation

### 1. Via les Messages de Session (Automatique)

Les toasts s'affichent automatiquement après une redirection si vous définissez des messages en session:

#### Dans un Contrôleur:

```php
// Création réussie
return redirect()->route('students.index')
    ->with('success', 'Étudiant enregistré avec succès.');

// Erreur
return redirect()->route('students.index')
    ->with('error', 'Une erreur s\'est produite.');
```

Les messages d'erreur de validation s'affichent aussi automatiquement:

```php
return back()
    ->withErrors($validator)
    ->withInput();
```

### 2. Via JavaScript (Côté Client)

#### Utiliser l'objet Global `toast`:

```javascript
// Succès
toast.success('Succès!', 'Opération réussie');

// Erreur
toast.error('Erreur!', 'Une erreur s\'est produite');

// Info
toast.info('Information', 'Ceci est un message informatif');

// Avertissement
toast.warning('Attention', 'Ceci est un avertissement');
```

#### Exemple avec Paramètres:

```javascript
// Succès avec durée personnalisée (en ms)
toast.success('Enregistré!', 'Les modifications ont été sauvegardées', 3000);

// Erreur avec longue durée
toast.error('Erreur serveur', 'Veuillez réessayer plus tard', 6000);
```

### 3. Via Événement Custom (Avancé):

```javascript
document.dispatchEvent(new CustomEvent('notify', {
    detail: {
        id: Math.random(),
        type: 'success',        // success | error | info | warning
        title: 'Succès!',
        message: 'Message détaillé',
        duration: 4000          // ms
    }
}));
```

## Fonctionnalités

✅ **Animations Fluides** - Slide-up avec fade
✅ **Fermeture Automatique** - 4-5 secondes selon le type
✅ **Fermeture Manuelle** - Bouton X visible
✅ **Barre de Progression** - Visualise le temps restant
✅ **Multiple Toasts** - Peut en afficher plusieurs
✅ **Icons Détaillées** - Icons visuels pour chaque type
✅ **Responsive** - Adapt à tous les écrans

## Durées par Défaut

- **Success/Info**: 4000ms (4s)
- **Error/Warning**: 5000ms (5s)

## Styling

Les toasts utilisent les couleurs Tailwind de l'application:
- Success: Green 500-800
- Error: Red 500-800
- Info: Blue 500-800
- Warning: Amber 500-800

## Composant

Le composant Toast est inclus dans:
- `resources/views/components/toast.blade.php`

Il est automatiquement inclus dans:
- `resources/views/layouts/app.blade.php` (tous les pages authentifiées)

## Exemple Complet

### Dans un Blade Template:

```html
<form method="POST" action="{{ route('students.store') }}">
    @csrf

    <input type="text" name="nom" required>
    <input type="email" name="email" required>

    <button type="submit">Enregistrer</button>
</form>

<!-- Le formulaire affichera automatiquement un toast de succès après soumission -->
```

### Dans un Contrôleur:

```php
public function store(Request $request)
{
    try {
        $student = Student::create($request->validated());

        return redirect()->route('students.show', $student)
            ->with('success', 'Étudiant créé avec succès!');
    } catch (\Exception $e) {
        return back()
            ->with('error', 'Une erreur s\'est produite.')
            ->withInput();
    }
}
```

## Affichage des Erreurs

Les erreurs de validation s'affichent automatiquement comme des toasts:

```php
// Dans le contrôleur
$validator = Validator::make($data, [
    'email' => 'required|email|unique:users',
    'nom' => 'required|string|max:255',
]);

if ($validator->fails()) {
    return back()
        ->withErrors($validator)
        ->withInput();
}
```

Chaque erreur de validation affichera un toast séparé d'erreur.

## API Complète

```javascript
// Créer un toast personnalisé
showToast(type, title, message, duration)

// Utiliser l'objet toast
toast.success(title, message, duration)
toast.error(title, message, duration)
toast.info(title, message, duration)
toast.warning(title, message, duration)
```

## Notes Importantes

1. **Session Messages** - Les messages de session doivent être définis dans le contrôleur avec `.with()`
2. **Global Toast** - L'objet `toast` est disponible globalement via `window.toast`
3. **Affichage Auto** - Les toasts de session s'affichent automatiquement au chargement de page
4. **Multiple Toasts** - Jusqu'à 10 toasts peuvent s'afficher simultanément
5. **Accessibilité** - Les toasts ont les bonnes couleurs et contrastes pour l'accessibilité

## Dépannage

### Les toasts n'apparaissent pas?
- Vérifiez que le composant `<x-toast />` est inclus dans le layout
- Vérifiez les erreurs console (F12 > Console)
- Assurez-vous que Alpine.js est chargé

### Les messages de session n'apparaissent pas?
- Vérifiez que le redirected a `.with('success', '...')`
- Vérifiez que le layout inclut le script des toasts

### Les toasts disparaissent trop vite?
- Ajustez le paramètre `duration` (en millisecondes)
- Par défaut: 4000ms pour success/info, 5000ms pour error/warning
