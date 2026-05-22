<?php

namespace App\Models;

use App\Mail\AccountCreatedWithReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'specialite',
        'user_id',
    ];

    public function soutenancesAsDirecteur()
    {
        return $this->hasMany(Soutenance::class, 'directeur_memoire_id');
    }

    public function soutenancesAsEvaluateur()
    {
        return $this->hasMany(Soutenance::class, 'evaluateur_id');
    }

    public function soutenancesAsPresident()
    {
        return $this->hasMany(Soutenance::class, 'president_jury_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createWithUser(array $data): self
    {
        $email = $data['email'] ?? null;

        if ($email) {
            if (User::where('email', $email)->exists() ||
                Student::where('email', $email)->exists() ||
                self::where('email', $email)->exists()) {
                throw ValidationException::withMessages(['email' => 'Cet email est déjà utilisé.']);
            }
        }

        return DB::transaction(function () use ($data, $email) {
            if ($email) {
                $user = User::create([
                    'name' => $data['nom'] . ' ' . $data['prenom'],
                    'email' => $email,
                    'password' => bcrypt(uniqid()),
                    'role' => 'teacher',
                ]);

                $resetUrl = Password::createToken($user);
                $resetLink = route('password.reset', ['token' => $resetUrl, 'email' => $email]);

                Mail::send(new AccountCreatedWithReset(
                    name: $data['nom'] . ' ' . $data['prenom'],
                    email: $email,
                    resetUrl: $resetLink,
                    role: 'teacher'
                ));

                $data['user_id'] = $user->id;
            }

            return self::create($data);
        });
    }
}
