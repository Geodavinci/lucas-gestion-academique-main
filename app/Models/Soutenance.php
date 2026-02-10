<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soutenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_soutenance',
        'statut',
        'description',
        'student_id',
        'directeur_memoire_id',
        'evaluateur_id',
        'president_jury_id'
    ];

    

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function directeurMemoire()
    {
        return $this->belongsTo(Teacher::class, 'directeur_memoire_id');
    }

    public function evaluateurTeacher()
    {
        return $this->belongsTo(Teacher::class, 'evaluateur_id');
    }

    public function presidentJury()
    {
        return $this->belongsTo(Teacher::class, 'president_jury_id');
    }
}
