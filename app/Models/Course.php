<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'filiere_id',
        'nom',
        'code',
        'coefficient',
        'semestre',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class)->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
