<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'specialite',
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

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
