<?php

namespace App\Models;

use App\Mail\AccountCreatedWithReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'email',
        'telephone',
        'filiere',
        'niveau',
        'user_id',
    ];

    public function memoires()
    {
        return $this->hasMany(Memoire::class);
    }


    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
    public function soutenances()
    {
        return $this->hasMany(Soutenance::class);
    }

    public function recuPaiements()
    {
        return $this->hasMany(RecuPaiement::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createWithUser(array $data): self
    {
        $email = $data['email'];

        if (User::where('email', $email)->exists() ||
            Student::where('email', $email)->exists() ||
            Teacher::where('email', $email)->exists()) {
            throw ValidationException::withMessages(['email' => 'Cet email est déjà utilisé.']);
        }

        return DB::transaction(function () use ($data, $email) {
            $user = User::create([
                'name' => $data['nom'] . ' ' . $data['prenom'],
                'email' => $email,
                'password' => bcrypt(uniqid()),
                'role' => 'student',
            ]);

            $resetUrl = Password::createToken($user);
            $resetLink = route('password.reset', ['token' => $resetUrl, 'email' => $email]);

            Mail::send(new AccountCreatedWithReset(
                name: $data['nom'] . ' ' . $data['prenom'],
                email: $email,
                resetUrl: $resetLink,
                role: 'student'
            ));

            $data['user_id'] = $user->id;
            return self::create($data);
        });
    }
}
