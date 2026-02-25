<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'filiere_id',
        'annee_academique',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }
}
